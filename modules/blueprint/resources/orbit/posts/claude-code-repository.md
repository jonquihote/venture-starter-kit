---
title: 'Code Repository'
slug: claude-code-repository
is_home_page: false
documentation_group: Claude
navigation_group: Context
navigation_sort: 9.0
created_at: 2025-09-12T01:12:58+00:00
updated_at: 2025-09-18T12:52:05+00:00
---

# Code Repository

## Commit Message Conventions

This project enforces commit message standards using **commitlint** with the Conventional Commits specification. All
commits must follow these conventions to maintain a clean, meaningful project history and enable automated tooling.

### Setup Overview

The project has commitlint pre-configured:

- **commitlint** validates commit messages against conventional commit standards
- **husky** git hook runs commitlint automatically on every commit
- Configuration: `commitlint.config.js` extends `@commitlint/config-conventional`

### Conventional Commits Format

Every commit message must follow this structure:

```
<type>: <description>

[optional body]

[optional footer(s)]
```

Every commit message MUST ALSO FOLLOW the section "The Seven Rules of Great Commit Messages"

#### Commit Types

| Type       | Purpose                           | Semantic Version | Example                              |
|------------|-----------------------------------|------------------|--------------------------------------|
| `feat`     | New feature                       | MINOR            | `feat: add user authentication`      |
| `fix`      | Bug fix                           | PATCH            | `fix: resolve login redirect issue`  |
| `docs`     | Documentation only                | -                | `docs: update API endpoints`         |
| `style`    | Code formatting (no logic change) | -                | `style: fix indentation`             |
| `refactor` | Code restructuring                | -                | `refactor: extract validation logic` |
| `perf`     | Performance improvement           | -                | `perf: optimize database queries`    |
| `test`     | Adding/updating tests             | -                | `test: add auth middleware tests`    |
| `build`    | Build system/dependencies         | -                | `build: upgrade to Laravel 12`       |
| `ci`       | CI/CD configuration               | -                | `ci: add GitHub Actions workflow`    |
| `chore`    | Maintenance tasks                 | -                | `chore: update .gitignore`           |
| `revert`   | Revert previous commit            | -                | `revert: revert feat: add user auth` |

#### Breaking Changes

Mark breaking changes with `!` after type or include `BREAKING CHANGE:` footer:

```
feat!: change authentication endpoint structure

BREAKING CHANGE: Auth endpoints moved from /auth/* to /api/auth/*
```

### The Seven Rules of Great Commit Messages

Based on [How to Write a Git Commit Message](https://cbea.ms/git-commit/):

1. **Separate subject from body with a blank line**
   ```
   fix: resolve user session timeout issue
   
   The session was expiring after 30 minutes regardless of activity.
   Updated the session handler to properly refresh on user interaction.
   ```

2. **Limit the subject line to 50 characters**
    - Forces concise, focused descriptions
    - GitHub truncates longer subjects

3. **Capitalize the subject line**
    - ✅ `feat: Add user profile page`
    - ❌ `feat: add user profile page`

4. **Do not end the subject line with a period**
    - ✅ `fix: Correct validation logic`
    - ❌ `fix: Correct validation logic.`

5. **Use the imperative mood in the subject line**
    - Write as if completing: "If applied, this commit will..."
    - ✅ `refactor: Extract email service` (will extract...)
    - ❌ `refactor: Extracted email service` (will extracted...?)

6. **Wrap the body at 72 characters**
    - Ensures readability in terminal and GitHub
    - Most editors can auto-wrap at this width

7. **Use the body to explain what and why, not how**
    - Context is crucial for future developers
    - The code shows how; the message explains why

### Practical Examples

#### Simple Feature Addition

```
feat: add export to CSV functionality

Users need to export their data for external analysis.
This adds a CSV export button to all data tables.
```

#### Bug Fix with Context

```
fix: prevent duplicate form submissions

Users were accidentally creating duplicate records by 
double-clicking the submit button. Added debouncing
and disabled state to prevent multiple submissions.

Fixes #234
```

#### Refactoring with Explanation

```
refactor: consolidate validation rules into form requests

Validation logic was scattered across controllers making
it hard to maintain. Centralized all validation into
dedicated FormRequest classes following Laravel conventions.
```

#### Breaking Change

```
feat!: standardize API response format

BREAKING CHANGE: All API responses now follow the JSON:API
specification. Previous response structure is no longer supported.

Migration guide: https://docs.example.com/api-migration-v2
```

#### Cross-Module Changes

When changes affect multiple modules or the context isn't obvious, explain in the body:

```
feat: add unified notification system

Implemented a centralized notification service that works
across all modules (aeon, alpha, blueprint, omega). Each
module can now dispatch notifications through the shared
service while maintaining module-specific templates.
```

### Common Scenarios

#### Fixing Tests

```
test: fix flaky authentication tests

Tests were failing intermittently due to timing issues.
Added proper wait conditions and database transactions.
```

#### Updating Dependencies

```
build: upgrade Laravel to v12

- Updated composer.json dependencies
- Ran required migrations for framework changes
- Updated deprecated method calls
```

#### Documentation Updates

```
docs: add commit convention guidelines

Documented the project's commit message standards
including conventional commits format and examples.
```

### Validation and Enforcement

Commitlint will automatically validate your commit messages. If a commit doesn't meet the standards:

1. **The commit will be rejected** with an error explaining the issue
2. **Fix the message** using `git commit --amend` for the last commit
3. **Review the rules** in this documentation

Common validation errors:

- `type must be one of [feat, fix, docs, ...]` - Invalid commit type
- `subject may not be empty` - Missing description
- `subject must not be sentence-case` - Don't capitalize after the type
- `header must not be longer than 100 characters` - Subject too long

### Benefits of Following These Conventions

1. **Automated CHANGELOG generation** - Tools can generate release notes
2. **Semantic versioning** - Automatic version bumping based on commit types
3. **Better collaboration** - Clear communication of changes
4. **Easier debugging** - Meaningful git history for troubleshooting
5. **CI/CD automation** - Trigger specific workflows based on commit types

### Quick Reference

```bash
# Feature
git commit -m "feat: add new feature"

# Bug fix
git commit -m "fix: resolve critical issue"

# Breaking change
git commit -m "feat!: restructure API endpoints"

# With body for context
git commit -m "fix: resolve login issue" -m "Users were unable to login with special characters in passwords"

# With body for module context
git commit -m "feat: add dashboard widgets" -m "Added customizable widgets to the omega module dashboard"

# Revert
git commit -m "revert: feat: add experimental feature"
```

### Tips for Writing Good Commit Messages

1. **Think before you commit** - Is this change atomic and complete?
2. **Be specific** - "fix: resolve login timeout after 30 minutes" is better than "fix: login bug"
3. **Include context in body when needed** - Especially for cross-module changes or non-obvious contexts
4. **Reference issues** - Include issue numbers when applicable (e.g., "Fixes #123")
5. **Keep it professional** - Avoid humor, inside jokes, or vague descriptions
6. **One logical change per commit** - Don't bundle unrelated changes together

### Resources

- [Conventional Commits Specification](https://www.conventionalcommits.org/)
- [commitlint Documentation](https://commitlint.js.org/)
- [How to Write a Git Commit Message](https://cbea.ms/git-commit/)
