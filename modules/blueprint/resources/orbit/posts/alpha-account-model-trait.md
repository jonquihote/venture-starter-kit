---
title: 'Model & Trait'
slug: alpha-account-model-trait
is_home_page: false
documentation_group: Alpha
navigation_group: Account
navigation_sort: 4.0
created_at: 2025-09-10T01:54:47+00:00
updated_at: 2025-09-10T01:59:28+00:00
---
# Account Model & Trait Architecture

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

**InteractsWithCredentials** (`modules/alpha/app/Models/Account/Concerns/InteractsWithCredentials.php`):
```php
// Core relationships
public function credentials(): HasMany
public function email(): HasOne          // Primary email credential
public function username(): HasOne       // Primary username credential

// Helper methods
public function updateUsername(string $value): Model
public function updateEmail(string $value): Model

// Query scopes
public function scopeWhereUsername(Builder $query, string $value): Builder
public function scopeWhereEmail(Builder $query, string $value): Builder
```

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

### Multi-Tenancy Support
- **InteractsWithTeams**: Team-based organization with ownership and membership
- **HasDefaultTenant** and **HasTenants**: Filament multi-tenancy integration
- Team-scoped roles and permissions

### Event-Driven Architecture
- Complete lifecycle events (Creating, Created, Updating, etc.)
- Observer pattern for business logic hooks
- Extensible event system for custom integrations

### Activity Logging
- **CausesActivity** and **LogsActivity**: Spatie Activity Log integration
- Comprehensive audit trail for compliance tracking
- User action history and change tracking

### Authorization System
- **HasRoles**: Spatie Permission integration
- Policy-based authorization with granular access control
- Team-scoped role assignments

## Test Scenarios - Model Architecture *(Implementation Status: ✅ Implemented)*

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

### InteractsWithCredentials Trait Tests
1. ✅ credentials() relationship returns HasMany
2. ✅ email() relationship returns primary email credential
3. ✅ username() relationship returns primary username credential
4. ✅ updateUsername() creates/updates username credential correctly
5. ✅ updateEmail() creates/updates email credential correctly
6. ✅ scopeWhereUsername() filters by username value
7. ✅ scopeWhereEmail() filters by email value

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