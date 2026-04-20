# MVP Coverage Matrix (Post-Fix Validation)

Date: 2026-03-02  
Validation basis: code scan + automated tests (full suite: 62 passed, 0 failed)

## Legend
- ✅ Complete
- 🟡 Partial / verify further
- ⚪ Optional / Phase 2
- ❌ Missing

## Access-Control Sequence Standard

This project uses the exact role/feature order below for all access-control documents and AI prompts.

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

Reference matrix:

| Feature | Member | Team Lead | Project Manager | Admin |
|---|---|---|---|---|
| Create Project | ❌ | ✅ | ✅ | ✅ |
| Delete Project | ❌ | ❌ | ❌ | ✅ |
| Create Task | ✅ | ✅ | ✅ | ✅ |
| Edit Any Task | ❌ | ✅ | ✅ | ✅ |
| Move to Done | ❌ | ✅ | ✅ | ✅ |
| Manage Users | ❌ | ❌ | ❌ | ✅ |
| View Reports | Own | Team | Project | Global |

## Module Compliance (1–10)

| Module | Target Scope | Status | Notes |
|---|---|---|---|
| 1. IAM | Roles, middleware, policies scaffolding, role route groups, access tests | ✅ | Role middleware + gates + policy wiring active; route groups enforced; access tests passing. |
| 2. Projects & Membership | Project CRUD, membership mgmt, visibility, lead/member roles | ✅ | Membership enforcement and visibility rules active; create-project rule aligned to PM/Lead/Admin. |
| 3. Tasks | Task CRUD, multi-assignees, filters, project membership enforcement, emit events | ✅ | CRUD + filters + assignment + membership checks implemented; domain events emitted. |
| 4. Workflow & Activity Log | State machine transitions, activity logs, timeline endpoint | ✅ | Transition validation + timeline endpoints + status/activity logging active; workflow tests green. |
| 5. Comments | Task comments, membership auth, pagination, event emission | ✅ | Member-only comment access + paginated list + CommentCreated event. |
| 6. Attachments | Secure upload/download, type/size validation, private storage, authz tests | ✅ | Private disk configured and used; validation + authorization checks in place; tests passing. |
| 7. Notifications | Event-driven in-app notifications, read/read-all endpoints | ✅ | Listeners wired to task/comment events; controller read/read-all endpoints implemented. |
| 8. Reporting | Authorized overdue/completed/cycle-time reports with filters | ✅ | Viewer-scoped query logic active; overdue list now paginated; report endpoints present. |
| 9. Admin/Configuration | User management, role assignment scaffolding, auth tests | 🟡 | Core endpoints and role update/deactivate flows exist; broader admin UX/business rules need further UAT confirmation. |
| 10. Shared/Core | Shared enums, reusable filters/helpers, minimal cross-cutting utilities | ✅ | Shared enums/filters and modular boundaries are in place and used by Tasks/Workflow/Reporting. |

## API Boundary Rule Check

| Rule | Status | Notes |
|---|---|---|
| Tasks must not own workflow transition validation/history writing | ✅ | Workflow service + listeners handle transition logic and activity records. |
| Workflow should be single source for transition rules | ✅ | Transition map/service-based validation implemented. |
| Notifications should be event-driven, not controller-direct orchestration | ✅ | Workflow direct notify coupling removed; listeners handle notifications via emitted events. |

## Quality Gates

| Gate | Status | Notes |
|---|---|---|
| 1) Server-side authorization | ✅ | Middleware/gates/policies enforced across modules. |
| 2) Validation via FormRequest | ✅ | Project/task/comment/attachment requests validated server-side. |
| 3) Pagination for lists | ✅ | Tasks/comments/notifications/reporting overdue list provide pagination. |
| 4) N+1 avoidance (eager loading) | 🟡 | Many critical queries eager-load relations; full query-plan optimization audit still recommended. |
| 5) Activity history where required | ✅ | Workflow activity logs captured and timeline exposed. |
| 6) Private upload storage + checks | ✅ | Private disk configured; authorization + file constraints applied. |
| 7) No cross-module DB writes outside ownership | 🟡 | Architecture is largely event/service-based; advisable to run one focused architecture review for edge paths. |
| 8) Required tests (minimum feature coverage) | ✅ | Feature coverage exists per module; full suite currently green. |

## Current Assessment

- MVP baseline is stable and test-green after fixes.
- Immediate blockers removed (auth rule mismatch, workflow-notification coupling, private disk config, list pagination gaps).
- Remaining risk is mostly hardening/architecture review depth, not missing core functionality.
