# Movaflex Task Manager
## System User Guide (Formal Step-by-Step Edition)

Document Date: March 10, 2026
Document Type: End-User and Operations Guide
Document Owner: Operations and PMO
Prepared By: Task Management Implementation Team
Reviewed By: Project Manager
Approved By: Operations Manager
Document Version: 1.0
Document Status: Approved for Internal Use

## Document Control
### Revision History
| Version | Date | Description | Author |
|---|---|---|---|
| 1.0 | March 10, 2026 | Initial formalized step-by-step user guide | Task Management Implementation Team |

### Distribution List
- Admin Team
- Project Managers
- Department Leads
- Team Members (Read-Only)

## 1. Purpose
This document provides a complete, formal, and step-by-step guide for using the Movaflex Task Manager system across all major modules and user roles.

## 2. Scope
This guide covers the following functional areas:
- Authentication and navigation
- Project setup and governance
- Task lifecycle execution
- Kanban and Calendar operations
- Dashboard monitoring
- Notifications and Email Alerts
- Reports and exports
- Chatbot assistant usage (English and Filipino)

## 3. System Modules
The platform includes these core modules:
- Dashboard
- Projects
- Tasks
- Kanban
- Calendar
- Notifications
- Email Alerts
- Reports
- Role pages (Admin, Manager, Project Manager, Executive, Lead)
- Chatbot Assistant (database-connected, bilingual)

## 4. Standard Workflow (Official Process)
The official end-to-end flow is as follows:

1. Admin or Manager creates a project.
2. Project Manager or Lead creates tasks under the project.
3. Assignees execute assigned tasks.
4. Assignees update task status through the workflow.
5. Lead or Manager validates tasks in `For Review`.
6. Approved tasks are marked `Done`.
7. Dashboard, Notifications, Reports, and Email Alerts update accordingly.

## 5. Login and Navigation Procedure
1. Open the system URL and sign in using your account credentials.
2. After successful login, proceed to `Dashboard`.
3. Use the top navigation for direct module access:
   Dashboard, Project, Task, Kanban, Calendar, Notification, Email Alert.
4. Use the sidebar for role-specific pages and actions.

## 6. Project Setup Procedure
Applicable Roles: Admin, Manager, Project Manager

1. Open `Project`.
2. Click `Create Project`.
3. Complete project details:
   Project Name, Description, Status, and additional fields if available.
4. Save the project.
5. Confirm the project appears in the project list.
6. Assign relevant members to the project.

Expected Result:
- Project is active and available for task planning and execution.

## 7. Task Creation Procedure
1. Open `Task`.
2. Click `Create Task`.
3. Complete required task details:
   Title, Project, Assignee(s), Priority, Due Date.
4. Set initial task status to `Not Started` (`todo`).
5. Save the task.

Expected Result:
- Task is visible in Task List and Kanban board.

## 8. Task Status Procedure
Official status progression:
- `Not Started` (`todo`)
- `On Going` (`in_progress`)
- `For Review` (`for_review`)
- `Done` (`done`)

Execution steps:
1. Assignee starts work and updates status to `On Going`.
2. Assignee completes output and updates status to `For Review`.
3. Lead or Manager reviews output.
4. If approved, update status to `Done`.
5. If revision is required, return status to `On Going`.

Overdue Rule:
- A task is `Overdue` when due date has passed and status is not `Done`.

## 9. Kanban and Calendar Procedure
### Kanban
1. Open `Kanban`.
2. Review tasks by status column.
3. Update or move tasks based on current progress.
4. Prioritize `For Review` and `Overdue` columns.

### Calendar
1. Open `Calendar`.
2. Review deadlines by date.
3. Identify date conflicts and heavy workload clusters.
4. Re-plan assignments as needed.

## 10. Dashboard Monitoring Procedure
Perform this daily:

1. Review KPI cards:
   Active Projects, My Tasks, Pending Review, Overdue.
2. Review charts:
   Task Status Overview, Tasks Over Time.
3. Review operational sections:
   Project Progress, Urgent Tasks, Recent Activity, Latest Notifications.

## 11. Notification Handling Procedure
1. Open `Notification` page.
2. Review new alerts such as assignments, updates, and workflow changes.
3. Mark alerts as read individually or in bulk.

Recommended Practice:
- Review notifications at start-of-day and before logout.

## 12. Email Alerts Procedure
1. Open `Email Alert`.
2. Review alert levels:
   Warning, Critical, Reminder, Overdue.
3. Review Mail Header Preview:
   From, To, CC, BCC.
4. If testing in local environment, use available test-mail actions.

Operational Note:
- BCC supports database-backed fallback recipients when manual BCC is not configured.

## 13. Reports Procedure
1. Open `Reports`.
2. Analyze overdue, completion, and trend metrics.
3. Export results in CSV or PDF as needed.
4. Use reports for weekly and monthly management reviews.

## 14. Role Responsibilities
### Admin
- Manage user access and role assignments.
- Maintain core configuration settings.
- Ensure policy compliance and visibility controls.

### Manager
- Monitor team workload and overdue items.
- Approve tasks from `For Review` to `Done`.
- Use reports for performance and delivery control.

### Project Manager
- Coordinate project execution and milestones.
- Ensure task assignment coverage and progress tracking.

### Lead
- Validate deliverables in `For Review`.
- Return tasks for correction when quality criteria are not met.

### Member / Employee
- Execute assigned tasks.
- Update status accurately and on time.

## 15. Chatbot Assistant Procedure
The chatbot is integrated for user support and process guidance.

Capabilities:
- Provides module guidance and step-by-step help.
- Supports English and Filipino.
- Retrieves response content from database knowledge records.

Usage steps:
1. Open chatbot widget.
2. Select preferred language (EN or FIL).
3. Enter question or choose quick prompt.
4. Open suggested links from chatbot response.

## 16. Operating Cadence
### Daily
1. Review Dashboard KPIs.
2. Address Overdue and Pending Review items.
3. Process Notifications.
4. Update task statuses before end-of-day.

### Weekly
1. Review Reports.
2. Export and share summary.
3. Rebalance schedules via Kanban and Calendar.

### Monthly
1. Validate access and role compliance.
2. Review reporting and alert quality.
3. Confirm process adherence and improvement actions.

## 17. Troubleshooting Guide
### Task Not Visible
1. Verify current filters.
2. Verify selected tab (Active vs Done).
3. Verify project and task status fields.

### Email Not Received
1. Verify recipient configuration in Email Alert settings.
2. Verify Mail Header Preview values.
3. Verify queue/scheduler services are running.

### Dashboard Metrics Mismatch
1. Verify task status updates are accurate.
2. Verify due dates and overdue conditions.
3. Refresh page and re-check filters.

### Access Denied
1. Verify user role assignment.
2. Verify route access policy for role.
3. Verify account active status.

## 18. Status Reference
- Not Started: Task exists; execution not yet started.
- On Going: Task execution currently in progress.
- For Review: Task is pending validation/approval.
- Done: Task is completed and approved.
- Overdue: Due date has passed while task is not done.

## 19. Governance and Best Practices
1. Maintain timely and accurate status updates.
2. Prioritize `For Review` and `Overdue` queues daily.
3. Use dashboard and reports for evidence-based decisions.
4. Maintain clean role assignments and email recipient settings.
5. Use chatbot for fast process clarification and onboarding support.
