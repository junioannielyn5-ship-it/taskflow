# 📋 TaskFlow UAT Test Script (MVP + Phase 2)

## Document Control
- Version: 1.0
- Date: February 26, 2026
- Product: TaskFlow
- Scope: MVP + Phase 2 Automation

## Reference Documents
- [README.md](README.md)
- [ACCESS_CONTROL_MATRIX.md](ACCESS_CONTROL_MATRIX.md)
- [AI_PROMPT_PACK_MODULE_TASK_CARDS.md](AI_PROMPT_PACK_MODULE_TASK_CARDS.md)
- [MVP_COVERAGE_MATRIX_2026-03-02.md](MVP_COVERAGE_MATRIX_2026-03-02.md)

## Test Preconditions
1. Tester has at least two active user accounts:
   - `Member`
   - `Manager` (or Admin/Lead depending on environment role policy)
2. At least one project with tasks exists.
3. `Sample Task 1` (or equivalent) can be set to overdue by 3+ days.
4. Notifications and automation scheduler are enabled.

## Execution Notes
- Mark each test as: `PASS`, `FAIL`, or `BLOCKED`.
- Capture screenshot/video evidence for each failed case.
- Record actual result exactly as seen in UI/API.

---

## UAT Test Cases

| Test Case ID | Feature / Module | Test Step (Action) | Expected Result (Success Criteria) | Status |
|---|---|---|---|---|
| TC-01 | IAM & Access | Log in using a `Member` account. | The `Reports` and `Create Project` button must not be visible. | ☐ |
| TC-02 | Project Isolation | Try opening a Project URL where the user is not a member. | The system must return `403 Forbidden` or `Access Denied`. | ☐ |
| TC-03 | Task Creation | Create a task in a Project. | It should appear immediately in `Urgent Tasks` and on the Dashboard (if urgent/near due criteria are met). | ☐ |
| TC-04 | Review Gate | As a Member, move a task status from `for_review` to `done`. | The system must block the action; only authorized reviewer roles can move tasks to `done` (based on configured gate policy). | ☐ |
| TC-05 | Activity Log | Change a task priority from `Medium` to `Urgent`. | The change must appear in `Recent Activity` and Task Timeline with actor name and field change details. | ☐ |
| TC-06 | Notifications | Assign a task to another user. | The user must receive an alert in the `Latest Notifications` card and unread badge should update. | ☐ |
| TC-07 | Automation | Set a task overdue by `3+ days` (for example, `Sample Task 1`), then run automation trigger/schedule. | The task should be reassigned to Manager and log a `System`/`TaskFlow Automations` action in the timeline, with escalation notification. | ☐ |

---

## Defect Logging Template

For any failed test, log:
- Test Case ID:
- Environment:
- User Role:
- Steps to Reproduce:
- Expected Result:
- Actual Result:
- Evidence Link/Screenshot:
- Severity: `Low` / `Medium` / `High` / `Critical`

---

## UAT Sign-off
- Tester Name:
- Date Executed:
- Overall Result: `PASS` / `FAIL` / `CONDITIONAL PASS`
- Remarks:
