---
title: 'Development Commands'
slug: claude-development-commands
is_home_page: false
documentation_group: Claude
navigation_group: Context
navigation_sort: 2.0
created_at: 2025-09-08T02:36:39+00:00
updated_at: 2025-09-08T10:56:52+00:00
---
## Development Commands

**Primary Development:**

```bash
composer dev              # Start full development environment
composer dev:ssr          # Start with SSR support
bun run dev               # Assets only
php artisan serve         # Basic Laravel server
```

**Code Quality:**

```bash
composer cs               # Run all code style fixes (rector + pint + prettier)
composer pint             # PHP code style (using strict imports config)
composer rector           # PHP refactoring
bun run lint              # ESLint with auto-fix
bun run format            # Prettier formatting
```

**Testing:**

```bash
composer test             # Base test suite (modules/*/tests)
composer test:api         # API test suite (modules/*/tests-api)
php artisan test --filter=SomeTest  # Single test
```

**Module Management:**

```bash
php artisan module:make ModuleName    # Create new module
php artisan module:list               # List all modules
php artisan module:make-controller ModuleName ControllerName
php artisan module:migrate ModuleName # Migrate specific module
```