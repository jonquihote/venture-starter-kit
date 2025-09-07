---
slug: claude-home
title: Home
is_home_page: true
documentation_group: Claude
created_at: 2025-09-01T00:00:00+00:00
updated_at: 2025-09-01T00:00:00+00:00
---

# Introduction

Welcome to **Venture Starter Kit**, a comprehensive Laravel 12 application template designed for building modern,
scalable web applications. This starter kit combines the power of Laravel with Vue 3, Filament, and a modular
architecture to provide everything you need to kickstart your next project.

Built for developers who value code quality, testing, and maintainability, Venture includes pre-configured tooling, best
practices, and a thoughtfully designed module system that grows with your application.

## Key Features

### 🚀 Modern Technology Stack

- **Laravel 12** with PHP 8.4 for cutting-edge backend performance
- **Vue 3** + **Inertia.js** for seamless SPA-like user experiences
- **Filament v4** for powerful admin panel functionality
- **Livewire v3** + **Volt** for dynamic server-side components
- **Tailwind CSS v4** with design tokens for rapid UI development

### 🏗️ Modular Architecture

- **Aeon Module**: Core utilities and Laravel package integration
- **Alpha Module**: Advanced Filament panel factory with multi-tenancy
- **Omega Module**: Invitation system and team management
- **Blueprint Module**: Documentation and style guide hub
- **Home Module**: Main application dashboard and components

### 🔧 Development Excellence

- **Pest v4** testing framework with parallel execution
- **Code Quality Tools**: Rector, Laravel Pint, ESLint integration
- **Conventional Commits** enforced via Husky and commitlint
- **Hot Reload Development** with concurrent service management
- **Database Flexibility**: SQLite (development) + PostgreSQL (testing)

### 🌟 Advanced Features

- **Multi-tenancy Support** with team-based isolation
- **Event-Driven Architecture** with observers and subscribers
- **Package Integration**: Horizon, Pulse, Reverb, Scout, Telescope
- **Spatie Package Suite**: Permissions, Activity Log, Media Library, Settings
- **API Client Integration** with Saloon for external services

## Technology Stack

### Backend Foundation

| Component         | Version | Purpose                             |
|-------------------|---------|-------------------------------------|
| Laravel Framework | 12.x    | Core application framework          |
| PHP               | 8.4+    | Server-side language                |
| Filament          | v4      | Admin panel and resource management |
| Livewire          | v3      | Dynamic server-side components      |
| Volt              | v1      | Functional Livewire API             |

### Frontend Stack

| Component    | Version | Purpose                          |
|--------------|---------|----------------------------------|
| Vue          | 3.x     | Progressive JavaScript framework |
| Inertia.js   | v2      | SPA-like navigation              |
| Tailwind CSS | v4      | Utility-first CSS framework      |
| TypeScript   | Latest  | Type-safe JavaScript             |
| Vite         | Latest  | Build tool and dev server        |

### Development Tools

| Tool         | Version | Purpose                |
|--------------|---------|------------------------|
| Pest         | v4      | Testing framework      |
| Rector       | v2      | PHP code modernization |
| Laravel Pint | v1      | Code style fixer       |
| ESLint       | Latest  | JavaScript linting     |
| Prettier     | Latest  | Code formatting        |

## Module Architecture

### Core Modules Overview

**Aeon Module** - System Foundation

- Laravel package integration and configuration
- First-party packages: Horizon, Pulse, Reverb, Scout, Telescope
- Spatie package suite: Activity Log, Media Library, Permissions, Settings
- Utility commands and system reset functionality

**Alpha Module** - Advanced Admin Features

- Filament panel factory with consistent setup
- Multi-tenancy support with team-based isolation
- Account management and authentication flows
- Comprehensive event system with observers/subscribers

**Omega Module** - Team Management

- Team invitation and membership system
- Role-based access control integration
- User onboarding workflows

**Blueprint Module** - Documentation Hub

- Comprehensive documentation and style guides
- Component library examples
- Development best practices and patterns

**Home Module** - Application Core

- Main dashboard and user interface
- Base page layouts and components
- Primary user workflows

## Getting Started

### Prerequisites

