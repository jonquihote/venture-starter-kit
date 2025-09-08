---
title: 'Frontend Architecture'
slug: claude-frontend-architecture
is_home_page: 0
documentation_group: Claude
navigation_group: Context
navigation_sort: 6
created_at: 2025-09-08T03:06:24+00:00
updated_at: 2025-09-08T03:06:24+00:00
---
## Frontend Architecture

**Inertia.js** bridges Laravel and Vue 3:

- Server-side routing with client-side navigation
- Shared data between backend and frontend via Inertia props
- Vue components in `resources/js/Components/`
- Pages in `modules/{module}/resources/js/Pages/`

**UI Components:**

- Flux UI components for Livewire
- Custom Vue components for Inertia
- Tailwind CSS v4 for styling
- Icons via Lucide Vue Next