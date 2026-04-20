# TaskFlow Technical Design Document

## Documentation Map
- Root navigation: [README.md](README.md)
- Standard access sequence: [ACCESS_CONTROL_MATRIX.md](ACCESS_CONTROL_MATRIX.md)
- AI module prompts: [AI_PROMPT_PACK_MODULE_TASK_CARDS.md](AI_PROMPT_PACK_MODULE_TASK_CARDS.md)
- Current compliance status: [MVP_COVERAGE_MATRIX_2026-03-02.md](MVP_COVERAGE_MATRIX_2026-03-02.md)

## 1. Modular, Event-Driven Architecture
- **Modules:** Tasks, Workflow, Notifications, Reporting, Admin, Shared
- **Principle:** Each module owns its data/tables and exposes functionality via events and service interfaces. No direct cross-module DB writes.
- **Communication:** Laravel Events/Listeners

## 2. State Machine & Workflow
- **State Machine:**
  - todo → in_progress → blocked ↔ in_progress → for_review → done
  - Only Leads/PMs can move from for_review to done
  - Blocked status requires a reason
- **TransitionService:**
  - Validates allowed transitions
  - Logs all transitions to `task_activity_logs` (actor_id, action_type, old_value, new_value, created_at)
  - All status changes and logs are wrapped in a DB transaction

## 3. Role-Permission Matrix
| Feature | Member | Team Lead | Project Manager | Admin |
|---|---|---|---|---|
| Create Project | ❌ | ✅ | ✅ | ✅ |
| Delete Project | ❌ | ❌ | ❌ | ✅ |
| Create Task | ✅ | ✅ | ✅ | ✅ |
| Edit Any Task | ❌ | ✅ | ✅ | ✅ |
| Move to Done | ❌ | ✅ | ✅ | ✅ |
| Manage Users | ❌ | ❌ | ❌ | ✅ |
| View Reports | Own | Team | Project | Global |

- **Enforcement:**
  - Policies and middleware check roles before all sensitive actions

## 4. Data Ownership & ERD
- **task_activity_logs**
  - id, task_id, actor_id, action_type, old_value, new_value, metadata (JSON), created_at
- **Ownership:** Only the Workflow module writes to `task_activity_logs`
- **Other modules**: Tasks, Projects, Comments, Notifications, Reporting each own their tables

## 5. Event-Driven Flow Example
1. PATCH /tasks/{id}/status (Tasks Module)
2. Workflow Module: Validates, updates, logs transition
3. System: Dispatches TaskStatusChanged event
4. Notification Module: Listens, notifies Lead/PM
5. Reporting Module: Listens, updates metrics

## 6. Quality Gate Checklist
- [x] No direct DB cross-writes
- [x] Policy coverage for all sensitive actions
- [x] Eloquent eager loading for list views
- [x] Atomic transitions (status + log in transaction)

## 7. Edge Case Handling
- Orphan Task: Reassign or flag if user removed from project
- Deadlock: Handle Blocked By references on delete
- Timezone: All dates/times stored in UTC, converted on display
- Concurrent Edits: Use optimistic locking or last-write-wins

## 8. AI Build Prompt Example (Workflow)
"Create a Laravel service for Task Workflows. Use a State Machine pattern to validate transitions between todo, in_progress, blocked, for_review, and done. Ensure only users with the 'Lead' project-role can transition to 'done'. Every successful transition must create an entry in the task_activity_logs table including the actor, old state, and new state."

---

This document is the foundation for robust, scalable, and maintainable development. All modules, policies, and event flows should adhere to these principles.
