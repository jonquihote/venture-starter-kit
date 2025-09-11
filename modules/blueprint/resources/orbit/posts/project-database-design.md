---
title: Database Design
slug: project-database-design
is_home_page: 0
documentation_group: Project
navigation_group: Design
navigation_sort: 7.0
created_at: 2025-09-11T00:00:00+00:00
updated_at: 2025-09-11T00:00:00+00:00
---
# Database Design Example

Database design documentation defines the data model, relationships, and storage strategy. It guides implementation and ensures data integrity throughout the application lifecycle.

## TaskFlow Database Schema

### Entity Relationship Diagram

```
┌─────────────┐       ┌──────────────────┐       ┌─────────────┐
│    users    │       │ workspace_members │       │ workspaces  │
├─────────────┤       ├──────────────────┤       ├─────────────┤
│ id (PK)     │◄─────►│ user_id (FK)     │◄─────►│ id (PK)     │
│ email       │       │ workspace_id(FK) │       │ name        │
│ name        │       │ role             │       │ owner_id(FK)│
│ avatar_url  │       │ joined_at        │       │ created_at  │
│ created_at  │       └──────────────────┘       └─────────────┘
│ last_login  │                                         │
└─────────────┘                                         │
       │                                                │
       │               ┌─────────────┐                  │
       │               │   boards    │                  │
       │               ├─────────────┤                  │
       │               │ id (PK)     │◄─────────────────┘
       │               │ workspace_id│
       │               │ name        │
       │               │ columns     │
       │               │ created_at  │
       │               └─────────────┘
       │                       │
       │                       │
       │               ┌─────────────┐
       │               │    tasks    │
       │               ├─────────────┤
       │               │ id (PK)     │
       │               │ board_id(FK)│◄─────────┘
       │               │ title       │
       │               │ description │
       │               │ status      │
       │               │ priority    │
       │               │ assigned_to │◄─────────┘
       │               │ created_by  │◄─────────┘
       │               │ due_date    │
       │               │ position    │
       │               │ created_at  │
       │               │ updated_at  │
       │               └─────────────┘
       │                       │
       │                       │
       │               ┌─────────────┐
       │               │time_entries │
       │               ├─────────────┤
       │               │ id (PK)     │
       │               │ task_id(FK) │◄─────────┘
       │               │ user_id(FK) │◄─────────┘
       │               │ start_time  │
       │               │ end_time    │
       │               │ duration_min│
       │               │ created_at  │
       │               └─────────────┘
       │
       │               ┌─────────────┐
       │               │  comments   │
       │               ├─────────────┤
       │               │ id (PK)     │
       │               │ task_id(FK) │◄─────────┘
       │               │ user_id(FK) │◄─────────┘
       │               │ content     │
       │               │ created_at  │
       │               └─────────────┘
```

### Complete Schema Definition

```sql
-- Users table
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    avatar_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT NOW(),
    last_login TIMESTAMP,
    
    -- Indexes
    CONSTRAINT users_email_unique UNIQUE (email)
);

-- Workspaces table
CREATE TABLE workspaces (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(100) NOT NULL,
    owner_id UUID REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT workspaces_name_length CHECK (LENGTH(name) >= 1)
);

-- Workspace members (many-to-many)
CREATE TABLE workspace_members (
    workspace_id UUID REFERENCES workspaces(id) ON DELETE CASCADE,
    user_id UUID REFERENCES users(id) ON DELETE CASCADE,
    role VARCHAR(50) CHECK (role IN ('owner', 'admin', 'member')) DEFAULT 'member',
    joined_at TIMESTAMP DEFAULT NOW(),
    
    -- Composite primary key
    PRIMARY KEY (workspace_id, user_id)
);

-- Boards table
CREATE TABLE boards (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    workspace_id UUID REFERENCES workspaces(id) ON DELETE CASCADE,
    name VARCHAR(100) NOT NULL,
    columns JSONB DEFAULT '["To Do", "In Progress", "Review", "Done"]',
    created_at TIMESTAMP DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT boards_name_length CHECK (LENGTH(name) >= 1),
    CONSTRAINT boards_columns_array CHECK (jsonb_array_length(columns) > 0)
);

-- Tasks table
CREATE TABLE tasks (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    board_id UUID REFERENCES boards(id) ON DELETE CASCADE,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    status VARCHAR(50) NOT NULL DEFAULT 'To Do',
    priority VARCHAR(20) CHECK (priority IN ('low', 'medium', 'high')) DEFAULT 'medium',
    assigned_to UUID REFERENCES users(id) ON DELETE SET NULL,
    created_by UUID REFERENCES users(id) ON DELETE SET NULL,
    due_date DATE,
    position INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT tasks_title_length CHECK (LENGTH(title) >= 1),
    CONSTRAINT tasks_position_positive CHECK (position >= 0)
);

-- Time tracking entries
CREATE TABLE time_entries (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    task_id UUID REFERENCES tasks(id) ON DELETE CASCADE,
    user_id UUID REFERENCES users(id) ON DELETE CASCADE,
    start_time TIMESTAMP NOT NULL,
    end_time TIMESTAMP,
    duration_minutes INTEGER,
    created_at TIMESTAMP DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT time_entries_valid_duration CHECK (
        (end_time IS NULL AND duration_minutes IS NULL) OR
        (end_time IS NOT NULL AND end_time > start_time)
    ),
    CONSTRAINT time_entries_duration_positive CHECK (
        duration_minutes IS NULL OR duration_minutes > 0
    )
);

-- Comments table
CREATE TABLE comments (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    task_id UUID REFERENCES tasks(id) ON DELETE CASCADE,
    user_id UUID REFERENCES users(id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT comments_content_length CHECK (LENGTH(content) >= 1)
);

-- File attachments table
CREATE TABLE attachments (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    task_id UUID REFERENCES tasks(id) ON DELETE CASCADE,
    user_id UUID REFERENCES users(id) ON DELETE SET NULL,
    filename VARCHAR(255) NOT NULL,
    file_size INTEGER NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    s3_key VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    
    -- Constraints
    CONSTRAINT attachments_file_size_limit CHECK (file_size <= 10485760), -- 10MB
    CONSTRAINT attachments_filename_length CHECK (LENGTH(filename) >= 1)
);
```

