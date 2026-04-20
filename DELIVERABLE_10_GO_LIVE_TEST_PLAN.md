# Deliverable 10 — Go-Live Test Plan (TaskFlow)

Date: 2026-03-02  
Objective: Validate all critical Business Rules and Functional Requirements before production release.

Execution sheet: [DELIVERABLE_10_EXECUTION_CHECKLIST.md](DELIVERABLE_10_EXECUTION_CHECKLIST.md)
Sample filled reference: [DELIVERABLE_10_EXECUTION_CHECKLIST_SAMPLE.md](DELIVERABLE_10_EXECUTION_CHECKLIST_SAMPLE.md)

## 1) Test Scope

In scope:
- Core workflow behavior (task/project/workflow/activity)
- Role and access enforcement (least privilege)
- Reporting and export data accuracy
- Critical UX edge cases

Out of scope (for this round):
- Performance/load testing at scale
- DR/backup failover drills
- Third-party outage simulation

## 2) Entry and Exit Criteria

Entry criteria:
- Latest build deployed to staging/UAT
- Seed data available for projects, users, and tasks
- Roles available: Member, Team Lead, Project Manager, Admin
- Scheduler and notifications enabled in UAT

Exit criteria (GO-LIVE READY):
- 100% pass on Critical and High tests
- No open Critical defects
- High defects either fixed or accepted with signed workaround
- Product owner + QA sign-off completed

## 3) Role & Permission Baseline

Follow the canonical matrix and order from:
- ACCESS_CONTROL_MATRIX.md

Role order:
1. Member
2. Team Lead
3. Project Manager
4. Admin

## 4) Functional Testing (Core Workflow)

| Test Case ID | Feature | Action | Expected Result | Priority |
|---|---|---|---|---|
| TC-01 | Task Creation | Create a task without a Title | Validation error; title is required | Critical |
| TC-02 | Project Isolation | Log in as a Member of Project A | Tasks from Project B are not visible | Critical |
| TC-03 | Review Gate | As a Member, move a task to Done | Rejected/Forbidden when completion is restricted to Lead/PM/Admin | Critical |
| TC-04 | Activity Log | Change Assignee or Due Date | A new record appears in Recent Activity and task timeline | High |

## 5) Role & Access Testing (Matrix Check)

| Test Case ID | Feature | Action | Expected Result | Priority |
|---|---|---|---|---|
| TC-05 | Admin Configuration | Login as Admin; open Configuration menu | Configuration pages are visible and editable | Critical |
| TC-06 | Member Restrictions | Login as Member; check dashboard controls | Create Project control not visible/blocked for members | Critical |
| TC-07 | Unauthorized URL Access | Member manually opens /admin or /configuration | Access denied (403) or redirected safely to allowed page | Critical |

## 6) Data & Reporting Accuracy

| Test Case ID | Feature | Action | Expected Result | Priority |
|---|---|---|---|---|
| TC-08 | Overdue Sync | Create a task due yesterday and not done | Included in overdue count/widget and report results | Critical |
| TC-09 | Report Export CSV | Click Export CSV from Reports | Downloaded file exists with correct columns and filtered rows | High |
| TC-10 | Report Access Scope | Member opens report endpoints | Only authorized data scope returned (no data leak) | Critical |

Suggested CSV column checks:
- Task ID / Task No
- Title
- Priority
- Assignee(s)
- Project
- Due Date
- Status

## 7) Edge Case Testing

| Test Case ID | Feature | Action | Expected Result | Priority |
|---|---|---|---|---|
| TC-11 | Multiple Assignees | Assign 3 users on one task | All assignees saved and rendered correctly (avatars/list) | Medium |
| TC-12 | Date Validation | Set Target Deadline earlier than Date Started | Validation error or explicit warning; invalid date relationship blocked | High |
| TC-13 | Empty State UX | Open dashboard with zero tasks | Proper empty state message (no blank UI) | Medium |

## 8) Test Data Setup Checklist

- At least 2 projects (Project A, Project B)
- At least 1 overdue task (due_date < today, status != done)
- At least 1 task in for_review status
- At least 1 task with multiple assignees
- Users:
  - 1 Member
  - 1 Team Lead
  - 1 Project Manager
  - 1 Admin

## 9) Execution Workflow

1. Run Critical tests first (TC-01/02/03/05/06/07/08/10)
2. Execute High tests next (TC-04/09/12)
3. Execute Medium tests (TC-11/13)
4. Log defects with severity and evidence
5. Re-test fixed defects
6. Final regression sweep

## 10) Defect Logging Template

- Defect ID
- Linked Test Case ID
- Environment
- Role/User used
- Steps to Reproduce
- Expected Result
- Actual Result
- Severity: Critical / High / Medium / Low
- Evidence (screenshot/video/log)
- Owner
- Status

## 11) Sign-off Sheet

- QA Lead: ____________________ Date: __________
- Product Owner: ______________ Date: __________
- Engineering Lead: ____________ Date: __________
- Final Decision: GO / NO-GO

## 12) Traceability to Requirements

- FR-02 (Role-based access): TC-05, TC-06, TC-07, TC-10
- FR-21 (Admin/User management boundaries): TC-05, TC-07
- Core workflow requirements: TC-01, TC-02, TC-03, TC-04
- Reporting and data integrity: TC-08, TC-09, TC-10
