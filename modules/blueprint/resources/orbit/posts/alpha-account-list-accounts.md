---
title: 'List Accounts'
slug: alpha-account-list-accounts
is_home_page: false
documentation_group: Alpha
navigation_group: Account
navigation_sort: 5.0
created_at: 2025-09-10T01:55:44+00:00
updated_at: 2025-09-10T02:08:49+00:00
---

# List Accounts

**I want to** view all accounts registered in the system with their essential information
**So that** I can quickly browse, search, and manage accounts efficiently

## Acceptance Criteria

- [x] Display accounts in a paginated table with name, username, and email columns
- [x] Search functionality by name, email, or username
- [x] Table actions for Edit, View, EditPassword, and EditRoles
- [x] Laravel Scout integration for efficient search
- [x] Proper column sorting and filtering capabilities
- [x] Responsive table design for different screen sizes

## Technical Implementation

### Filament Table Configuration

- **Location**: `modules/alpha/app/Filament/Clusters/Administration/Resources/Accounts/Pages/ListAccounts.php`
- **Table Columns**: Name, Username (from primary credential), Email (from primary credential)
- **Search Integration**: Laravel Scout with indexed fields
- **Actions**: Edit, View, EditPassword, EditRoles
- **Bulk Actions**: Export to CSV/Excel

### Search Capabilities

**Laravel Scout Integration**:

- **Search Engine Compatibility**: Algolia, Meilisearch, database drivers
- **Indexed Fields**: Account ID, name, primary username, primary email
- **Search Behavior**: Partial matching, relevance ranking
- **Performance**: Optimized searchable array structure
- **Real-time Updates**: Automatic index updates on model changes

**Search Implementation**:

```php
// Account model toSearchableArray method
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

### Import/Export Capabilities

*These features are documented but testing is deferred to focus on core functionality:*

**CSV Import Features**:

- Field mapping for name, username, email columns
- Full validation using custom rules (ValidName, ValidUsername)
- Uniqueness enforcement within credential types
- Secure password generation (32-character random passwords)
- Automatic AccountCredential record creation with primary designation
- Detailed validation messages and failure tracking

**CSV Export Features**:

- Column selection: Name, username, email
- Bulk export and selection-based export
- CSV and Excel format compatibility
- Progress tracking with success/failure counts

## Test Scenarios - List Accounts

**Legend:**

- ✅ **Tested** - Explicitly tested in our test suite
- 🔧 **Framework** - Provided by Filament framework, not explicitly tested
- ⚠️ **Not Tested** - Should be tested but currently isn't
- ❌ **Deferred** - Intentionally not implemented/tested yet

### Basic Table Functionality *(Status: Mixed)*

1. ✅ List accounts page can be rendered successfully
2. ✅ Table displays with proper columns (name, username, email)
3. ✅ Table column structure matches specification
4. 🔧 Pagination works correctly with multiple accounts *(Framework feature)*
5. ⚠️ Table actions are visible and accessible (Edit, View, EditPassword, EditRoles) *(Not tested - actions exist but
   not explicitly tested)*
6. 🔧 Responsive design works on different screen sizes *(Framework feature)*

### Search Functionality *(Status: Well Tested)*

1. ✅ Search by account name returns matching results
2. ✅ Search by username returns matching results
3. ✅ Search by email returns matching results
4. ✅ Partial search terms return relevant results
5. ✅ Search can be cleared to show all records
6. ✅ Laravel Scout integration works correctly *(Implicit through search tests)*
7. ⚠️ Search indexing updates when account data changes *(Not tested)*

### Table Interactions *(Status: Framework Dependent)*

1. 🔧 Column sorting works for name, username, email *(Framework feature)*
2. 🔧 Table refresh maintains search and filter state *(Framework feature)*
3. 🔧 Bulk selection functionality works correctly *(Framework feature)*
4. 🔧 Table loading states display appropriately *(Framework feature)*

### Import/Export Features *(Testing Deferred)*

1. ❌ CSV import with proper field mapping (name, username, email)
2. ❌ Validation during import process with proper error handling
3. ❌ Secure password generation for imported accounts
4. ❌ Credential creation with proper type assignment during import
5. ❌ Export functionality with correct column selection
6. ❌ Bulk operations work correctly for large datasets

*Note: Import/Export testing is deferred to focus on core Account/AccountCredential model functionality.*