### Performance Indexes

```sql
-- Indexes for performance optimization

-- Tasks table indexes
CREATE INDEX idx_tasks_board_status ON tasks(board_id, status);
CREATE INDEX idx_tasks_assigned_to ON tasks(assigned_to) WHERE assigned_to IS NOT NULL;
CREATE INDEX idx_tasks_created_by ON tasks(created_by);
CREATE INDEX idx_tasks_due_date ON tasks(due_date) WHERE due_date IS NOT NULL;
CREATE INDEX idx_tasks_updated_at ON tasks(updated_at);
CREATE INDEX idx_tasks_position ON tasks(board_id, status, position);

-- Time entries indexes
CREATE INDEX idx_time_entries_task ON time_entries(task_id);
CREATE INDEX idx_time_entries_user ON time_entries(user_id);
CREATE INDEX idx_time_entries_date_range ON time_entries(start_time, end_time);
CREATE INDEX idx_time_entries_active ON time_entries(user_id) WHERE end_time IS NULL;

-- Comments indexes
CREATE INDEX idx_comments_task ON comments(task_id);
CREATE INDEX idx_comments_user ON comments(user_id);
CREATE INDEX idx_comments_created_at ON comments(created_at);

-- Workspace members indexes
CREATE INDEX idx_workspace_members_user ON workspace_members(user_id);
CREATE INDEX idx_workspace_members_workspace ON workspace_members(workspace_id);

-- Boards indexes
CREATE INDEX idx_boards_workspace ON boards(workspace_id);

-- Users indexes
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_last_login ON users(last_login);

-- Attachments indexes
CREATE INDEX idx_attachments_task ON attachments(task_id);
CREATE INDEX idx_attachments_user ON attachments(user_id);
```

## Data Model Principles

### Design Decisions

#### UUID Primary Keys
- **Benefit:** Non-sequential, secure, globally unique
- **Trade-off:** Slightly larger storage, no ordering benefits
- **Rationale:** Better for distributed systems and security

#### JSONB for Flexible Data
```sql
-- Board columns stored as JSONB array
columns JSONB DEFAULT '["To Do", "In Progress", "Review", "Done"]'

-- Allows flexible column configuration per board
-- Supports queries like: WHERE columns ? 'In Progress'
```

#### Cascade Deletion Strategy
- **ON DELETE CASCADE:** Child records deleted with parent
- **ON DELETE SET NULL:** Preserve records, clear reference
- **Example:** Tasks preserved when user deleted, assigned_to set to NULL

#### Audit Trail Pattern
```sql
-- All tables include created_at
created_at TIMESTAMP DEFAULT NOW()

-- Modified entities include updated_at
updated_at TIMESTAMP DEFAULT NOW()

-- Trigger to auto-update updated_at
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ language 'plpgsql';

CREATE TRIGGER update_tasks_updated_at 
    BEFORE UPDATE ON tasks 
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
```

### Data Integrity Rules

#### Referential Integrity
- **Foreign keys** enforce relationships
- **Check constraints** validate data ranges
- **Unique constraints** prevent duplicates

#### Business Logic Constraints
```sql
-- Task position must be non-negative
CONSTRAINT tasks_position_positive CHECK (position >= 0)

-- Time entries must have valid duration
CONSTRAINT time_entries_valid_duration CHECK (
    (end_time IS NULL AND duration_minutes IS NULL) OR
    (end_time IS NOT NULL AND end_time > start_time)
)

-- File size limits (10MB)
CONSTRAINT attachments_file_size_limit CHECK (file_size <= 10485760)

-- Workspace roles restricted to valid values
CHECK (role IN ('owner', 'admin', 'member'))
```

## Query Patterns

### Common Queries

