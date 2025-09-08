---
title: Architecture
slug: claude-architecture
is_home_page: 0
documentation_group: Claude
navigation_group: Context
navigation_sort: 3
created_at: 2025-09-08T03:03:28+00:00
updated_at: 2025-09-08T03:03:28+00:00
---
## Architecture

This is a **modular Laravel application** using `nwidart/laravel-modules` with a sophisticated tech stack:

### Tech Stack

- **Backend:** Laravel 12, PHP 8.4, PostgreSQL
- **Frontend:** Vue 3 + Inertia.js, TypeScript, Tailwind CSS v4
- **Admin:** Filament 4.0 with custom panels
- **UI Components:** Livewire 3.6 with Flux UI
- **Real-time:** Laravel Reverb (WebSockets), Laravel Echo
- **Background Jobs:** Laravel Horizon
- **Monitoring:** Laravel Pulse, Laravel Telescope

### Module Structure

Current modules: `aeon`, `alpha`, `blueprint`, `home`, `omega`

Each module follows Laravel structure:

```
modules/{module}/
├── app/              # Controllers, Models, etc.
├── config/           # Module-specific config
├── database/         # Migrations, seeders
├── resources/        # Views, assets
├── routes/           # Module routes
├── tests/            # Module tests
└── module.json       # Module configuration
```

### Key Patterns

**Actions Pattern:**

- Business logic organized in Action classes
- Located in `modules/{module}/app/Actions/`
- Single responsibility, invokable classes

**Form Requests:**

- Validation rules in dedicated request classes
- Located in `modules/{module}/app/Http/Requests/`

**Resource Pattern:**

- API responses use Resource classes
- Located in `modules/{module}/app/Http/Resources/`

### Database

- Primary: PostgreSQL (configured for development and testing)
- Testing: `venture_testing` database
- Queue: Redis (managed by Horizon)
