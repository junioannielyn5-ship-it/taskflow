# AI Prompt Pack — Module Task Cards (MVP)

Use this exact structure per module when generating implementation prompts for AI builders.

## Global Constraints

- Respect data ownership; no cross-module writes outside owned tables.
- Enforce authorization server-side (middleware + policies/gates).
- Keep list endpoints paginated.
- Use domain events for cross-module communication.
- Add at least 3 feature tests per module task.

## Standard Access-Control Order (Use This Exact Sequence)

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

---

## Module 1 — Identity & Access (IAM)

Module: Identity & Access (IAM)  
Goal: Provide authentication, role checks, middleware aliases, and policy/gate scaffolding.  
Owned tables: users, roles, role_user  
Endpoints: auth login/logout; role-protected route groups; profile/security routes  
Policies/Rules:
- Role middleware must return 401 for unauthenticated and 403 for unauthorized.
- Policy/gate checks required for protected resources.
- Route groups must support role-based access patterns.
Events to emit:
- Auth-related events as needed (login/logout/profile updates).
Acceptance criteria:
- Role middleware active and used by route groups.
- Gate/policy checks are enforced on protected endpoints.
- Access-control tests pass for allow/deny paths.
Tests required:
- Feature: non-admin cannot access admin route.
- Feature: allowed role can access role-protected route.
- Feature: unauthenticated user is rejected.

AI build prompt:
"Implement IAM module: roles + middleware + policies scaffolding. Provide role-based route groups. Include tests for access control."

---

## Module 2 — Projects & Membership

Module: Projects & Membership  
Goal: Create/update projects, manage membership, and enforce project visibility.  
Owned tables: projects, project_members (project_id, user_id, role)  
Endpoints:
- POST /projects
- GET /projects
- GET /projects/{id}
- PUT /projects/{id}
- POST /projects/{id}/members
- DELETE /projects/{id}/members/{userId}
Policies/Rules:
- Only PM/Lead/Admin can create projects.
- Only project leads/admin can manage membership.
- Project list/details must be filtered by membership visibility.
Events to emit:
- ProjectCreated (optional)
- ProjectMemberAdded / ProjectMemberRemoved (optional)
Acceptance criteria:
- Membership operations are blocked for unauthorized users.
- Non-members cannot view project details.
- Project list returns only authorized projects.
Tests required:
- Feature: PM/Lead/Admin can create; member cannot.
- Feature: lead/admin can add/remove members; member cannot.
- Feature: non-member cannot access project detail.

AI build prompt:
"Build Projects module with membership enforcement. Include policies for create/manage membership. Return project lists filtered by membership."

---

## Module 3 — Tasks

Module: Tasks  
Goal: Task CRUD, assignment, filterable lists, and project-scoped authorization.  
Owned tables: tasks, task_assignees  
Endpoints:
- POST /projects/{projectId}/tasks
- GET /projects/{projectId}/tasks?status=&assignee=&due=&priority=
- GET /tasks/{id}
- PUT /tasks/{id}
- DELETE /tasks/{id}
- POST /tasks/{id}/assign
- DELETE /tasks/{id}/assignees/{userId}
Policies/Rules:
- Task must belong to a project.
- Only project members can create/view tasks in that project.
- Creator or lead/admin can edit core fields.
- Multiple assignees supported.
Events to emit:
- TaskCreated
- TaskUpdated
- TaskAssigned
- TaskStatusChanged
Acceptance criteria:
- Non-members cannot create/view project tasks.
- Filters and pagination work on task list.
- Assignee validation ensures assignees are project members.
Tests required:
- Feature: non-member cannot create task.
- Feature: task list filters + pagination return expected scope.
- Feature: cannot assign non-project member.

AI build prompt:
"Build Tasks module with Eloquent relationships and filterable list queries. Enforce project membership. Don’t implement activity logs here—emit domain events."

---

## Module 4 — Task Workflow & Activity Log

Module: Task Workflow & Activity Log  
Goal: Enforce status transitions and record activity timeline.  
Owned tables: task_activity_logs  
Endpoints:
- POST /tasks/{id}/status
- GET /tasks/{id}/activity
- GET /tasks/{id}/transitions
Policies/Rules:
- Allowed statuses: todo, in_progress, blocked, for_review, done.
- Transition rules:
  - todo → in_progress|blocked
  - in_progress → blocked|for_review
  - blocked → in_progress
  - for_review → done|in_progress
- Completion permission can be restricted to lead/admin/pm.
- Workflow is single source of truth for transition validation.
Events to emit:
- Workflow-driven status updates should rely on TaskStatusChanged event stream.
Acceptance criteria:
- Invalid transitions return 422.
- Status changes produce timeline activity logs with actor + old/new.
- Timeline endpoint returns ordered activity entries.
Tests required:
- Feature: invalid transition is rejected.
- Feature: authorized role can complete task; unauthorized cannot.
- Feature: status change appears in activity timeline.

AI build prompt:
"Implement Workflow module as a state machine service with transition validation. Record activity logs on changes. Provide timeline endpoint."

---

## Module 5 — Comments

Module: Comments  
Goal: Add task comments with membership authorization and event emission.  
Owned tables: task_comments  
Endpoints:
- POST /tasks/{id}/comments
- GET /tasks/{id}/comments
- DELETE /comments/{id}
Policies/Rules:
- Only project members can create/list comments.
- Delete allowed for comment author or admin.
- Comment list must be paginated.
Events to emit:
- CommentCreated
Acceptance criteria:
- Unauthorized/non-members cannot comment.
- Comment list is paginated and scoped to task membership.
- CommentCreated is emitted for downstream notifications.
Tests required:
- Feature: member can comment.
- Feature: non-member cannot comment.
- Feature: non-owner cannot delete another user comment.

