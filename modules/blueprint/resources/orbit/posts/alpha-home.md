---
title: Home
slug: alpha-home
is_home_page: 1
documentation_group: Alpha
navigation_sort: 1
created_at: 2025-09-01T00:00:00+00:00
updated_at: 2025-09-01T00:00:00+00:00
---

# Home

The Alpha module provides advanced administration features with multi-tenancy support and comprehensive account
management.

### Core Models

**Account Model** (`Account.php`)

- Central account entity for the application
- Relationships with teams, memberships, and subscriptions
- Multi-tenancy foundation

**Team Model** (`Team.php`)

- Team management within accounts
- Member relationships and permissions
- Team-based access control integration

**Membership Model** (`Membership.php`)

- User-team relationship management
- Role and permission assignments
- Membership status tracking

**Subscription Model** (`Subscription.php`)

- Subscription management (if billing is implemented)
- Plan tracking and billing cycles
- Account-subscription relationships

**Application Model** (`Application.php`)

- Application-specific configuration
- Account-level application settings

**Attachment Model** (`Attachment.php`)

- File attachment management
- Media library integration
- Account and team-level file organization

**AccountCredential Model** (`AccountCredential.php`)

- Secure credential storage
- API keys and authentication tokens
- Account-specific credential management

### Filament Integration

**Panel Factory System:**

- Consistent Filament panel setup across the application
- Multi-tenancy support built into admin panels
- Account context switching

**Resource Management:**

- Account, Team, Membership, and Subscription resources
- CRUD operations with proper authorization
- Relationship management interfaces

### Key Features

**Multi-Tenancy Support:**

- Account-based tenant isolation
- Context switching between accounts
- Tenant-aware queries and operations

**Event-Driven Architecture:**

- Comprehensive observer and subscriber system
- Account lifecycle event handling
- Team and membership change events
