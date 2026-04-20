# TaskFlow Admin, Employee, and Deployment Guide

_Last updated: March 4, 2026_

## A. Admin Guide

### 1) User Management & Roles
As an Admin, you control user access and permissions.

- **Role Assignment:** Ensure every user has the correct role (`Member`, `Team Lead`, `PM`, `Admin`) in **Configuration** to enforce the **Least Privilege** principle.
- **Access Levels:** Only Managers should have access to the **Create Project** button on the Dashboard.
- **Account Types:** Verify the correct `Account Type` (for example, `MANAGER`) in each user profile so the correct reports and tools are available.

### 2) Project & Team Setup
A well-structured project setup is the foundation of accurate reporting.

- **Creating Projects:** Use the **Create Project** button on the Dashboard to start a new workspace.
- **Membership Control:** Add only required members; non-members must not be able to view tasks inside the project.
- **Progress Tracking:** Monitor the **Project Progress** bar to identify teams that need support.

### 3) Task Lifecycle & Workflow Rules
Maintain a clear audit trail by following these business rules.

- **Mandatory Fields:** Every task must have `Title`, `Assignee`, and `Priority` (`Low`, `Medium`, `High`, `Urgent`).
- **Status Updates:** Remind members to update task status (`To-Do` → `In-Progress` → `For-Review`) since these updates feed analytics such as **Tasks Over Time**.
- **Review Gate:** Only Team Leads or Managers should move a task from `For-Review` to `Done`.

### 4) Monitoring & Reporting
Use the Reports module for data-driven decisions.

- **Overdue Management:** Check **Overdue by Assignee** daily to identify users with the highest number of delayed tasks.
- **Exporting Data:** Use **Export CSV** or **Export PDF** for weekly summaries and performance reviews.
- **Calendar Oversight:** Use the **Task Calendar** to monitor target deadlines and avoid overlapping heavy deliverables.

### 5) Maintenance & Support
For system stability and accountability.

- **Activity Logs:** Use the **Recent Activity** feed when there is a dispute in task updates (timestamp and actor visibility).
- **Notification Check:** Ensure in-app notifications are working for new assignments and status changes.

---

## B. Quick Start Guide for Employees

### 1) First Step: Dashboard Overview
After login, this is your personal command center:

- **My Tasks Widget:** Shows the total number of tasks assigned to you.
- **Overdue Warning:** Displays tasks that have passed their deadline.
- **Recent Activity:** Shows the latest updates in your projects so you stay aligned.

### 2) Finding and Updating Tasks
Go to **My Tasks** or **Kanban** from the sidebar.

- **Filters:** Filter tasks by priority (`Urgent`, `High`, etc.).
- **Status Change:** When you start a task, move it from `To-Do` to `In-Progress`.
- **For Review:** When finished, move it to `For-Review` for validation by your Team Lead or Manager.

### 3) Collaboration

- **Notifications:** Click the bell icon to view new assignments and comments.
- **Task Details:** Click a Task ID (for example, `#1`) to view full details, comments, and attachments.
- **Calendar View:** Use the Calendar tab for monthly workload planning.

### 4) Important Reminders (Golden Rules)

- **Ownership:** You are responsible for every task assigned to your name.
- **Deadlines:** Always monitor target deadlines; delayed tasks are visible on the Manager dashboard.
- **Audit Trail:** Every status or priority change is recorded in system history.

---

## C. Deployment Checklist for the IT Team

### 1) Pre-Deployment Checklist (Technical & Security)
Before opening access to the whole organization, verify these non-functional requirements:

- **Database Integrity:** Ensure proper indexing for `users`, `roles`, `projects`, `tasks`, and `activity_logs`.
- **RBAC Validation:** Confirm Least Privilege is enforced; members must not access admin configuration settings.
- **Audit Log Validation:** Confirm each status or priority update creates a record in `task_activity_logs`.
- **Secure Storage:** Ensure `task_attachments` are stored on a private disk and only authorized members can download them.
- **Performance Testing:** Verify Kanban and Task List remain responsive with pagination and filters enabled.

### 2) Launch Day Checklist (Operational)
Critical checks on go-live day:

- **User Provisioning:** Ensure all users have valid company credentials to log in.
- **Data Migration:** Ensure pending tasks from spreadsheets are imported into the correct projects and assignees.
- **Notification Flow:** Verify in-app notifications appear in near real time for new assignments.
- **Reporting Accuracy:** Confirm overdue reports match current system date/time (March 4, 2026).

### 3) Post-Deployment & Maintenance
Routine operations for long-term reliability:

- **Daily Backups:** Keep scheduled database and file backups active.
- **Error Monitoring:** Monitor logs continuously for graceful failures and user-facing errors.
- **User Feedback Loop:** Maintain a clear channel for bug reports and Phase 2 requests (for example, automation rules).

---

## Recommended Operating Cadence

- **Daily (Admin/PM):** Overdue review, activity feed review, notification health check
- **Weekly (PM/Manager):** Export reports, team progress review, workload balancing via calendar
- **Monthly (IT/Admin):** Access audit, storage audit, backup restore drill, performance spot-check
