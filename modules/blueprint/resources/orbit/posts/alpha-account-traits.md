---
title: Traits
slug: alpha-account-traits
is_home_page: false
documentation_group: Alpha
navigation_group: Account
navigation_sort: 4.0
created_at: 2025-09-10T06:52:25+00:00
updated_at: 2025-09-10T06:52:28+00:00
---

# Traits

**I want to** modular trait-based functionality that enhances the Account model with specific capabilities  
**So that** I can maintain clean separation of concerns while providing comprehensive account features

## Acceptance Criteria

- [x] InteractsWithCredentials trait handles flexible credential management
- [x] InteractsWithTeams trait provides multi-tenancy support
- [x] Activity logging traits provide comprehensive audit trails
- [x] Authorization traits integrate with role-based access control
- [x] All traits are thoroughly tested with comprehensive coverage

## Core Traits

### InteractsWithCredentials

**Location**: `modules/alpha/app/Models/Account/Concerns/InteractsWithCredentials.php`

This trait provides the core functionality for managing flexible credential types (email, username) with primary
designation support.

#### Relationships

```php
// Core relationships
public function credentials(): HasMany
public function email(): HasOne          // Primary email credential
public function username(): HasOne       // Primary username credential
```

#### Helper Methods

```php
// Update methods - handles both create and update scenarios
public function updateUsername(string $value): Model
public function updateEmail(string $value): Model
```

**Method Behavior**:

- `updateUsername()`: Updates existing primary username or creates new credential, sets `verified_at` to current
  timestamp
- `updateEmail()`: Updates existing primary email or creates new credential, resets `verified_at` to null (requires
  re-verification)

#### Query Scopes

```php
// Query scopes for filtering accounts by credentials
public function scopeWhereUsername(Builder $query, string $value): Builder
public function scopeWhereEmail(Builder $query, string $value): Builder
```

Both scopes only match primary credentials (`is_primary=true`), ensuring consistent query behavior.

#### Implementation Details

**Credential Update Process**:

- Uses `updateOrCreate()` with search criteria: `type` + `is_primary=true`
- Ensures only one primary credential per account per type due to unique constraint
- Maintains data integrity through database constraints

**Database Constraint**: `unique(['account_id', 'type', 'is_primary'])`

## Multi-Tenancy Traits

### InteractsWithTeams

**Purpose**: Team-based organization with ownership and membership capabilities

**Integration**:

- Works with Filament's `HasDefaultTenant` and `HasTenants` interfaces
- Provides team-scoped roles and permissions
- Supports multi-tenant application architecture

## Activity Logging Traits

### CausesActivity & LogsActivity

**Purpose**: Spatie Activity Log integration for comprehensive audit trails

**Features**:

- User action history and change tracking
- Compliance tracking capabilities
- Extensible event system for custom integrations

## Authorization Traits

### HasRoles

**Purpose**: Spatie Permission integration for role-based access control

**Features**:

- Policy-based authorization with granular access control
- Team-scoped role assignments
- Integration with Filament admin panel permissions

## Test Scenarios - Trait Coverage *(Implementation Status: ✅ Tested)*

### InteractsWithCredentials Trait Tests *(Comprehensive Coverage: InteractsWithCredentialsTest.php)*

#### Relationship Method Tests

1. ✅ `credentials()` relationship returns HasMany
2. ✅ `email()` relationship returns primary email credential
3. ✅ `username()` relationship returns primary username credential

#### Update Method Tests

4. ✅ `updateUsername()` updates existing primary username credential with verified_at timestamp
5. ✅ `updateUsername()` creates new credential when account has no username
6. ✅ `updateEmail()` updates existing primary email credential and resets verified_at to null
7. ✅ `updateEmail()` creates new credential when account has no email
8. ✅ Update methods handle both create and update scenarios correctly

#### Query Scope Tests

9. ✅ `scopeWhereUsername()` filters accounts by username value
10. ✅ `scopeWhereEmail()` filters accounts by email value
11. ✅ Query scopes return empty results for non-existent values
12. ✅ Query scopes only match primary credentials (not secondary credentials)

### Additional Traits Testing Status

**InteractsWithTeams**: 🔧 Framework-provided, covered by integration tests  
**CausesActivity/LogsActivity**: 🔧 Framework-provided, covered by integration tests  
**HasRoles**: 🔧 Framework-provided, covered by integration tests

*Note: Framework-provided traits are tested through integration with Account model functionality rather than isolated
unit tests.*

## Usage Examples

### Credential Management

```php
// Update username (preserves primary designation)
$account->updateUsername('newusername123');

// Update email (resets verification status)
$account->updateEmail('newemail@example.com');

// Query by credentials
$user = Account::whereUsername('john_doe')->first();
$user = Account::whereEmail('john@example.com')->first();
```

### Relationship Access

```php
// Access all credentials
$account->credentials; // Collection of AccountCredential models

// Access primary credentials directly
$account->username;    // Primary username credential
$account->email;       // Primary email credential
```
