@php
    $inline = $inline ?? false;
    $user = auth()->user();
    $canViewReports = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']);
    $canViewManager = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['manager', 'executive', 'admin']);
    $canViewProjectManager = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['project_manager', 'pm', 'admin']);
    $canViewExecutive = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['executive', 'admin']);
    $canViewLead = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['lead', 'admin']);
    $linkBase = 'mv-nav-pill';
    $linkClass = static function (array $patterns) use ($linkBase): string {
        foreach ($patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return $linkBase.' mv-nav-pill-active';
            }
        }

        return $linkBase;
    };
@endphp

<div class="{{ $inline ? 'flex flex-wrap items-center gap-2' : 'flex flex-wrap items-center gap-2' }}">
    <a href="/dashboard" class="{{ $linkClass(['dashboard']) }}">Dashboard</a>
    <a href="{{ route('tasks.list') }}" class="{{ $linkClass(['tasks.*']) }}">Tasks</a>
    <a href="{{ route('tasks.kanban') }}" class="{{ $linkClass(['tasks.kanban']) }}">Kanban</a>
    <a href="{{ route('tasks.calendar') }}" class="{{ $linkClass(['tasks.calendar']) }}">Calendar</a>
    <a href="{{ route('meetings.index') }}" class="{{ $linkClass(['meetings.*']) }}">Meetings</a>
    <a href="{{ route('holidays.index') }}" class="{{ $linkClass(['holidays.*']) }}">Holidays</a>
    <a href="{{ route('email.shortcut') }}" class="{{ $linkClass(['email.*', 'notifications.*']) }}">Email Alerts</a>
    <a href="{{ route('admin.chatbot.index') }}" class="{{ $linkClass(['admin.chatbot.*']) }}">Chatbot</a>

    @can('create-task')
        <a href="{{ route('tasks.create') }}" class="{{ $linkClass(['tasks.create']) }}">Create Task</a>
    @endcan

    <a href="/projects" class="{{ $linkClass(['projects.*']) }}">Projects</a>

    @if ($canViewReports)
        <a href="/reports" class="{{ $linkClass(['reports.*']) }}">Reports</a>
    @endif

    @if ($user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['member', 'employee', 'technical']))
        <a href="{{ route('employee.index') }}" class="{{ $linkClass(['employee.*']) }}">Employee</a>
    @endif

    @if ($canViewManager)
        <a href="{{ route('manager.index') }}" class="{{ $linkClass(['manager.*']) }}">Manager</a>
    @endif

    @if ($canViewProjectManager)
        <a href="{{ route('project-manager.index') }}" class="{{ $linkClass(['project-manager.*']) }}">Project Manager</a>
    @endif

    @if ($canViewExecutive)
        <a href="{{ route('executive.index') }}" class="{{ $linkClass(['executive.*']) }}">Executive</a>
    @endif

    @if ($canViewLead)
        <a href="{{ route('lead.index') }}" class="{{ $linkClass(['lead.*']) }}">Lead</a>
    @endif

    @if ($user && method_exists($user, 'isAdmin') && $user->isAdmin())
        <a href="/admin" class="{{ $linkClass(['admin.*']) }}">Admin</a>
    @endif

    @if (Route::has('logout'))
        <form method="POST" action="{{ route('logout') }}" class="inline-flex">
            @csrf
            <button type="submit" class="{{ $linkBase }} mv-nav-danger">Logout</button>
        </form>
    @endif
</div>