- **PHP** 8.4 or higher
- **Node.js** v22+ (with bun as primary package manager)
- **Composer** for PHP dependencies
- **Git** for version control

### Installation

1. **Clone and Setup**
   ```bash
   git clone <repository-url> venture
   cd venture
   cp .env.example .env
   php artisan key:generate
   ```

2. **Install Dependencies**
   ```bash
   composer install
   bun install
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Start Development**
   ```bash
   composer dev
   ```

The `composer dev` command starts all development services concurrently:

- Laravel Horizon (queue processing)
- Task Scheduler
- Laravel Pail (log viewer)
- Vite dev server (asset compilation)
- Laravel Pulse (application monitoring)
- Laravel Reverb (WebSocket server)

## Development Workflow

### Essential Commands

**Development Server**

```bash
composer dev          # Start all development services
composer dev:ssr       # Start with server-side rendering
```

**Testing**

```bash
composer test          # Run all tests (parallel execution)
composer test:api      # Run API-specific tests
php artisan test --parallel
```

**Code Quality**

```bash
composer cs           # Run all code style tools
composer pint         # PHP code formatting
composer rector       # PHP code modernization
bun run lint          # JavaScript/TypeScript linting
bun run format        # Prettier formatting
```

**Asset Management**

```bash
bun run build        # Production asset build
bun run build:ssr    # Build with SSR support
```

**Module Management**

```bash
php artisan module:make ModuleName
php artisan module:enable ModuleName
php artisan module:migrate ModuleName
```

### Testing Strategy

The application uses **Pest v4** with comprehensive testing coverage:

- **Unit Tests**: Individual class and method testing
- **Feature Tests**: Full application workflow testing
- **Browser Tests**: End-to-end user interaction testing
- **API Tests**: Separated API endpoint validation

Test configuration supports both SQLite (development) and PostgreSQL (testing) databases with parallel execution for
speed.

### Code Quality Standards

**Automated Quality Checks**

- **PHP**: Laravel Pint with strict import rules
- **JavaScript/TypeScript**: ESLint + Prettier with Blade support
- **Commits**: Conventional commit format enforced
- **Pre-commit**: Husky hooks ensure quality before commits

**Quality Metrics**

- Code coverage tracking
- Static analysis with Rector
- Dependency vulnerability scanning
- Performance monitoring with Pulse

## Best Practices

### Module Development

- Follow PSR-4 autoloading conventions
- Use module-specific service providers
- Implement proper event/observer patterns
- Maintain module isolation and clear interfaces

### Testing Guidelines

- Write tests for all new features
- Use factories for test data generation
- Implement browser tests for user workflows
- Maintain high code coverage standards

### Code Organization

- Group related functionality in modules
- Use descriptive naming conventions
- Follow Laravel and Vue.js best practices
- Document complex business logic

### Performance Optimization

- Leverage Laravel's built-in caching
- Optimize database queries with eager loading
- Use queue processing for heavy operations
- Monitor performance with Laravel Pulse

## Configuration

### Environment Variables

Key configuration options in `.env`:

- `APP_URL`: Application base URL
- `DB_CONNECTION`: Database type (sqlite/pgsql)
- `QUEUE_CONNECTION`: Queue driver configuration
- `BROADCAST_DRIVER`: WebSocket configuration

### Module Configuration

Each module includes its own configuration files and service providers. Module-specific settings can be found in
`config/modules.php` and individual module config directories.

### Package Configuration

Pre-configured packages include optimized settings for:

- Horizon (queue monitoring)
- Pulse (application monitoring)
- Telescope (debugging)
- Scout (full-text search)
- Reverb (WebSocket server)

## Support & Resources

### Documentation

- Framework documentation: [Laravel Docs](https://laravel.com/docs)
- Frontend stack: [Vue 3](https://vuejs.org/), [Inertia.js](https://inertiajs.com/)
- Admin panels: [Filament Docs](https://filamentphp.com/)
- Testing: [Pest Documentation](https://pestphp.com/)

### Community

- Follow conventional commit standards
- Submit issues with detailed reproduction steps
- Contribute improvements via pull requests
- Maintain code quality and testing standards

---

*This documentation serves as your starting point for building with the Venture Starter Kit. Each module contains
additional specific documentation and examples to guide your development process.*
