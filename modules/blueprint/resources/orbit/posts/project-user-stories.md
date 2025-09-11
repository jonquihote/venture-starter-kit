---
title: User Stories
slug: project-user-stories
is_home_page: 0
documentation_group: Project
navigation_group: Development
navigation_sort: 9.0
created_at: 2025-09-11T00:00:00+00:00
updated_at: 2025-09-11T00:00:00+00:00
---
# User Stories Example

User stories capture feature requirements from the user's perspective. They define the "who," "what," and "why" of features, providing context for development and testing.

## Story Template

**As a** [type of user]  
**I want** [some goal/functionality]  
**So that** [benefit/value/reason]

## TaskFlow User Stories

### Story ID: TF-042
**Epic:** Task Management  
**Sprint:** Sprint 3  
**Story Points:** 3  

**Title:** Filter tasks by assignee

**As a** team lead  
**I want to** filter the board to show only tasks assigned to specific team members  
**So that** I can quickly review individual workloads and progress

#### Acceptance Criteria
- [ ] Filter dropdown appears above the board with all team members listed
- [ ] Selecting a team member shows only their assigned tasks
- [ ] Multiple team members can be selected simultaneously  
- [ ] "Clear filters" option resets to show all tasks
- [ ] Filter state persists when navigating away and back
- [ ] Filtered view updates in real-time when tasks are reassigned
- [ ] Visual indicator shows when filters are active (e.g., "Showing 5 of 12 tasks")

#### Technical Notes
- Implement filtering on frontend first (no API call needed for MVP)
- Store filter state in localStorage for persistence
- Use existing team members from workspace context
- Performance: Should handle 500+ tasks without lag

#### Dependencies
- Requires TF-038 (Load all board tasks) to be complete

#### Test Scenarios
1. **Filter by single user** - verify correct tasks shown
2. **Filter by multiple users** - verify OR logic (show tasks assigned to any selected user)
3. **Clear filters** - verify all tasks return to view
4. **Add new task while filtered** - verify it appears/doesn't appear correctly
5. **Change task assignment while filtered** - verify real-time update
6. **Page refresh with active filter** - verify filter state persists

---

### Story ID: TF-051
**Epic:** Time Tracking  
**Sprint:** Sprint 4  
**Story Points:** 5  

**Title:** Track time spent on tasks

**As a** freelance designer  
**I want to** track how much time I spend on each task  
**So that** I can accurately bill clients and understand my productivity

#### Acceptance Criteria
- [ ] Timer button visible on each task card
- [ ] Clicking timer starts/stops time tracking for that task
- [ ] Only one timer can be active at a time (starting new timer stops previous)
- [ ] Timer shows elapsed time in real-time (HH:MM format)
- [ ] Time entries are saved to database when timer stops
- [ ] Task card displays total time tracked (e.g., "2h 45m")
- [ ] Timer state persists across browser refresh
- [ ] Visual indicator shows which task has active timer

#### Edge Cases
- [ ] Handle browser close/crash during active timer (save on page unload)
- [ ] Maximum session length of 8 hours (auto-stop with warning)
- [ ] Prevent negative time entries
- [ ] Handle timezone changes for remote workers

#### Technical Notes
- Use WebSocket for real-time timer updates across multiple browser tabs
- Store active timer state in localStorage as backup
- Timer precision: minute-level (not seconds) for UI simplicity
- Database stores start_time, end_time, and calculated duration

#### Dependencies
- Requires database schema for time_entries table
- Requires WebSocket connection for real-time updates

---

### Story ID: TF-063
**Epic:** Collaboration  
**Sprint:** Sprint 5  
**Story Points:** 2  

**Title:** Add comments to tasks

**As a** project manager  
**I want to** add comments to tasks  
**So that** I can communicate updates and ask questions without leaving the board

#### Acceptance Criteria
- [ ] Comment section visible when task detail modal is opened
- [ ] Text area allows typing comments up to 1000 characters
- [ ] Comments display with author name, avatar, and timestamp
- [ ] Comments are ordered chronologically (oldest first)
- [ ] @mention functionality to notify specific team members
- [ ] Basic text formatting (bold, italic, links)
- [ ] Real-time comment updates when others add comments

#### User Flow
1. User clicks on task to open detail modal
2. Scrolls to comments section at bottom
3. Types comment in text area
4. Clicks "Add Comment" button
5. Comment appears immediately in the list
6. Other users see the comment appear in real-time

#### Technical Notes
- Markdown support for basic formatting
- @mention regex: `@\w+` patterns
- Real-time updates via WebSocket
- Email notifications for @mentions (async)

#### Dependencies
- Requires comments database table
- Requires notification system for @mentions

---

### Story ID: TF-078
**Epic:** Mobile Experience  
**Sprint:** Sprint 6  
**Story Points:** 8  

**Title:** Responsive mobile board view

**As a** team member on-the-go  
**I want to** view and update tasks on my mobile device  
**So that** I can stay productive when away from my computer

