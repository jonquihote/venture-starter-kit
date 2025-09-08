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