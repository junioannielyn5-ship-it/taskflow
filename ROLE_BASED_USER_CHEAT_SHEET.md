# Role-Based User Cheat Sheet

## Member (Employee) – Daily User Flow

### Main Goal
Complete assigned tasks on time and keep task status updated.

### Step-by-Step
1. Login via `/login/roles` and choose your role login page.
2. Open **Dashboard** to check:
   - My Tasks
   - Pending Review
   - Overdue
3. Go to **My Tasks** for your task list.
4. Use **Kanban** to update task stage (`todo`, `in_progress`, `for_review`, `done`).
5. Use **Calendar** to see upcoming deadlines.
6. Open notifications (bell icon) to review deadline alerts and updates.
7. Open `/email` to view deadline-level summaries (Warning, Critical, Reminder, Overdue).

### Member Best Practices
- Update status immediately after progress.
- Check Overdue and Critical items first.
- Review notifications at start and end of day.

---

## Project Manager – Monitoring + Coordination Flow

### Main Goal
Ensure team delivery, reduce overdue tasks, and keep communication active.

### Step-by-Step
1. Login and open **Dashboard**.
2. Review key indicators:
   - Active Projects
   - Pending Review
   - Overdue
3. Check **Reports** and trend charts for risk signals.
4. Use **Kanban** and **Calendar** during standups for team alignment.
5. Open `/email` to monitor deadline alert levels and recipients.
6. Go to configuration page to manage:
   - Personal Alert Email
   - Deadline Alert BCC
   - Daily report recipients
7. Review dashboard notifications to act on urgent updates quickly.

### Project Manager Best Practices
- Prioritize `critical` and `overdue` tasks daily.
- Validate recipient settings weekly.
- Use BCC for audit/archive trail.

---

## Admin – Governance + Configuration Flow

### Main Goal
Maintain system configuration, access control, and operational reliability.

### Step-by-Step
1. Login as Admin and open configuration modules.
2. Manage core settings:
   - System announcement
   - Daily report recipients
   - Personal alert email
   - Deadline alert BCC
3. Validate role-based access and user permissions.
4. Trigger/test notifications when needed:
   - `/email` page checks
   - test email routes (local)
   - scheduled command validation
5. Monitor logs and notification records for traceability.

### Admin Best Practices
- Confirm scheduler is active (daily runs).
- Keep sender credentials valid and updated.
- Review notification records for compliance and troubleshooting.

---

## Alert Levels (Applies to All Roles)

- **Warning**: task due in 7 days
- **Critical**: task due in 3 days
- **Reminder**: task due today
- **Overdue**: task is past due date

Alerts are available in:
- Email notifications
- Dashboard notification feed (bell icon)
- `/email` overview page

---

## Quick Links

- Dashboard: `/dashboard`
- Task list: `/tasks`
- Kanban: `/tasks/kanban`
- Calendar: `/tasks/calendar`
- Email alert overview: `/email`
- Role login launcher: `/login/roles`

---

## 60-Second New User Onboarding Script

“Login using your role. Start in Dashboard to see priorities, then open My Tasks. Update task status in Kanban as you progress. Monitor due dates in Calendar. Check bell notifications and the Email Overview page for deadline alerts. Focus first on Critical and Overdue tasks to stay on track.”
