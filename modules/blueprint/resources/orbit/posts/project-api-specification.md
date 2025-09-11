---
title: API Specification
slug: project-api-specification
is_home_page: 0
documentation_group: Project
navigation_group: Design
navigation_sort: 8.0
created_at: 2025-09-11T00:00:00+00:00
updated_at: 2025-09-11T00:00:00+00:00
---
# API Specification Example

API specification documents define the contract between frontend and backend systems. Clear documentation ensures consistent implementation and easier integration for developers.

## TaskFlow API Documentation

**Base URL:** `https://api.taskflow.io/v1`  
**Authentication:** Bearer token (JWT)  
**Content-Type:** `application/json`

### API Design Principles

- **RESTful conventions** for resource naming and HTTP methods
- **Consistent response formats** with standard error codes
- **Version prefix** in URL (`/v1/`) for future compatibility
- **Rate limiting** to prevent abuse and ensure fair usage
- **Pagination** for large result sets

## Authentication

### Login
Authenticate user and receive JWT token.

```http
POST /auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "secretpass123"
}
```

**Response: 200 OK**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "expires_in": 3600,
  "user": {
    "id": "123e4567-e89b-12d3-a456-426614174000",
    "email": "user@example.com",
    "name": "Jane Doe",
    "avatar_url": "https://cdn.taskflow.io/avatars/jane.jpg"
  }
}
```

### OAuth Login (Google)
Initiate OAuth flow for Google authentication.

```http
GET /auth/google
```

**Response: 302 Redirect**
```
Location: https://accounts.google.com/oauth/authorize?client_id=...
```

### Refresh Token
Extend session with new JWT token.

```http
POST /auth/refresh
Authorization: Bearer {token}
```

**Response: 200 OK**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "expires_in": 3600
}
```

## Workspaces

### List User Workspaces
Get all workspaces the authenticated user belongs to.

```http
GET /workspaces
Authorization: Bearer {token}
```

**Response: 200 OK**
```json
{
  "data": [
    {
      "id": "ws-uuid-here",
      "name": "Marketing Team",
      "role": "admin",
      "member_count": 8,
      "created_at": "2025-01-15T10:30:00Z"
    }
  ],
  "meta": {
    "total": 1
  }
}
```

### Create Workspace
Create a new workspace (user becomes owner).

```http
POST /workspaces
Authorization: Bearer {token}

{
  "name": "Design Team"
}
```

**Response: 201 Created**
```json
{
  "data": {
    "id": "ws-new-uuid",
    "name": "Design Team",
    "role": "owner",
    "member_count": 1,
    "created_at": "2025-01-15T11:00:00Z"
  }
}
```

## Boards

### List Workspace Boards
Get all boards in a workspace.

```http
GET /workspaces/{workspaceId}/boards
Authorization: Bearer {token}
```

**Response: 200 OK**
```json
{
  "data": [
    {
      "id": "board-uuid-here",
      "name": "Marketing Campaign",
      "columns": ["To Do", "In Progress", "Review", "Done"],
      "task_count": 15,
      "created_at": "2025-01-15T10:30:00Z"
    }
  ],
  "meta": {
    "total": 1
  }
}
```

### Create Board
Create a new board in a workspace.

```http
POST /workspaces/{workspaceId}/boards
Authorization: Bearer {token}

{
  "name": "Q2 Product Launch",
  "columns": ["Backlog", "Sprint", "In Review", "Done"]
}
```

**Response: 201 Created**
```json
{
  "data": {
    "id": "board-new-uuid",
    "name": "Q2 Product Launch",
    "columns": ["Backlog", "Sprint", "In Review", "Done"],
    "task_count": 0,
    "created_at": "2025-01-15T11:00:00Z"
  }
}
```

## Tasks

### List Board Tasks
Get all tasks for a specific board.

```http
GET /boards/{boardId}/tasks
Authorization: Bearer {token}
```

**Query Parameters:**
- `status` (optional): Filter by task status
- `assigned_to` (optional): Filter by assignee user ID
- `limit` (optional): Number of results (default: 50)
- `offset` (optional): Pagination offset (default: 0)

**Response: 200 OK**
```json
{
  "data": [
    {
      "id": "task-uuid-here",
      "title": "Design new landing page",
      "description": "Create mockups for Q2 campaign",
      "status": "In Progress",
      "priority": "high",
      "position": 1,
      "due_date": "2025-05-15",
      "assigned_to": {
        "id": "user-uuid",
        "name": "Casey Patel",
        "avatar_url": "https://cdn.taskflow.io/avatars/casey.jpg"
      },
      "created_by": {
        "id": "user-uuid-2",
        "name": "Alex Rivera"
      },
      "created_at": "2025-01-15T10:30:00Z",
      "updated_at": "2025-01-15T11:00:00Z"
    }
  ],
  "meta": {
    "total": 15,
    "limit": 50,
    "offset": 0
  }
}
```

### Create Task
Create a new task on a board.

```http
POST /boards/{boardId}/tasks
Authorization: Bearer {token}

{
  "title": "Design new landing page",
  "description": "Create mockups for Q2 campaign",
  "priority": "high",
  "assigned_to": "user-uuid-here",
  "due_date": "2025-05-15"
}
```

