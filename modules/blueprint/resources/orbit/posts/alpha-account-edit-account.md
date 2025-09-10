---
title: 'Edit Account'
slug: alpha-account-edit-account
is_home_page: false
documentation_group: Alpha
navigation_group: Account
navigation_sort: 7.0
created_at: 2025-09-10T01:56:33+00:00
updated_at: 2025-09-10T02:08:58+00:00
---
# Edit Account

**I want to** update existing account information including name, username, and email
**So that** I can maintain accurate account data while preserving existing credentials and relationships

## Acceptance Criteria

- [x] Form displays current account data for name, username, and email
- [x] Name validation using ValidName rule (ASCII characters only)
- [x] Username validation using ValidUsername rule with proper constraints
- [x] Email format validation with uniqueness checking
- [x] Username and email uniqueness excludes current account's credentials
- [x] Credential updates use trait helper methods
- [x] Primary credential designation is maintained during updates
- [x] Successful updates show notification and redirect appropriately

## Technical Implementation

### Form Structure
- **Location**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Pages/EditAccount.php`
- **Schema**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Schemas/AccountForm.php`
- **Form Fields**: name, username.value, email.value (no password fields)
- **Pre-population**: Current values loaded from account and primary credentials

### Update Process

**Account Update Flow**:
1. Account name updated directly on Account model
2. Username updated via trait helper method
3. Email updated via trait helper method
4. Primary credential designation preserved
5. Relationships maintained throughout update process

### Validation Rules

**Name Field (ValidName)**:
- ASCII characters only (A-Z, a-z, spaces)
- Must contain at least one letter (not just spaces)
- No special characters or numbers

**Username Field (ValidUsername)**:
- Length: 4-16 characters
- Must start with lowercase letter (a-z)
- Must end with letter or number
- Allowed characters: lowercase letters, numbers, periods, underscores
- No consecutive special characters (dots/underscores)
- Uniqueness excludes current account's username credential

**Email Field**:
- Standard email format validation
- Uniqueness excludes current account's email credential
- Proper handling of update scenarios

## Additional Features

*These features are documented but implemented as separate functionality:*

### Password Management
- **EditPassword Action**: Separate form for password changes
- **Location**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Schemas/EditPasswordForm.php`
- **Validation**: Minimum 12 characters with confirmation
- **Security**: Current password verification before change

### Role Management
- **EditRoles Action**: Separate interface for role assignments
- **Location**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Schemas/EditRolesForm.php`
- **Team Scoping**: Roles isolated within team contexts
- **Authorization**: Policy-based access control

## Test Scenarios - Edit Account *(Implementation Status: ✅ Implemented)*

### Form Rendering and Data Loading
1. ✅ Edit account form page can be rendered successfully
2. ✅ Form displays current account name, username, and email
3. ✅ Form fields are properly populated with existing data
4. ✅ Form schema matches expected structure

### Account Update Success Path
1. ✅ Can update account name with valid data
2. ✅ Can update username using trait helper method
3. ✅ Can update email using trait helper method
4. ✅ Account record updated with new name
5. ✅ Username credential updated while maintaining primary designation
6. ✅ Email credential updated while maintaining primary designation
7. ✅ Success notification displayed after update

### Name Validation Tests
1. ✅ Name field is required
2. ✅ Rejects names with non-ASCII characters
3. ✅ Rejects names with numbers or special characters
4. ✅ Rejects names that are only spaces
5. ✅ Accepts valid names with ASCII letters and spaces

### Username Validation Tests
1. ✅ Username field is required
2. ✅ Username must be 4-16 characters
3. ✅ Username must start with lowercase letter
4. ✅ Username must end with letter or number
5. ✅ Username allows lowercase letters, numbers, dots, underscores
6. ✅ Username rejects consecutive special characters
7. ✅ Username uniqueness excludes current account's username

### Email Validation Tests
1. ✅ Email field is required
2. ✅ Email must be valid format
3. ✅ Email uniqueness excludes current account's email

### Credential Update Tests
1. ✅ Primary credential designation maintained during username update
2. ✅ Primary credential designation maintained during email update
3. ✅ Credential relationships preserved during updates
4. ✅ Multiple credential types supported correctly

### Password and Role Management *(Separate Features)*
1. ✅ EditPassword form accessible as separate action
2. ✅ EditRoles form accessible as separate action
3. ✅ Password and role updates don't interfere with basic account updates
4. ✅ Proper authorization for password and role management

*Note: Password and Role management are implemented as separate actions with their own forms and validation logic.*