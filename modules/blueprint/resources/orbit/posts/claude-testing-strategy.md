---
title: 'Testing Strategy'
slug: claude-testing-strategy
is_home_page: 0
documentation_group: Claude
navigation_group: Context
navigation_sort: 4
created_at: 2025-09-08T03:05:28+00:00
updated_at: 2025-09-08T03:05:28+00:00
---
## Testing Strategy

**Pest PHP** is used for all tests with two main suites:

- **Base Suite:** `modules/*/tests` - Unit and feature tests
- **API Suite:** `modules/*/tests-api` - API endpoint tests

Test files are module-specific and follow Pest conventions.

### Testing Philosophy

Our testing approach distinguishes between different types of functionality:

**✅ Explicitly Tested** - Core business logic, validation rules, data relationships, and critical user workflows that are essential to application functionality.

**🔧 Framework Features** - Functionality provided by Laravel/Filament frameworks (pagination, responsive design, loading states) that we trust the framework to handle correctly.

**⚠️ Not Tested** - Application-specific functionality that should be tested but isn't currently covered (action buttons, authorization, formatting).

**❌ Deferred** - Advanced features that exist but are intentionally excluded from current testing scope to focus on core functionality.

### Focus Areas

- **Business Logic**: Custom validation rules, data transformations, and application-specific workflows
- **Data Relationships**: Model relationships, credential management, and database integrity
- **User Workflows**: Critical paths like account creation, editing, and authentication
- **Integration Points**: Areas where custom code integrates with framework features

### Framework Trust

We avoid testing framework-provided functionality unless we've customized it significantly. This includes:
- Filament table pagination, sorting, and filtering
- Laravel validation rule basics (required, email format)
- Standard Livewire rendering and state management
- Tailwind CSS responsive design

## Testing Decision Framework

### When to Test vs Trust Framework

**✅ Always Test These:**
- Custom validation rules (ValidName, ValidUsername)
- Model relationships and data integrity
- Custom business logic and transformations
- User authentication and authorization flows
- API endpoints and data serialization
- Custom Filament components and configurations
- Event dispatching and observer patterns

**🔧 Trust Framework For:**
- Laravel's built-in validation (required, email format, min/max length)
- Filament's table features (pagination, sorting, filtering)
- Livewire's component lifecycle and state management
- Eloquent's basic CRUD operations and query building
- Standard HTTP middleware and routing

**⚠️ Test Integration Points:**
- Where custom code meets framework features
- Custom form schemas in Filament
- Modified authentication flows
- Custom casts and accessors
- Event subscriber implementations

### Legend System Usage Guide

Use consistent symbols across all spec files to indicate test status:

**✅ Tested**
- Explicitly covered by unit/feature tests
- Verified through automated test suite
- Example: "✅ Username validation rejects invalid formats"

**🔧 Framework**
- Provided by Laravel/Filament/Livewire
- Trusted to work correctly without testing
- Example: "🔧 Table pagination and sorting"

**⚠️ Not Tested**
- Application-specific functionality lacking tests
- Should be tested but currently isn't
- Example: "⚠️ Action button authorization checks"

**❌ Deferred**
- Intentionally excluded from current testing scope
- Complex features requiring significant test infrastructure
- Example: "❌ CSV import with error handling"

### Writing Effective Test Scenarios

**Follow Pest PHP Conventions:**
```php
describe('Feature Group', function (): void {
    it('tests specific behavior', function (): void {
        // Test implementation
    });
});
```

**Organize Tests Logically:**
- Group related tests with `describe()` blocks
- Use descriptive test names that explain behavior
- Test both success and failure paths
- Include edge cases and boundary conditions

**Filament Testing Best Practices:**
```php
// Test Filament resources
livewire(CreateAccount::class)
    ->fillForm(['name' => 'John Doe'])
    ->call('create')
    ->assertNotified();

// Test Filament infolists
livewire(ViewAccount::class, ['record' => $account->id])
    ->assertSchemaStateSet([
        'name' => $account->name,
        'email.value' => $account->email->value,
    ]);

// Test Filament actions
livewire(EditAccount::class, ['record' => $account->id])
    ->assertActionExists('save')
    ->assertActionVisible('save');
```

### Test Documentation Patterns

**Spec File Structure:**
1. Acceptance criteria with implementation status
2. Technical implementation details
3. Test scenarios section with legend
4. Current test coverage summary
5. Deferred features with explanations

**Test Coverage Documentation:**
- Document test count and organization
- Explain what each test group covers
- Note framework features that aren't tested
- Clearly mark deferred complex features

**Example Documentation Pattern:**
```markdown
## Test Scenarios - Feature Name *(Status: ✅ Comprehensive)*

**Legend:**
- ✅ **Tested** - Explicitly tested in our test suite
- 🔧 **Framework** - Provided by Laravel/Filament framework (trusted)
- ⚠️ **Not Tested** - Should be tested but currently isn't
- ❌ **Deferred** - Intentionally not implemented/tested yet

### Core Functionality
1. ✅ Feature validates input correctly
2. ✅ Feature creates records with proper relationships
3. 🔧 Form rendering and basic Filament UI behavior

### Current Test Coverage
Enhanced with 16 comprehensive tests organized in 4 logical groups:
- **Data Display (4 tests)**: Schema state validation, missing data handling
- **Structure (3 tests)**: Schema existence, component rendering
- **Actions (4 tests)**: Button visibility, authorization
- **Integration (5 tests)**: End-to-end workflows
```

### Implementation Examples

**Model Testing Pattern:**
```php
describe('Account Model', function (): void {
    describe('Class Hierarchy', function (): void {
        it('extends Authenticatable', function (): void {
            expect(new Account)->toBeInstanceOf(Authenticatable::class);
        });
    });
    
    describe('Model Configuration', function (): void {
        it('has correct fillable fields', function (): void {
            expect((new Account)->getFillable())->toEqual([
                'current_team_id', 'name', 'password'
            ]);
        });
    });
});
```

**Validation Rule Testing Pattern:**
```php
describe('ValidName Rule', function (): void {
    it('accepts valid ASCII names', function (): void {
        $rule = new ValidName;
        $passes = false;
        
        $rule->validate('name', 'John Doe', function () use (&$passes): void {
            $passes = true;
        });
        
        expect($passes)->toBeFalse();
    });
});
```

### Quality Gates

**Before Marking Tests Complete:**
- All tests must pass: `php artisan test --filter=FeatureName`
- Follow naming conventions and organize logically
- Update corresponding spec documentation
- Verify test coverage matches documented status

**Test Maintenance:**
- Keep tests focused and atomic
- Use factories for model creation
- Clean up test data appropriately
- Maintain test performance and reliability