#### Get all tasks for a board with assignee details
```sql
SELECT 
    t.id,
    t.title,
    t.status,
    t.priority,
    t.due_date,
    t.position,
    u.name as assignee_name,
    u.avatar_url as assignee_avatar
FROM tasks t
LEFT JOIN users u ON t.assigned_to = u.id
WHERE t.board_id = $1
ORDER BY t.position ASC;
```

#### Get workspace members with their roles
```sql
SELECT 
    u.id,
    u.name,
    u.email,
    u.avatar_url,
    wm.role,
    wm.joined_at
FROM users u
JOIN workspace_members wm ON u.id = wm.user_id
WHERE wm.workspace_id = $1
ORDER BY wm.role, u.name;
```

#### Get time tracking summary for user
```sql
SELECT 
    DATE(te.start_time) as work_date,
    SUM(te.duration_minutes) as total_minutes,
    COUNT(te.id) as session_count
FROM time_entries te
WHERE te.user_id = $1
    AND te.start_time >= $2
    AND te.start_time < $3
GROUP BY DATE(te.start_time)
ORDER BY work_date DESC;
```

#### Check user permissions for workspace
```sql
SELECT wm.role
FROM workspace_members wm
WHERE wm.workspace_id = $1 
    AND wm.user_id = $2;
```

### Performance Optimization

#### Query Analysis
```sql
-- Analyze query performance
EXPLAIN ANALYZE 
SELECT t.*, u.name 
FROM tasks t 
LEFT JOIN users u ON t.assigned_to = u.id 
WHERE t.board_id = 'some-uuid';
```

#### Materialized Views for Reports
```sql
-- Task completion statistics
CREATE MATERIALIZED VIEW task_completion_stats AS
SELECT 
    b.workspace_id,
    b.id as board_id,
    b.name as board_name,
    COUNT(t.id) as total_tasks,
    COUNT(CASE WHEN t.status = 'Done' THEN 1 END) as completed_tasks,
    COUNT(CASE WHEN t.due_date < CURRENT_DATE AND t.status != 'Done' THEN 1 END) as overdue_tasks
FROM boards b
LEFT JOIN tasks t ON b.id = t.board_id
GROUP BY b.workspace_id, b.id, b.name;

-- Refresh periodically
REFRESH MATERIALIZED VIEW task_completion_stats;
```

## Migration Strategy

### Schema Versioning

#### Migration Files
```sql
-- V001__initial_schema.sql
-- V002__add_attachments_table.sql  
-- V003__add_time_tracking_indexes.sql
-- V004__add_board_columns_jsonb.sql
```

#### Sample Migration
```sql
-- Migration: Add priority column to tasks
BEGIN;

-- Add column with default value
ALTER TABLE tasks 
ADD COLUMN priority VARCHAR(20) 
CHECK (priority IN ('low', 'medium', 'high')) 
DEFAULT 'medium';

-- Update existing tasks
UPDATE tasks SET priority = 'medium' WHERE priority IS NULL;

-- Make column NOT NULL
ALTER TABLE tasks ALTER COLUMN priority SET NOT NULL;

COMMIT;
```

### Backup Strategy

#### Daily Backups
```bash
# Automated daily backup script
pg_dump taskflow_prod > backups/taskflow_$(date +%Y%m%d).sql

# Retention: Keep 30 days of daily backups
find backups/ -name "taskflow_*.sql" -mtime +30 -delete
```

#### Point-in-Time Recovery
```sql
-- Enable WAL archiving for PITR
archive_mode = on
archive_command = 'cp %p /backups/wal/%f'
wal_level = replica
```

## Security Considerations

### Data Access Patterns

#### Row Level Security (RLS)
```sql
-- Enable RLS on sensitive tables
ALTER TABLE tasks ENABLE ROW LEVEL SECURITY;

-- Users can only see tasks in their workspaces
CREATE POLICY tasks_workspace_access ON tasks
FOR ALL TO app_user
USING (
    board_id IN (
        SELECT b.id FROM boards b
        JOIN workspace_members wm ON b.workspace_id = wm.workspace_id
        WHERE wm.user_id = current_user_id()
    )
);
```

#### Data Encryption
- **At rest:** Database encryption enabled
- **In transit:** SSL/TLS connections required
- **Application level:** Sensitive fields encrypted before storage

### Compliance Requirements

#### GDPR Compliance
```sql
-- User data deletion (GDPR Right to be Forgotten)
CREATE OR REPLACE FUNCTION delete_user_data(user_uuid UUID)
RETURNS VOID AS $$
BEGIN
    -- Anonymize user data instead of hard delete
    UPDATE users SET 
        email = 'deleted-' || id || '@example.com',
        name = 'Deleted User',
        avatar_url = NULL
    WHERE id = user_uuid;
    
    -- Remove from workspaces
    DELETE FROM workspace_members WHERE user_id = user_uuid;
    
    -- Anonymize comments
    UPDATE comments SET content = '[Comment deleted]' WHERE user_id = user_uuid;
END;
$$ LANGUAGE plpgsql;
```

This database design provides a solid foundation for the TaskFlow application with proper relationships, performance optimization, and security considerations.