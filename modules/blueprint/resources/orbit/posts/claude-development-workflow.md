---
title: 'Development Workflow'
slug: claude-development-workflow
is_home_page: 0
documentation_group: Claude
navigation_group: Context
navigation_sort: 5
created_at: 2025-09-08T03:06:03+00:00
updated_at: 2025-09-08T03:06:03+00:00
---
## Development Workflow

1. **Module-First Approach:** New features should be organized within appropriate modules
2. **Code Style:** All code must pass Pint (with strict imports) and Rector checks
3. **Frontend Assets:** Use Vite for asset compilation, supports HMR
4. **Real-time Features:** Utilize Reverb for WebSocket functionality
5. **Background Jobs:** Queue processing handled by Horizon