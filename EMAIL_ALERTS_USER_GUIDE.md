# Email Alerts User Guide

## 1) Where to open the Email page

Use any of these URLs (all redirect to the same page):

- `/email`
- `/gmail`
- `/email-box`
- `/emailbox`

Main page: **Email Alerts Overview**

---

## 2) What is shown on the page

### A. Mail Header Preview (From / To / CC / BCC)

This section shows who will be used by automatic deadline emails:

- **From**: sender name and email from mail configuration
- **To**: current logged-in user email + personal alert email (if configured)
- **CC**: manager/admin recipients used by deadline alerts
- **BCC**: optional archive/audit email for all deadline alerts

All email values are clickable (`mailto:` links).

### B. Example Email Alerts (Preview)

Sample message style for each deadline level:

- **Warning**
- **Critical**
- **Reminder**
- **Overdue**

### C. Deadline Level Cards

You will see four cards with counts:

- **Warning** = tasks due in 7 days
- **Critical** = tasks due in 3 days
- **Reminder** = tasks due today
- **Overdue** = tasks already past due

Each card is clickable and jumps to its section.

### D. Task Lists per Level

Each section shows tasks for that level. Click a task row/title to open full task details.

---

## 3) Buttons on top

- **Send Test Email**: sends a test email to the selected/current recipient
- **Back to Dashboard**: returns to dashboard

---

## 4) How automatic email sending works

### Manual trigger

Run this command:

`php artisan tasks:send-deadline-alerts`

### Scheduled trigger

This command is scheduled daily at **08:00**.

Defined in:

- `routes/console.php`

---

## 5) Where recipients come from

Recipients are resolved from:

- Mail sender config (`MAIL_FROM_NAME`, `MAIL_FROM_ADDRESS`)
- Personal alert setting (`personal_alert_email` / `PERSONAL_ALERT_EMAIL`)
- Optional BCC setting (`deadline_alert_bcc` / `DEADLINE_ALERT_BCC`)
- Manager/Admin role recipients (for CC)

Admin configuration page includes fields for personal alert email and deadline BCC.

---

## 6) Troubleshooting quick checks

1. If URL is not found, use `/email` directly.
2. If email does not send, verify `.env` mail settings (SMTP host, port, username, password, from address).
3. If schedule is not running, ensure Laravel scheduler is active.
4. Use manual command to validate behavior immediately:

`php artisan tasks:send-deadline-alerts`

---

## 7) Technical references

- Email overview page: `resources/views/emails/deadline-levels.blade.php`
- Email route + preview data: `routes/web.php`
- Deadline auto-email notification: `app/Modules/Notifications/Notifications/TaskDeadlineAlertNotification.php`
- Scheduler + command registration: `routes/console.php`
