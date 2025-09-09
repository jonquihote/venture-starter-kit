---
title: Home
slug: omega-home
is_home_page: 1
documentation_group: Omega
navigation_sort: 1
created_at: 2025-09-01T00:00:00+00:00
updated_at: 2025-09-01T00:00:00+00:00
---

# Home

The Omega module handles team invitations, user onboarding, and team-based access control.

### Core Model

**Invitation Model** (`Invitation.php`)

- Team invitation management
- Invitation status tracking (pending, accepted, rejected)
- Email-based invitation system

### Key Features

**Invitation System:**

- Email-based team invitations
- Token-based invitation acceptance
- Invitation expiration and management
- Role assignment during invitation

**Permission Integration:**

- Role-based access control using Spatie Permissions
- Team-level permission assignments
- Invitation-time role specification

**User Onboarding:**

- Guided onboarding workflow for new team members
- Account setup and team integration
- Permission assignment and access setup

### Filament Resources

**Invitation Resource:**

- Complete CRUD interface for managing invitations
- Invitation status tracking and management
- Team context for invitation operations
