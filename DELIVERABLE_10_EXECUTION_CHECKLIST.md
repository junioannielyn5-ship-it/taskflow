# Deliverable 10 — Execution Checklist (UAT / Go-Live)

Date: 2026-03-02  
Based on: DELIVERABLE_10_GO_LIVE_TEST_PLAN.md

## Instructions

- Mark one status per row: PASS / FAIL / BLOCKED
- Add Tester Initials and Execution Date
- Attach evidence link for FAIL/BLOCKED cases
- Re-test failed items after fixes and record result in Re-test columns

## A. Functional Testing (Core Workflow)

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-01 | Task Creation | Create task without Title | Validation error; title required | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-02 | Project Isolation | Login as member of Project A | Cannot view tasks from Project B | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-03 | Review Gate | Member tries to move for_review task to done | Rejected/forbidden by role rule | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-04 | Activity Log | Change assignee or due date | Entry appears in Recent Activity + timeline | High | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |

## B. Role & Access Testing (Matrix Check)

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-05 | Admin Config Access | Login as Admin and open Configuration | Configuration menu/pages visible and editable | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-06 | Member Restriction | Login as Member and open dashboard | Create Project not available to member | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-07 | Unauthorized URL | Member opens /admin or /configuration | 403 or safe redirect to allowed page | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |

## C. Data & Reporting Accuracy

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-08 | Overdue Sync | Create task due yesterday and not done | Appears in overdue widget/report count | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-09 | Export CSV | Click Export CSV in Reports | File downloads with correct columns/rows | High | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-10 | Report Scope | Member calls report endpoints | Only authorized scope returned | Critical | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |

## D. Edge Cases

| TC ID | Feature | Action | Expected Result | Priority | PASS | FAIL | BLOCKED | Tester | Date | Evidence/Notes | Re-test PASS | Re-test FAIL | Re-test Date |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| TC-11 | Multiple Assignees | Assign 3 users to one task | All assignees saved and displayed correctly | Medium | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-12 | Date Validation | Set target deadline earlier than date started | Validation error/warning shown | High | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |
| TC-13 | Empty State | Open dashboard with zero tasks | Proper empty-state message shown | Medium | ☐ | ☐ | ☐ |  |  |  | ☐ | ☐ |  |

## Defect Summary

| Severity | Count | IDs |
|---|---:|---|
| Critical | 0 |  |
| High | 0 |  |
| Medium | 0 |  |
| Low | 0 |  |

## Final UAT Decision

- QA Lead: ____________________ Date: __________
- Product Owner: ______________ Date: __________
- Engineering Lead: ____________ Date: __________
- Decision: ☐ GO  ☐ NO-GO  ☐ CONDITIONAL GO
- Notes: 
