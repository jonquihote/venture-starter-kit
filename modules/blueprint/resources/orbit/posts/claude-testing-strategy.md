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