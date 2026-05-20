<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow User Manual</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

        /* Cover */
        .cover { text-align: center; padding: 60px 40px 40px; border-bottom: 3px solid #0ea5e9; margin-bottom: 30px; }
        .cover .logo-text { font-size: 32px; font-weight: 900; letter-spacing: 4px; color: #1e293b; }
        .cover .logo-text span { color: #0ea5e9; }
        .cover .tagline { font-size: 11px; color: #64748b; letter-spacing: 3px; text-transform: uppercase; margin-top: 4px; }
        .cover h1 { font-size: 20px; font-weight: 900; color: #0f172a; margin-top: 28px; }
        .cover .meta { font-size: 10px; color: #94a3b8; margin-top: 8px; }

        /* Section heading */
        .section { margin-bottom: 22px; page-break-inside: avoid; }
        .sequence-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 14px; margin-bottom: 22px; }
        .sequence-box h2 { font-size: 12px; font-weight: 900; color: #0f172a; margin-bottom: 6px; }
        .sequence-box p { font-size: 10px; color: #475569; margin-bottom: 8px; }
        .sequence-box ol { margin-left: 18px; color: #1e293b; }
        .sequence-box li { font-size: 10px; line-height: 1.6; }
        .section-header { display: flex; align-items: center; background: #f1f5f9; border-left: 4px solid #0ea5e9; padding: 8px 12px; margin-bottom: 10px; border-radius: 0 6px 6px 0; }
        .section-header .icon { font-size: 16px; margin-right: 8px; }
        .section-header h2 { font-size: 13px; font-weight: 900; color: #0f172a; }
        .section-header .sub { font-size: 9px; color: #64748b; margin-top: 1px; }

        /* Items */
        table.items { width: 100%; border-collapse: collapse; }
        table.items tr { border-bottom: 1px solid #e2e8f0; }
        table.items tr:last-child { border-bottom: none; }
        table.items td.dot { width: 10px; padding: 6px 8px 6px 4px; vertical-align: top; }
        table.items td.dot span { display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: #0ea5e9; margin-top: 3px; }
        table.items td.label { width: 140px; padding: 6px 8px; font-weight: 700; color: #1e293b; font-size: 10px; vertical-align: top; }
        table.items td.desc { padding: 6px 4px; color: #475569; font-size: 10px; vertical-align: top; line-height: 1.5; }

        /* Footer */
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #e2e8f0; text-align: center; font-size: 9px; color: #94a3b8; }

        /* Page break helpers */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

{{-- Cover --}}
<div class="cover">
    <div class="logo-text">TASK<span>FLOW</span></div>
    <div class="tagline">Workspace</div>
    <h1>User Manual</h1>
    <div class="meta">Generated: {{ now()->format('F d, Y') }} &nbsp;|&nbsp; Movaflex Designs Unlimited Inc.</div>
</div>

<div class="sequence-box">
    <h2>Recommended Learning Sequence</h2>
    <p>Read the manual in this order to match the normal user workflow inside the system.</p>
    <ol>
        <li>Login Page</li>
        <li>Dashboard</li>
        <li>Projects</li>
        <li>My Tasks</li>
        <li>Kanban Board</li>
        <li>Calendar and Meetings</li>
        <li>Notifications and Task Status Guide</li>
        <li>Roles, Admin tools, and reference guides</li>
    </ol>
</div>

{{-- 1. Login Page --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🔐</span>
        <div><h2>Login Page</h2><div class="sub">Sign in to open the workspace</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Work Email', 'Enter your official company email address so your assigned role and menu access can be loaded correctly.'],
            ['Password', 'Use the password provided by the Admin or the password you already updated after your first sign-in.'],
            ['Sign In Button', 'Click Sign In to open the dashboard and continue to the rest of the modules in this manual.'],
            ['Invalid Login', 'If the email or password is incorrect, recheck the input first before asking Admin for a reset.'],
            ['Forgot Password or Access Issue', 'If you cannot log in, contact Admin or IT so they can verify your account and reset access if needed.'],
            ['Next Step', 'After login, proceed to the Dashboard first, then Projects, then My Tasks for the normal user flow.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 1. Dashboard --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🏠</span>
        <div><h2>Dashboard</h2><div class="sub">Your main overview screen</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Active Projects', 'Shows the number of projects you are currently a member of.'],
            ['My Tasks', 'Count of all tasks assigned to you that are not yet marked as Done.'],
            ['Pending Review', 'Tasks that have been submitted for review and are waiting for approval.'],
            ['Overdue', 'Tasks whose due date has already passed but are still not completed.'],
            ['Task Status Chart', 'A visual breakdown showing how many tasks are in each status: Todo, In Progress, For Review, and Done.'],
            ['Tasks Over Time', 'A line chart showing how many tasks were created each day over the last 7 days.'],
            ['Project Progress', 'Per-project completion percentage, split by Sales and Technical team tabs.'],
            ['Recent Activity', 'The latest actions done on tasks (status changes, comments, assignments).'],
            ['Upcoming Meetings', 'Meetings scheduled from today onwards.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 3. Projects --}}
<div class="section">
    <div class="section-header">
        <span class="icon">📁</span>
        <div><h2>Projects</h2><div class="sub">Create and manage company projects</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Create Project', 'Admins and Project Managers can create new projects with a name, description, and team members.'],
            ['Project Members', 'Users added as members of a project can see and be assigned tasks under that project.'],
            ['Project Progress', 'Shown as a percentage based on how many tasks in the project are marked Done.'],
            ['Sales vs Technical', 'Project progress is split into Sales team and Technical team tabs for easy tracking.'],
            ['Edit Project', 'Update the project name, description, or members at any time.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 4. My Tasks --}}
<div class="section">
    <div class="section-header">
        <span class="icon">✅</span>
        <div><h2>My Tasks</h2><div class="sub">Manage your assigned tasks</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Task List View', 'Displays all tasks assigned to you in a table format with filters for status, priority, and project.'],
            ['Create Task', 'Only admins, managers, and project managers can create new tasks and assign them to team members.'],
            ['Task Status', 'Each task has a status: Todo → In Progress → For Review → Done.'],
            ['Priority Levels', 'Tasks can be tagged as Low, Medium, High, or Critical priority.'],
            ['Due Date', 'The deadline for a task. Tasks past their due date are marked as Overdue.'],
            ['Assignees', 'One or more users who are responsible for completing the task.'],
            ['Task Detail Page', 'Click a task to view full details, add comments, upload attachments, start a timer, and manage checklists.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 5. Kanban --}}
<div class="section">
    <div class="section-header">
        <span class="icon">📋</span>
        <div><h2>Kanban Board</h2><div class="sub">Visual task management by columns</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Columns', 'Tasks are grouped into 4 columns: To Do, In Progress, For Review, and Done.'],
            ['Drag & Drop', 'Move a task card from one column to another to update its status instantly.'],
            ['Task Cards', 'Each card shows the task title, priority badge, assignee avatars, and due date.'],
            ['Quick View', 'Click a task card to open the full task details without leaving the Kanban page.'],
            ['Filters', 'Filter the board by project, assignee, or priority to focus on specific tasks.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 6. Calendar --}}
<div class="section">
    <div class="section-header">
        <span class="icon">📅</span>
        <div><h2>Calendar</h2><div class="sub">Monthly view of tasks and events</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Event Calendar', 'Shows all scheduled Meetings and company Holidays for the month.'],
            ['Tasks Calendar', 'Shows active tasks placed on their due date on a monthly grid.'],
            ['All Movaflex', 'Shows tasks from all teams combined (Sales + Technical).'],
            ['Sales filter', 'Shows only tasks assigned to Sales team members.'],
            ['Technical filter', 'Shows only tasks assigned to Technical team members.'],
            ['Highlighted dates', 'Dates with tasks or events have a teal glow around the day number.'],
            ['Today indicator', "Today's date is highlighted with a blue circle."],
            ['Previous / Next', 'Navigate to previous or next months using the navigation buttons.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 6. Meetings --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🎥</span>
        <div><h2>Meetings</h2><div class="sub">Schedule and track team meetings</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Create Meeting', 'Add a new meeting with a title, date, start time, and optional description.'],
            ['Meeting List', 'View all past and upcoming meetings in chronological order.'],
            ['Calendar Integration', 'All meetings automatically appear on the Company Calendar under the Event Calendar section.'],
            ['Meeting Detail', 'Click a meeting to see its full details including attendees and notes.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 7. Notifications --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🔔</span>
        <div><h2>Notifications</h2><div class="sub">Stay updated with real-time alerts</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Bell Icon', 'The bell icon in the top navigation bar shows the number of unread notifications with a red badge.'],
            ['Task Assigned', 'You receive a notification whenever a task is assigned to you.'],
            ['Task Updated', 'Get notified when a task you are assigned to is updated or its status changes.'],
            ['Overdue Alert', 'Automatic notification when a task is past its due date.'],
            ['Mark as Read', 'Click a notification to mark it as read, or use "Mark All as Read" to clear all at once.'],
            ['Notification History', 'View all past notifications (read and unread) from the Notifications History page.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 8. Task Status Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🏷️</span>
        <div><h2>Task Status Guide</h2><div class="sub">What each task status means</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Todo', 'The task has been created but no one has started working on it yet.'],
            ['In Progress', 'Someone is actively working on this task.'],
            ['For Review', 'The task is completed and is waiting to be reviewed and approved by a manager or lead.'],
            ['Done', 'The task has been reviewed and fully completed. No more action needed.'],
            ['Overdue', "The task's due date has passed and it is still not marked as Done. Requires immediate attention."],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 9. User Roles --}}
<div class="section">
    <div class="section-header">
        <span class="icon">👥</span>
        <div><h2>User Roles</h2><div class="sub">Access levels in the system</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Executive', 'Reviews overall progress, team performance, and high-level reports for decision-making.'],
            ['Project Manager', 'Manages specific projects, creates tasks, assigns members, and tracks project progress.'],
            ['Admin', 'Full access to everything: create users, manage all projects and tasks, view all reports, and configure system settings.'],
            ['Sales', 'Handles client-facing work, sales-related tasks, and pre-implementation coordination.'],
            ['Technical', 'Manages technical delivery, implementation tasks, and system-related work.'],
            ['Pre Sale', 'Supports early-stage client requirements, scoping, and proposal preparation.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 10. Technical Role Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🛠️</span>
        <div><h2>Technical Role Guide</h2><div class="sub">Technical delivery and execution responsibilities</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Primary Purpose', 'Handle implementation work, fixes, testing, and task execution on the technical side of projects.'],
            ['Main Responsibilities', 'Review technical requirements, build or adjust solutions, resolve issues, and update task progress.'],
            ['Task Flow', 'Usually receives work from Sales or Pre Sale, completes the implementation, then submits the task for review.'],
            ['What Technical Can Do', 'Work on assigned technical tasks, comment on blockers, update statuses, and participate in delivery coordination.'],
            ['What Technical Should Escalate', 'Escalate scope changes, access issues, unresolved blockers, and cases that need Admin or PM approval.'],
            ['Daily Output Examples', 'Bug fixes, setup adjustments, technical checks, implementation updates, and test verification.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 11. Sales Role Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">📈</span>
        <div><h2>Sales Role Guide</h2><div class="sub">Client-facing and commercial execution responsibilities</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Primary Purpose', 'Handle client-facing coordination, requirement intake, and commercial communication.'],
            ['Main Responsibilities', 'Capture client requests, clarify scope, create or update sales-related tasks, and monitor commitments.'],
            ['Task Flow', 'Collect requirements -> validate details -> create or update task -> coordinate with Pre Sale or Technical -> monitor completion.'],
            ['What Sales Can Do', 'Update task statuses, add progress notes, follow up with stakeholders, and coordinate deadlines.'],
            ['What Sales Should Escalate', 'Escalate requirement conflicts, timeline risks, and approvals needing Admin or Project Manager decisions.'],
            ['Daily Output Examples', 'Client follow-ups, requirement updates, handoff notes, and status reporting.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 12. Pre Sale Role Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🧩</span>
        <div><h2>Pre Sale Role Guide</h2><div class="sub">Discovery, scoping, and pre-implementation responsibilities</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Primary Purpose', 'Bridge initial client needs to executable project scope before delivery starts.'],
            ['Main Responsibilities', 'Gather requirements, clarify assumptions, define scope boundaries, and prepare handoff context.'],
            ['Task Flow', 'Discover requirements -> validate business need -> document scope -> align with Sales -> handoff to Technical.'],
            ['What Pre Sale Can Do', 'Create scoping tasks, document requirements, tag dependencies, and coordinate pre-implementation readiness.'],
            ['What Pre Sale Should Escalate', 'Escalate unclear requirements, pricing or scope conflicts, and high-risk assumptions requiring PM or Admin decision.'],
            ['Daily Output Examples', 'Discovery notes, scope breakdown, requirement checklists, and handoff summaries.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 13. IT Role Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🖥️</span>
        <div><h2>IT Role Guide</h2><div class="sub">System support and internal operations responsibilities</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Primary Purpose', 'Maintain system health, support users, and manage internal technical operations that keep the platform running.'],
            ['Main Responsibilities', 'Handle access issues, verify system settings, monitor availability, and assist with troubleshooting.'],
            ['Task Flow', 'Receive issue -> diagnose problem -> apply fix or workaround -> verify resolution -> document outcome.'],
            ['What IT Can Do', 'Reset or verify access, assist with configuration, investigate technical incidents, and coordinate with Admin or Technical teams.'],
            ['What IT Should Escalate', 'Escalate code defects, environment failures, permission conflicts, and issues requiring higher-level technical intervention.'],
            ['Daily Output Examples', 'User support, access validation, system checks, incident review, and internal troubleshooting updates.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 14. Admin Role Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🛡️</span>
        <div><h2>Admin Role Guide</h2><div class="sub">Platform governance and user management responsibilities</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Primary Purpose', 'Control platform access, manage users, configure system settings, and oversee overall governance.'],
            ['Main Responsibilities', 'Create users, assign roles, review configuration, manage permissions, and support operational controls.'],
            ['Task Flow', 'Receive admin request -> validate access need -> apply changes -> verify effect -> document action in audit log.'],
            ['What Admin Can Do', 'Manage users, settings, email configurations, and broad project/task access depending on policy.'],
            ['What Admin Should Escalate', 'Escalate application bugs, infrastructure issues, and requests that need development or vendor intervention.'],
            ['Daily Output Examples', 'User provisioning, role updates, configuration review, and system governance checks.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 10. Email Structure --}}
<div class="section">
    <div class="section-header">
        <span class="icon">✉️</span>
        <div><h2>Email Structure</h2><div class="sub">Recommended email format for work updates</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Subject Format', 'Use this pattern: [Project/Team] Action - Task Name - Date. Example: [Website Revamp] Follow-up - Homepage QA - 2026-05-11.'],
            ['Greeting', 'Start with a short and respectful greeting, and mention the recipient or team clearly.'],
            ['Purpose (First 1-2 lines)', 'State the intent immediately: update, request for approval, follow-up, issue escalation, or meeting confirmation.'],
            ['Task/Issue Details', 'Include task title, owner, deadline, current status, blockers, and what has been completed so far.'],
            ['Action Required', 'Specify exactly what you need from the recipient, who should do it, and the expected completion time.'],
            ['Attachment/Reference', 'If files or links are included, mention them clearly so they can be reviewed quickly.'],
            ['Closing Line', 'End with a short thank-you and your name or role for accountability.'],
            ['Quick Template', 'Hi [Name/Team] | Purpose: [Update/Request] | Task: [Task Name] | Status: [Current Status] | Deadline: [Date/Time] | Action Needed: [Specific Action] | Reference: [Link/Attachment] | Thank you, [Your Name]'],
            ['Quality Checklist', 'Before sending, ensure the message is clear, complete, and professional with no missing deadline or owner.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 11. Create User --}}
<div class="section">
    <div class="section-header">
        <span class="icon">👤</span>
        <div><h2>Create User</h2><div class="sub">Account provisioning and role assignment</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Purpose', 'Create a new account for executive, project manager, admin, sales, technical, or pre sale users with the correct access level.'],
            ['Access', 'Only Admin users can create new user accounts.'],
            ['Required Fields', 'Complete full name, email address, role, and assigned team before saving.'],
            ['Email Standard', 'Use official work email format and double-check spelling to avoid login and notification issues.'],
            ['Role Assignment', 'Select the role carefully because it controls what menus, pages, and actions are available.'],
            ['Verification Step', 'After creating, confirm the user appears in the user list and can sign in successfully.'],
            ['Common Errors', 'Duplicate email, missing role, or invalid email format will prevent account creation.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 12. Audit Log Guide --}}
<div class="section">
    <div class="section-header">
        <span class="icon">🧾</span>
        <div><h2>Audit Log Guide</h2><div class="sub">Trace system activity and accountability</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Purpose', 'Audit logs record who did what action, in which module, and at what time.'],
            ['Access', 'Users with proper permission can review logs for compliance and investigation.'],
            ['Core Fields', 'Read actor, action type, target record, timestamp, and related module details.'],
            ['Filters', 'Narrow down results by date, user, or action to find exact events quickly.'],
            ['How to Investigate', 'Start from the reported issue time, then trace nearby actions to identify the root cause.'],
            ['Best Practice', 'Capture task ID or project ID first before searching so findings are more accurate.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 13. Admin Configuration --}}
<div class="section">
    <div class="section-header">
        <span class="icon">⚙️</span>
        <div><h2>Admin Configuration</h2><div class="sub">System settings and email behavior</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Purpose', 'Manage global settings such as alert recipients, broadcast email options, and operational defaults.'],
            ['Field-by-Field Review', 'Read each label and helper text before editing to avoid unintended system-wide changes.'],
            ['Alert Emails', 'Use valid comma-separated email addresses for daily summaries and monitoring notifications.'],
            ['Personal Alert Email', 'Set a valid inbox for urgent deadline alerts and verify it can receive external messages.'],
            ['BCC Audit Email', 'Optional archive inbox for compliance tracking of outgoing deadline alert emails.'],
            ['Save and Confirm', 'After saving, send a test email and verify recipients receive the message correctly.'],
            ['Common Mistakes', 'Invalid email format, empty required fields, or wrong recipient list causes delivery failure.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 15. Role-Permission Matrix --}}
<div class="section">
    <div class="section-header">
        <span class="icon">📊</span>
        <div><h2>Role-Permission Matrix</h2><div class="sub">Who can do what in each module</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Executive', 'Can view global reports and high-level project progress; usually approval and oversight focused.'],
            ['Project Manager', 'Can create projects/tasks, assign members, and approve task completion in project workflows.'],
            ['Admin', 'Full system access including user management, settings, and all project/task operations.'],
            ['Sales', 'Can view and update tasks scoped to sales responsibilities and assigned projects.'],
            ['Technical', 'Can work on technical tasks, update status, and contribute to project delivery milestones.'],
            ['Pre Sale', 'Can manage early-stage requirements, scope preparation tasks, and pre-implementation activities.'],
            ['How to Use Matrix', 'If access is denied, check both role assignment and project membership before escalating.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

{{-- 18. Notification & Email Matrix --}}
<div class="section">
    <div class="section-header">
        <span class="icon">📬</span>
        <div><h2>Notification & Email Matrix</h2><div class="sub">Event-to-recipient mapping</div></div>
    </div>
    <table class="items">
        @foreach([
            ['Task Assigned', 'In-app: Assignee. Email: Assignee (if enabled).'],
            ['Status Changed', 'In-app: Task creator and related team members. Email: Optional depending on alert configuration.'],
            ['Task Overdue', 'In-app: Assignee and managers/PM. Email: Alert recipients and optional audit BCC.'],
            ['For Review Submitted', 'In-app: PM/Admin reviewers. Email: Reviewer group when configured.'],
            ['Meeting Scheduled', 'In-app: Invited users. Email: Optional meeting notice based on settings.'],
            ['Daily Summary', 'In-app: Not applicable. Email: Configured broadcast recipients at scheduled time.'],
            ['Verification Step', 'Test using a sample task event after configuration changes to confirm delivery path.'],
        ] as [$label, $desc])
        <tr>
            <td class="dot"><span></span></td>
            <td class="label">{{ $label }}</td>
            <td class="desc">{{ $desc }}</td>
        </tr>
        @endforeach
    </table>
</div>

<div class="footer">
    © {{ now()->year }} Movaflex Designs Unlimited Inc. &nbsp;|&nbsp; TaskFlow Workspace &nbsp;|&nbsp; User Manual v1.0
</div>

</body>
</html>