**Response: 201 Created**
```json
{
  "data": {
    "id": "task-new-uuid",
    "title": "Design new landing page",
    "description": "Create mockups for Q2 campaign",
    "status": "To Do",
    "priority": "high",
    "position": 1,
    "due_date": "2025-05-15",
    "assigned_to": {
      "id": "user-uuid-here",
      "name": "Casey Patel",
      "avatar_url": "https://cdn.taskflow.io/avatars/casey.jpg"
    },
    "created_by": {
      "id": "current-user-uuid",
      "name": "Alex Rivera"
    },
    "created_at": "2025-01-15T11:00:00Z",
    "updated_at": "2025-01-15T11:00:00Z"
  }
}
```

### Update Task
Update task properties (supports partial updates).

```http
PATCH /tasks/{taskId}
Authorization: Bearer {token}

{
  "status": "In Progress",
  "position": 2
}
```

**Response: 200 OK**
```json
{
  "data": {
    "id": "task-uuid-here",
    "title": "Design new landing page",
    "status": "In Progress",
    "position": 2,
    "updated_at": "2025-01-15T12:00:00Z"
  }
}
```

### Delete Task
Permanently delete a task.

```http
DELETE /tasks/{taskId}
Authorization: Bearer {token}
```

**Response: 204 No Content**

## Time Tracking

### Start Timer
Start time tracking for a task.

```http
POST /tasks/{taskId}/timer/start
Authorization: Bearer {token}
```

**Response: 200 OK**
```json
{
  "data": {
    "time_entry_id": "entry-uuid-here",
    "task_id": "task-uuid-here",
    "start_time": "2025-01-15T11:00:00Z"
  }
}
```

### Stop Timer
Stop active timer and calculate duration.

```http
POST /tasks/{taskId}/timer/stop
Authorization: Bearer {token}
```

**Response: 200 OK**
```json
{
  "data": {
    "time_entry_id": "entry-uuid-here",
    "task_id": "task-uuid-here",
    "start_time": "2025-01-15T11:00:00Z",
    "end_time": "2025-01-15T13:30:00Z",
    "duration_minutes": 150
  }
}
```

### Get Time Entries
List time entries for a user or task.

```http
GET /time-entries
Authorization: Bearer {token}
```

**Query Parameters:**
- `user_id` (optional): Filter by user
- `task_id` (optional): Filter by task
- `start_date` (optional): Filter from date (YYYY-MM-DD)
- `end_date` (optional): Filter to date (YYYY-MM-DD)

**Response: 200 OK**
```json
{
  "data": [
    {
      "id": "entry-uuid-here",
      "task": {
        "id": "task-uuid",
        "title": "Design landing page"
      },
      "user": {
        "id": "user-uuid",
        "name": "Casey Patel"
      },
      "start_time": "2025-01-15T11:00:00Z",
      "end_time": "2025-01-15T13:30:00Z",
      "duration_minutes": 150,
      "created_at": "2025-01-15T11:00:00Z"
    }
  ],
  "meta": {
    "total": 1,
    "total_duration_minutes": 150
  }
}
```

## Comments

### List Task Comments
Get all comments for a task.

```http
GET /tasks/{taskId}/comments
Authorization: Bearer {token}
```

**Response: 200 OK**
```json
{
  "data": [
    {
      "id": "comment-uuid-here",
      "content": "Started working on the design concepts. Will have initial mockups ready by EOD.",
      "user": {
        "id": "user-uuid",
        "name": "Casey Patel",
        "avatar_url": "https://cdn.taskflow.io/avatars/casey.jpg"
      },
      "created_at": "2025-01-15T14:30:00Z"
    }
  ],
  "meta": {
    "total": 1
  }
}
```

### Create Comment
Add a comment to a task.

```http
POST /tasks/{taskId}/comments
Authorization: Bearer {token}

{
  "content": "Initial mockups are ready for review. @alex please take a look."
}
```

**Response: 201 Created**
```json
{
  "data": {
    "id": "comment-new-uuid",
    "content": "Initial mockups are ready for review. @alex please take a look.",
    "user": {
      "id": "current-user-uuid",
      "name": "Casey Patel",
      "avatar_url": "https://cdn.taskflow.io/avatars/casey.jpg"
    },
    "created_at": "2025-01-15T16:30:00Z"
  }
}
```

## File Attachments

### Upload File
Upload a file attachment to a task.

```http
POST /tasks/{taskId}/attachments
Authorization: Bearer {token}
Content-Type: multipart/form-data

file: [binary file data]
```

**Response: 201 Created**
```json
{
  "data": {
    "id": "attachment-uuid-here",
    "filename": "mockups.sketch",
    "file_size": 2048576,
    "mime_type": "application/octet-stream",
    "download_url": "https://api.taskflow.io/v1/attachments/attachment-uuid-here/download",
    "uploaded_by": {
      "id": "user-uuid",
      "name": "Casey Patel"
    },
    "created_at": "2025-01-15T16:45:00Z"
  }
}
```

### Download File
Download a file attachment.

