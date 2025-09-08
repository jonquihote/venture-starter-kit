---
title: 'Special Commands'
slug: claude-special-commands
is_home_page: 0
documentation_group: Claude
navigation_group: Context
navigation_sort: 8
created_at: 2025-09-08T03:07:10+00:00
updated_at: 2025-09-08T03:07:10+00:00
---
## Special Commands

**Application Reset:**

```bash
php artisan reset                    # Reset to pristine state
php artisan aeon:reset-application   # Module-specific reset
```

**Filament:**

```bash
php artisan filament:make-resource ModelName --module=ModuleName
php artisan filament:make-page PageName --module=ModuleName
```

**Horizon (Queue Management):**

```bash
php artisan horizon        # Start queue processing
php artisan horizon:status # Check status
```