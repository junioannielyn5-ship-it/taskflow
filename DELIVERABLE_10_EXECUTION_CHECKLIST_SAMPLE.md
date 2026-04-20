# Deliverable 10 — Execution Checklist (Sample Filled)

Date: 2026-03-02  
Purpose: Reference sample only. Do not use as official sign-off record.

## A. Functional Testing (Core Workflow)

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-01 | Task Creation | Create task without Title | Validation error; title required | Critical | ✅ | ☐ | ☐ | QA-JD | 2026-03-02 | Validation message displayed for title | ☐ | ☐ |  |
| TC-02 | Project Isolation | Login as member of Project A | Cannot view tasks from Project B | Critical | ✅ | ☐ | ☐ | QA-JD | 2026-03-02 | 403 on Project B task URL | ☐ | ☐ |  |
| TC-03 | Review Gate | Member tries to move for_review task to done | Rejected/forbidden by role rule | Critical | ✅ | ☐ | ☐ | QA-JD | 2026-03-02 | Status update blocked with forbidden response | ☐ | ☐ |  |
| TC-04 | Activity Log | Change assignee or due date | Entry appears in Recent Activity + timeline | High | ✅ | ☐ | ☐ | QA-JD | 2026-03-02 | Timeline includes assignee_change and due_date_change | ☐ | ☐ |  |

## B. Role & Access Testing (Matrix Check)

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-05 | Admin Config Access | Login as Admin and open Configuration | Configuration menu/pages visible and editable | Critical | ✅ | ☐ | ☐ | QA-MR | 2026-03-02 | Admin config routes accessible | ☐ | ☐ |  |
| TC-06 | Member Restriction | Login as Member and open dashboard | Create Project not available to member | Critical | ✅ | ☐ | ☐ | QA-MR | 2026-03-02 | Create Project action hidden and blocked server-side | ☐ | ☐ |  |
| TC-07 | Unauthorized URL | Member opens /admin or /configuration | 403 or safe redirect to allowed page | Critical | ✅ | ☐ | ☐ | QA-MR | 2026-03-02 | 403 confirmed on restricted endpoints | ☐ | ☐ |  |

## C. Data & Reporting Accuracy

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-08 | Overdue Sync | Create task due yesterday and not done | Appears in overdue widget/report count | Critical | ✅ | ☐ | ☐ | QA-AL | 2026-03-02 | Overdue count incremented by 1 | ☐ | ☐ |  |
| TC-09 | Export CSV | Click Export CSV in Reports | File downloads with correct columns/rows | High | ☐ | ✅ | ☐ | QA-AL | 2026-03-02 | Missing Assignee column in one export variant | ✅ | ☐ | 2026-03-02 |
| TC-10 | Report Scope | Member calls report endpoints | Only authorized scope returned | Critical | ✅ | ☐ | ☐ | QA-AL | 2026-03-02 | Foreign project rows excluded | ☐ | ☐ |  |

## D. Edge Cases

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-11 | Multiple Assignees | Assign 3 users to one task | All assignees saved and displayed correctly | Medium | ✅ | ☐ | ☐ | QA-KT | 2026-03-02 | Avatars rendered for all assignees | ☐ | ☐ |  |
| TC-12 | Date Validation | Set target deadline earlier than date started | Validation error/warning shown | High | ✅ | ☐ | ☐ | QA-KT | 2026-03-02 | Form validation triggered | ☐ | ☐ |  |
| TC-13 | Empty State | Open dashboard with zero tasks | Proper empty-state message shown | Medium | ✅ | ☐ | ☐ | QA-KT | 2026-03-02 | Empty-state card rendered | ☐ | ☐ |  |

## Defect Summary (Sample)

| Severity | Count | IDs |
|---|---:|---|
| Critical | 0 |  |
| High | 0 | DEF-009 (closed after re-test) |
| Medium | 0 |  |
| Low | 0 |  |

## Final UAT Decision (Sample)

- QA Lead: J. Doe Date: 2026-03-02
- Product Owner: A. Reyes Date: 2026-03-02
- Engineering Lead: M. Cruz Date: 2026-03-02
- Decision: ✅ GO  ☐ NO-GO  ☐ CONDITIONAL GO
- Notes: All critical paths passed; one High defect resolved and re-tested successfully.