```http
GET /attachments/{attachmentId}/download
Authorization: Bearer {token}
```

**Response: 200 OK**
```
Content-Type: application/octet-stream
Content-Disposition: attachment; filename="mockups.sketch"
Content-Length: 2048576

[binary file data]
```

## Error Handling

### Standard Error Response Format
All errors follow a consistent JSON structure.

```json
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "The request data is invalid",
    "details": {
      "field": "title",
      "issue": "Title is required and must be between 1-200 characters"
    }
  }
}
```

### Common HTTP Status Codes

| Code | Meaning | Usage |
|------|---------|-------|
| 200 | OK | Successful GET, PATCH requests |
| 201 | Created | Successful POST requests |
| 204 | No Content | Successful DELETE requests |
| 400 | Bad Request | Invalid request data or parameters |
| 401 | Unauthorized | Missing or invalid authentication token |
| 403 | Forbidden | User lacks permission for the resource |
| 404 | Not Found | Requested resource doesn't exist |
| 422 | Unprocessable Entity | Valid JSON but business logic errors |
| 429 | Too Many Requests | Rate limit exceeded |
| 500 | Internal Server Error | Unexpected server error |

### Error Code Reference

| Error Code | Description | Example |
|------------|-------------|---------|
| `INVALID_CREDENTIALS` | Login failed | Wrong email/password combination |
| `TOKEN_EXPIRED` | JWT token expired | Token needs to be refreshed |
| `VALIDATION_ERROR` | Request validation failed | Missing required fields |
| `PERMISSION_DENIED` | Insufficient permissions | User can't access workspace |
| `RESOURCE_NOT_FOUND` | Resource doesn't exist | Task ID not found |
| `RATE_LIMIT_EXCEEDED` | Too many requests | API rate limit hit |
| `FILE_TOO_LARGE` | File exceeds size limit | Attachment over 10MB |
| `DUPLICATE_RESOURCE` | Resource already exists | Workspace name taken |

## Rate Limiting

### Rate Limit Headers
API responses include rate limiting information in headers.

```http
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 999
X-RateLimit-Reset: 1642694400
```

### Rate Limits by Endpoint Type

| Endpoint Type | Limit | Window |
|---------------|-------|--------|
| Authentication | 5 requests | 15 minutes |
| General API | 1000 requests | 1 hour |
| File Upload | 20 requests | 1 hour |
| WebSocket | 5 connections | Per user |

### Rate Limit Exceeded Response
```http
HTTP/1.1 429 Too Many Requests
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 0
X-RateLimit-Reset: 1642694400

{
  "error": {
    "code": "RATE_LIMIT_EXCEEDED",
    "message": "Rate limit exceeded. Try again later.",
    "details": {
      "retry_after": 60
    }
  }
}
```

## Pagination

### Query Parameters
Large result sets use cursor-based pagination.

```http
GET /boards/{boardId}/tasks?limit=25&offset=50
```

### Pagination Response
```json
{
  "data": [...],
  "meta": {
    "total": 150,
    "limit": 25,
    "offset": 50,
    "has_more": true
  },
  "links": {
    "next": "/boards/board-id/tasks?limit=25&offset=75",
    "prev": "/boards/board-id/tasks?limit=25&offset=25"
  }
}
```

## WebSocket Events

### Connection
```javascript
const socket = io('wss://api.taskflow.io', {
  auth: {
    token: 'jwt-token-here'
  }
});
```

### Real-time Events

#### Task Updates
Broadcasted when tasks are created, updated, or deleted.

```javascript
socket.on('task:updated', (data) => {
  console.log('Task updated:', data);
  // {
  //   task_id: 'uuid',
  //   board_id: 'uuid',
  //   changes: { status: 'In Progress', position: 2 },
  //   updated_by: { id: 'uuid', name: 'User Name' }
  // }
});
```

#### Timer Events
Real-time timer start/stop notifications.

```javascript
socket.on('timer:started', (data) => {
  console.log('Timer started:', data);
  // {
  //   task_id: 'uuid',
  //   user_id: 'uuid',
  //   start_time: '2025-01-15T11:00:00Z'
  // }
});
```

#### Comment Events
New comment notifications.

```javascript
socket.on('comment:created', (data) => {
  console.log('New comment:', data);
  // {
  //   comment_id: 'uuid',
  //   task_id: 'uuid',
  //   content: 'Comment text',
  //   user: { id: 'uuid', name: 'User Name' }
  // }
});
```

## API Testing

### Sample cURL Commands

#### Login
```bash
curl -X POST https://api.taskflow.io/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password123"}'
```

#### Create Task
```bash
curl -X POST https://api.taskflow.io/v1/boards/board-uuid/tasks \
  -H "Authorization: Bearer your-jwt-token" \
  -H "Content-Type: application/json" \
  -d '{"title": "New Task", "priority": "high"}'
```

### Postman Collection
Import our [Postman collection](https://taskflow.io/api/postman.json) for comprehensive API testing with pre-configured requests and environment variables.

This API specification provides a complete reference for integrating with the TaskFlow application, ensuring consistent and reliable communication between frontend and backend systems.