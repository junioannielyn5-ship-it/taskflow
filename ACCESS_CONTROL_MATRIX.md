# Access Control Matrix (Standard Order)

Date: 2026-03-02
Purpose: Single source of truth for role/feature ordering and expected permission scope.

## Ordering Standard (Do Not Reorder)

Role column order:
1. Member
2. Team Lead
3. Project Manager
4. Admin

Feature row order:
1. Create Project
2. Delete Project
3. Create Task
4. Edit Any Task
5. Move to Done
6. Manage Users
7. View Reports

## Matrix

| Feature | Member | Team Lead | Project Manager | Admin |
|---|---|---|---|---|
| Create Project | ❌ | ✅ | ✅ | ✅ |
| Delete Project | ❌ | ❌ | ❌ | ✅ |
| Create Task | ✅ | ✅ | ✅ | ✅ |
| Edit Any Task | ❌ | ✅ | ✅ | ✅ |
| Move to Done | ❌ | ✅ | ✅ | ✅ |
| Manage Users | ❌ | ❌ | ❌ | ✅ |
| View Reports | Own | Team | Project | Global |

## Scope Notes

- Create Project: enforced by server-side gate/policy and role middleware.
- Delete Project: restricted to admin only.
- Create Task: allowed only when user is authorized in project scope.
- Edit Any Task: lead/pm/admin can edit broadly; creator/member scope remains policy-controlled.
- Move to Done: follows workflow transition rules plus role permissions.
- Manage Users: admin-only operations.
- View Reports: scope widens by role from own/team/project/global.

## Usage

- Use this exact order in all BRD tables, AI prompts, QA checklists, and UAT scripts.
- If role policy changes, update this file first, then sync all dependent docs.
