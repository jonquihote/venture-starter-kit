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

## Test Scenarios - Model Architecture *(Implementation Status: ✅ Tested)*

### Account Model Tests

1. ✅ Account model extends Authenticatable and implements required interfaces
2. ✅ Account model uses all required traits correctly
3. ✅ Account fillable fields include name, password, current_team_id
4. ✅ Password is properly cast to hashed
5. ✅ toSearchableArray returns correct structure

### AccountCredential Model Tests

1. ✅ AccountCredential belongs to Account
2. ✅ AccountCredential casts type to AccountCredentialTypesEnum
3. ✅ AccountCredential supports verification timestamps
4. ✅ Primary designation works correctly

### Trait Tests

For comprehensive trait testing documentation, see [Account Model Traits](alpha-account-traits.md).

### Validation Rule Tests

1. ✅ ValidName accepts valid ASCII names with letters and spaces
2. ✅ ValidName rejects names with non-ASCII characters
3. ✅ ValidName rejects names with numbers or special characters
4. ✅ ValidName rejects names that are only spaces
5. ✅ ValidUsername accepts valid usernames (4-16 chars, proper format)
6. ✅ ValidUsername rejects usernames outside length requirements
7. ✅ ValidUsername rejects usernames not starting with lowercase letter
8. ✅ ValidUsername rejects usernames not ending with letter/number
9. ✅ ValidUsername rejects usernames with consecutive special characters

### Laravel Scout Integration Tests

1. ✅ Account model uses Searchable trait
2. ✅ toSearchableArray includes id, name, username.value, email.value
3. ✅ Search indexing works correctly with model changes
