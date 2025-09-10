---
title: 'Model Architecture'
slug: alpha-account-model-architecture
is_home_page: false
documentation_group: Alpha
navigation_group: Account
navigation_sort: 3.0
created_at: 2025-09-10T01:54:47+00:00
updated_at: 2025-09-10T06:56:13+00:00
---

# Model Architecture

**I want to** have robust models that handle authentication and flexible credential management
**So that** the system can support multiple credential types while maintaining data integrity and extensibility

## Acceptance Criteria

- [x] Account model extends `Authenticatable` for Laravel authentication
- [x] Account implements `FilamentUser` for admin panel access
- [x] AccountCredential model stores flexible credential types (email, username)
- [x] Primary credential designation with uniqueness constraints
- [x] Trait-based architecture for clean separation of concerns
- [x] Validation rules for names and usernames with proper constraints
- [x] Search integration using Laravel Scout

## Technical Architecture

### Model Relationships & Design Patterns

**Account Model** (`modules/alpha/app/Models/Account.php`):

- Extends `Authenticatable` for Laravel authentication
- Implements `FilamentUser`, `HasDefaultTenant`, `HasTenants` for Filament integration
- Uses trait-based architecture for modular functionality
- Supports Laravel Scout for full-text search capabilities

**AccountCredential Model** (`modules/alpha/app/Models/AccountCredential.php`):

- Foreign key relationship to Account (`account_id`)
- Type-based credentials using `AccountCredentialTypesEnum` (email, username)
- Primary designation constraint: unique per account+type+is_primary
- Supports verification tracking with `verified_at` timestamps

### Core Traits

The Account model uses several traits for modular functionality. For comprehensive trait documentation,
see [Account Model Traits](alpha-account-traits.md).

**Key Traits**:

- **InteractsWithCredentials**: Flexible credential management (email, username)
- **InteractsWithTeams**: Multi-tenancy support
- **CausesActivity/LogsActivity**: Activity logging integration
- **HasRoles**: Role-based access control

### Credential Types

**AccountCredentialTypesEnum** (`modules/alpha/app/Enums/AccountCredentialTypesEnum.php`):

- `Username = 'username'`
- `Email = 'email'`

### Validation Rules

**ValidName** (`modules/alpha/app/Rules/ValidName.php`):

- ASCII characters only (A-Z, a-z, spaces)
- Must contain at least one letter (not just spaces)
- No special characters or numbers

**ValidUsername** (`modules/alpha/app/Rules/ValidUsername.php`):

- Length: 4-16 characters
- Must start with lowercase letter (a-z)
- Must end with letter or number
- Allowed characters: lowercase letters, numbers, periods, underscores
- No consecutive special characters (dots/underscores)

### Search Implementation

**Laravel Scout Integration**:

```php
public function toSearchableArray(): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'username' => $this->username->value,
        'email' => $this->email->value,
    ];
}
```

## Additional Architecture Features

*The following features are fully implemented but testing focuses on core Account/AccountCredential functionality:*

### Event-Driven Architecture

- Complete lifecycle events (Creating, Created, Updating, etc.)
- Observer pattern for business logic hooks
- Extensible event system for custom integrations

## Test Scenarios - Model Architecture

**Legend:**
- ✅ **Tested** - Explicitly tested in our test suite
- 🔧 **Framework** - Provided by Laravel/Filament framework (trusted)
- ⚠️ **Not Tested** - Should be tested but currently isn't
- ❌ **Deferred** - Intentionally not implemented/tested yet

*Note: Model architecture features are fully implemented with comprehensive direct unit tests covering all functionality.*

### Account Model Tests *(Status: ✅ Comprehensive Coverage)*

1. ✅ Account model extends Authenticatable and implements required interfaces
2. ✅ Account model uses all required traits correctly (HasFactory, HasRoles, CausesActivity, LogsActivity, Searchable, InteractsWithCredentials, etc.)
3. ✅ Account fillable fields include name, password, current_team_id
4. ✅ Password is properly cast to hashed and automatically hashes on create/update
5. ✅ toSearchableArray returns correct structure with credential relationships
6. ✅ Event dispatching configuration with all 10 lifecycle events
7. ✅ Database table configuration and integration tests
8. ✅ Model integration with Eloquent queries and data integrity

### AccountCredential Model Tests *(Status: ✅ Comprehensive Coverage)*

1. ✅ AccountCredential belongs to Account relationship
2. ✅ AccountCredential casts type to AccountCredentialTypesEnum
3. ✅ AccountCredential supports verification timestamps (verified_at cast to datetime)
4. ✅ Primary designation constraints work correctly (unique constraint on account_id, type, is_primary)
5. ✅ Value uniqueness constraints across all credentials
6. ✅ Factory configuration with all states (email, username, verified, secondary)
7. ✅ Enum integration and querying by enum types

### Trait Tests

For comprehensive trait testing documentation, see [Account Model Traits](alpha-account-traits.md).

### Validation Rule Tests *(Status: ✅ Comprehensive Direct Testing)*

**ValidName Rule Tests:**
1. ✅ ValidName accepts valid ASCII names with letters and spaces
2. ✅ ValidName rejects names with non-ASCII characters (José, María, etc.)
3. ✅ ValidName rejects names with numbers and special characters (John123)
4. ✅ ValidName rejects names that are only spaces
5. ✅ ValidName provides proper error messages for all validation failures
6. ✅ Additional edge cases and international character validation

**ValidUsername Rule Tests:**
1. ✅ ValidUsername accepts valid usernames (4-16 chars, lowercase start, alphanumeric end)
2. ✅ ValidUsername rejects usernames shorter than 4 characters
3. ✅ ValidUsername rejects usernames longer than 16 characters
4. ✅ ValidUsername rejects usernames not starting with lowercase letter
5. ✅ ValidUsername rejects usernames not ending with letter/number
6. ✅ ValidUsername rejects consecutive special characters (.. or __)
7. ✅ ValidUsername allows single dots and underscores
8. ✅ ValidUsername provides proper error messages for validation failures
9. ✅ Real-world username validation scenarios and examples

### Laravel Scout Integration Tests *(Status: ✅ Tested)*

1. ✅ Account model uses Searchable trait correctly
2. ✅ toSearchableArray includes id, name, username.value, email.value with proper structure
3. ✅ Handles missing credentials gracefully (throws expected exceptions)
4. ✅ Searchable trait methods available (searchableAs, toSearchableArray, getScoutKey)