AI build prompt:
"Build task comments with membership authorization and pagination. Emit CommentCreated event for notifications."

---

## Module 6 — Attachments

Module: Attachments  
Goal: Secure upload/download/delete of task attachments in private storage.  
Owned tables: task_attachments  
Endpoints:
- POST /tasks/{id}/attachments
- GET /attachments/{id}/download
- DELETE /attachments/{id}
Policies/Rules:
- Validate type/size on upload.
- Store files on private disk.
- Download allowed only for authorized project members.
- Delete allowed for owner or admin.
Events to emit:
- AttachmentUploaded (optional)
- AttachmentDeleted (optional)
Acceptance criteria:
- File is stored privately and not exposed publicly.
- Unauthorized users cannot download/delete.
- Record and file lifecycle remain consistent.
Tests required:
- Feature: invalid file type/size rejected.
- Feature: unauthorized download blocked.
- Feature: delete removes DB record and file.

AI build prompt:
"Implement secure task attachments with private storage and download authorization. Add validation and tests for file rules."

---

## Module 7 — Notifications

Module: Notifications  
Goal: Event-driven in-app notification feed and read actions.  
Owned tables: notifications, notification_preferences (optional)  
Endpoints:
- GET /notifications
- POST /notifications/{id}/read
- POST /notifications/read-all
Policies/Rules:
- Users can only read/mark their own notifications.
- List endpoint must be paginated.
- Controllers should not directly orchestrate cross-module business actions.
Events to emit:
- Consumes: TaskAssigned, TaskStatusChanged, CommentCreated
- Emits: optional NotificationDelivered event
Acceptance criteria:
- Notifications are created via event listeners.
- Read/read-all actions update only current user notifications.
- No duplicate recipient spam for same event.
Tests required:
- Feature: user can fetch own notifications only.
- Feature: user can mark one notification as read.
- Feature: user can mark all as read.

AI build prompt:
"Implement event-driven notifications using Laravel notifications. Create listeners for TaskAssigned, StatusChanged, CommentCreated."

---

## Module 8 — Reporting (Read-only)

Module: Reporting  
Goal: Provide overdue/completed/cycle-time reports scoped by authorization.  
Owned tables: none (read-only from tasks + activity logs)  
Endpoints:
- GET /reports/overdue?project=&assignee=&from=&to=
- GET /reports/completed?from=&to=
- GET /reports/cycle-time?project=&from=&to=
Policies/Rules:
- Report data must include only projects the viewer can access.
- List-style report endpoints should paginate.
- Reporting module must not mutate task/workflow state.
Events to emit:
- Optional export/audit events only.
Acceptance criteria:
- Overdue and completed reports reflect filters correctly.
- Cycle time uses workflow/activity data.
- Authorization scope is enforced at query layer.
Tests required:
- Feature: unauthorized project data excluded from results.
- Feature: overdue query returns expected records.
- Feature: cycle-time endpoint returns computed metric.

AI build prompt:
"Build reporting queries with pagination and filters. Ensure reports only include projects user is authorized to view."

---

## Module 9 — Admin / Configuration

Module: Admin / Configuration  
Goal: Admin-only/manager-only system operations and configuration management.  
Owned tables: admin_audit_logs, task_companies, task_process_options, task_team_options, settings (optional)  
Endpoints:
- /admin/* user management + role updates + deactivation
- /admin/configuration/* CRUD endpoints for managed options
Policies/Rules:
- Strict route-level role boundaries (admin/manager).
- Role assignment and user control must be authorized server-side.
- Admin actions should be audited in admin-owned logs.
Events to emit:
- AdminActionLogged (optional)
Acceptance criteria:
- Unauthorized roles cannot access admin routes.
- Configuration writes create admin audit log entries.
- No writes from Admin module to Workflow activity logs.
Tests required:
- Feature: non-admin blocked from admin routes.
- Feature: authorized role can update user role.
- Feature: configuration action writes admin audit log.

AI build prompt:
"Build admin dashboard scaffolding. Implement user role management with authorization tests."

---

## Module 10 — Shared / Core

Module: Shared / Core  
Goal: Provide common enums, filters, helpers, and cross-cutting primitives only.  
Owned tables: none  
Endpoints: none  
Policies/Rules:
- Shared must remain small and domain-agnostic.
- No domain business logic should be moved into Shared.
- Use explicit contracts for cross-module interfaces.
Events to emit:
- Shared event contracts only (if required).
Acceptance criteria:
- Shared code is reusable and dependency-light.
- Domain logic remains inside owning modules.
- Integration points are explicit and testable.
Tests required:
- Integration smoke test covering module bootstrapping.
- Regression test for shared enum/filter usage.
- Boundary test ensuring no shared layer domain coupling.

AI build prompt:
"Implement shared constants/enums and reusable query filters. Keep Shared minimal and domain-agnostic."

---

## Delivery Checklist (Per Module Task)

1. Authorization enforced server-side (middleware/policy/gate).
2. Validation added via FormRequest.
3. Pagination present on list endpoints.
4. Eager loading used to prevent N+1 where applicable.
5. Domain events emitted/consumed according to boundaries.
6. At least 3 feature tests added/updated and passing.
7. No cross-module write outside module ownership.