#### Acceptance Criteria
- [ ] Board adapts to mobile screen sizes (320px - 768px)
- [ ] Touch-friendly task cards with adequate tap targets (44px minimum)
- [ ] Horizontal scrolling for board columns on mobile
- [ ] Swipe gestures for quick actions (swipe right to complete)
- [ ] Optimized typography and spacing for mobile reading
- [ ] Fast loading on mobile connections (< 3 seconds on 3G)
- [ ] Works offline with sync when connection restored

#### Mobile-Specific Features
- [ ] Pull-to-refresh for board updates
- [ ] Long-press for context menu (instead of right-click)
- [ ] Sticky header with board name and add task button
- [ ] Collapsible column headers to save space
- [ ] Bottom sheet modal for task details (better than overlay)

#### Performance Requirements
- [ ] Initial page load < 3 seconds on 3G connection
- [ ] Smooth scrolling and animations (60fps)
- [ ] Optimized images and compressed assets
- [ ] Progressive Web App (PWA) capabilities

#### Browser Compatibility
- [ ] iOS Safari 14+
- [ ] Chrome Mobile 90+
- [ ] Samsung Internet 14+
- [ ] Firefox Mobile 90+

---

### Story ID: TF-089
**Epic:** Productivity  
**Sprint:** Sprint 7  
**Story Points:** 3  

**Title:** Keyboard shortcuts for power users

**As a** frequent user  
**I want to** use keyboard shortcuts for common actions  
**So that** I can work more efficiently without constantly reaching for the mouse

#### Acceptance Criteria
- [ ] **N** - Create new task in current board
- [ ] **/** - Focus search/filter input
- [ ] **Escape** - Close modals and cancel current actions
- [ ] **Space** - Start/stop timer on selected task
- [ ] **Enter** - Save current form or confirm action
- [ ] **Arrow keys** - Navigate between tasks
- [ ] **1-4** - Move selected task to column (To Do, In Progress, etc.)
- [ ] **?** - Show keyboard shortcuts help overlay

#### Implementation Details
- [ ] Keyboard shortcuts work globally (not just when input focused)
- [ ] Visual feedback when shortcuts are used
- [ ] Disable shortcuts when typing in text inputs
- [ ] Help overlay shows all available shortcuts
- [ ] Shortcuts respect current context (board view vs task detail)

#### Accessibility
- [ ] Shortcuts announced to screen readers
- [ ] Focus indicators clearly visible
- [ ] Tab order logical and consistent
- [ ] Alternative methods available for all shortcut actions

---

## Story Writing Guidelines

### Story Characteristics (INVEST)
- **Independent** - Can be developed and tested separately
- **Negotiable** - Details can be discussed and refined
- **Valuable** - Provides clear value to users
- **Estimable** - Team can estimate effort required
- **Small** - Can be completed in one sprint
- **Testable** - Clear criteria for done

### Story Size Guidelines
| Story Points | Description | Examples |
|-------------|-------------|----------|
| 1 | Trivial change | Copy text updates, simple styling |
| 2 | Minor feature | Add validation to existing form |
| 3 | Standard feature | Filter functionality, basic CRUD |
| 5 | Complex feature | Time tracking, real-time updates |
| 8 | Major feature | Mobile responsive redesign |
| 13+ | Epic/too large | Should be broken down |

### Definition of Done Checklist
A story is considered "done" when:
- [ ] All acceptance criteria are met
- [ ] Code is reviewed and approved
- [ ] Unit and integration tests pass
- [ ] Feature tested on supported browsers/devices
- [ ] Documentation updated (if needed)
- [ ] Deployed to staging environment
- [ ] Product owner approval obtained

### Story Prioritization Matrix

| Priority | Business Value | User Impact | Technical Risk |
|----------|---------------|-------------|----------------|
| P0 (Must Have) | High | High | Low-Medium |
| P1 (Should Have) | Medium-High | Medium | Medium |
| P2 (Nice to Have) | Low-Medium | Low-Medium | Any |

### Common Story Patterns

#### CRUD Operations
```
As a [user type]
I want to [create/read/update/delete] [resource]
So that I can [manage/track/organize] [business value]
```

#### Integration Stories
```
As a [user type]
I want to [connect/sync/import] with [external system]
So that I can [avoid duplicate work/streamline workflow]
```

#### Performance Stories
```
As a [user type]
I want [feature] to [load/respond/process] quickly
So that I can [maintain productivity/stay engaged]
```

#### Security/Compliance Stories
```
As a [admin/compliance officer]
I want to [control access/audit/secure] [resource]
So that [organization] can [meet requirements/protect data]
```

## Story Collaboration

### Refinement Process
1. **Initial writing** - Product owner drafts story
2. **Team review** - Developers and testers provide input
3. **Acceptance criteria** - Team collaboratively defines success criteria
4. **Estimation** - Team estimates story points using planning poker
5. **Final approval** - Product owner approves refined story

### Story Splitting Techniques
When stories are too large (>8 points), consider splitting by:
- **Workflow steps** - Break complex flow into individual steps
- **Data variations** - Handle different data types separately
- **Interface types** - Desktop first, then mobile
- **CRUD operations** - Create, read, update, delete as separate stories
- **Happy/sad paths** - Core functionality first, then error handling

This user story format ensures clear communication between stakeholders and provides a solid foundation for development and testing activities.