---
title: 'Create Account'
slug: alpha-account-create-account
is_home_page: false
documentation_group: Alpha
navigation_group: Account
navigation_sort: 6.0
created_at: 2025-09-10T01:56:11+00:00
updated_at: 2025-09-10T02:08:55+00:00
---

# Create Account

**I want to** create new user accounts with secure credentials
**So that** I can onboard users into the system with proper validation and security measures

## Acceptance Criteria

- [x] Form displays fields for name, password, password confirmation, username, and email
- [x] All fields are required and properly validated
- [x] Name validation using ValidName rule (ASCII characters only)
- [x] Password requires minimum 12 characters with confirmation
- [x] Username validation using ValidUsername rule (4-16 chars, specific format)
- [x] Email format validation and uniqueness checking
- [x] AccountCredential records created with proper type and primary designation
- [x] Successful creation redirects with notification

## Technical Implementation

### Form Structure

- **Location**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Pages/CreateAccount.php`
- **Schema**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Schemas/AccountForm.php`
- **Form Fields**: name, password, password_confirmation, username.value, email.value
- **Validation**: Uses Laravel form requests with custom validation rules

### Validation Rules

**Name Field (ValidName)**:

- ASCII characters only (A-Z, a-z, spaces)
- Must contain at least one letter (not just spaces)
- No special characters or numbers

**Password Field**:

- Minimum 12 characters using Laravel's `Password::min(12)` rule
- Confirmation required matching password field
- Secure hashing using Laravel's default hasher

**Username Field (ValidUsername)**:

- Length: 4-16 characters
- Must start with lowercase letter (a-z)
- Must end with letter or number
- Allowed characters: lowercase letters, numbers, periods, underscores
- No consecutive special characters (dots/underscores)
- Uniqueness within username credential type

**Email Field**:

- Standard email format validation
- Uniqueness within email credential type
- Proper handling during creation

### Credential Creation Process

**Account Creation Flow**:

1. Account record created with name and hashed password
2. Username credential created with type='username', is_primary=true
3. Email credential created with type='email', is_primary=true
4. Both credentials linked to account via account_id
5. Verification timestamps set appropriately

### Password Security

- All passwords hashed using Laravel's default hasher
- Secure password generation for CSV imports (32-character random)
- Password confirmation required for all operations

## Additional Features

*These features are documented but testing is deferred:*

### CSV Import Capability

- **Field Mapping**: name, username, email columns required
- **Validation**: Full validation using custom rules (ValidName, ValidUsername)
- **Uniqueness Enforcement**: Username/email uniqueness within credential types
- **Secure Password Generation**: 32-character random passwords auto-generated
- **Credential Creation**: Automatic AccountCredential records with primary designation
- **Error Handling**: Detailed validation messages and failure tracking

## Test Scenarios - Create Account *(Implementation Status: ✅ Implemented)*

**Legend:**
- ✅ **Tested** - Explicitly tested in our test suite
- 🔧 **Framework** - Provided by Laravel/Filament framework (trusted)
- ⚠️ **Not Tested** - Should be tested but currently isn't
- ❌ **Deferred** - Intentionally not implemented/tested yet

### Form Rendering and Schema

1. ✅ Create account form page can be rendered successfully
2. ✅ Form schema exists and displays all required fields
3. ✅ Fields are properly labeled and organized
4. ✅ Password confirmation field works correctly

### Account Creation Success Path

1. ✅ Can create account with valid data (name, password, username, email)
2. ✅ Account record is created in database with correct name
3. ✅ Username credential is created with proper type and primary designation
4. ✅ Email credential is created with proper type and primary designation
5. ✅ Password is properly hashed and stored
6. ✅ Success notification is displayed
7. ✅ Redirects to appropriate page after creation

### Name Validation Tests

1. ✅ Name field is required
2. ✅ Rejects names with non-ASCII characters (José María)
3. ✅ Rejects names with numbers or special characters (John123)
4. ✅ Rejects names that are only spaces
5. ✅ Accepts valid names with letters and spaces (John Doe)

### Password Validation Tests

1. ✅ Password field is required
2. ✅ Password must be at least 12 characters
3. ✅ Password confirmation is required
4. ✅ Password confirmation must match password
5. ✅ Password is properly hashed before storage

### Username Validation Tests

1. ✅ Username field is required
2. ✅ Username must be 4-16 characters
3. ✅ Username must start with lowercase letter
4. ✅ Username must end with letter or number
5. ✅ Username allows lowercase letters, numbers, dots, underscores
6. ✅ Username rejects consecutive special characters
7. ✅ Username uniqueness is enforced within credential type

### Email Validation Tests

1. ✅ Email field is required
2. ✅ Email must be valid format
3. ✅ Email uniqueness is enforced within credential type
4. ✅ Email credential created with proper relationship

### Credential Creation Tests

1. ✅ Username credential created with AccountCredentialTypesEnum::Username
2. ✅ Email credential created with AccountCredentialTypesEnum::Email
3. ✅ Both credentials marked as is_primary=true
4. ✅ Credentials properly linked to account via account_id

### CSV Import Features *(Testing Deferred)*

1. ❌ CSV import with proper field mapping (name, username, email)
2. ❌ Validation during import process with error handling
3. ❌ Secure password generation for imported accounts
4. ❌ Credential creation with proper type assignment during import
5. ❌ Bulk creation error handling and progress tracking

*Note: CSV Import testing is deferred to focus on core Account/AccountCredential model functionality.*
