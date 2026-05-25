@auth
@php
    $user = auth()->user();
    $canViewReports        = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']);
    $canViewProjectManager = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['project_manager', 'pm', 'admin']);
    $canViewMasters        = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'manager']);

    $navLinks = [
        ['label'=>'Dashboard',     'href'=>route('dashboard'),          'active'=>request()->routeIs('dashboard'),   'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
        ['label'=>'My Tasks',      'href'=>route('tasks.list'),         'active'=>request()->routeIs('tasks.*') && !request()->routeIs('tasks.kanban') && !request()->routeIs('tasks.calendar'), 'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'],
        ['label'=>'Kanban',        'href'=>route('tasks.kanban'),       'active'=>request()->routeIs('tasks.kanban'),    'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"/>'],
        ['label'=>'Calendar',      'href'=>route('tasks.calendar'),     'active'=>request()->routeIs('tasks.calendar'),  'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
        ['label'=>'Projects',      'href'=>url('/projects'),            'active'=>request()->routeIs('projects.*'),      'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
        ['label'=>'Meetings',      'href'=>route('meetings.index'),     'active'=>request()->routeIs('meetings.*'),      'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
        ['label'=>'Holidays',      'href'=>route('holidays.index'),     'active'=>request()->routeIs('holidays.*'),      'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m3.343-5.657l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M12 8a4 4 0 110 8 4 4 0 010-8z"/>'],
        ['label'=>'Notifications', 'href'=>route('notifications.history'), 'active'=>request()->routeIs('notifications.*'), 'always'=>true,
         'badge'=>isset($sidebarUnreadCount) && $sidebarUnreadCount > 0 ? $sidebarUnreadCount : null,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'],
        ['label'=>'User Manual',   'href'=>route('help'),               'active'=>request()->routeIs('help*'),           'always'=>false,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"/>'],
    ];

    $inventoryLinks = [];
    if ($canViewMasters) {
        $inventoryLinks[] = ['label'=>'Inventory Item',     'href'=>route('inventory.index'),    'active'=>request()->routeIs('inventory.*'),
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>'];
        $inventoryLinks[] = ['label'=>'Stock Move (In)',    'href'=>url('/inventory/stock-move'),'active'=>request()->is('inventory/stock-move*'),
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>'];
        $inventoryLinks[] = ['label'=>'Stock Out (Dispatch)','href'=>url('/inventory/stock-out'), 'active'=>request()->is('inventory/stock-out*'),
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>'];
        $inventoryLinks[] = ['label'=>'Stock Correction',   'href'=>url('/inventory/stock-correction'), 'active'=>request()->is('inventory/stock-correction*'),
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>'];

        // Add Supplier and Client List to management or keep in navLinks? The user asked to put RBAC on them. Let's keep them in navLinks for now so they appear under Main Menu.
        $navLinks[] = ['label'=>'Supplier List', 'href'=>route('supplier.index'),     'active'=>request()->routeIs('supplier.*'),      'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>'];
        $navLinks[] = ['label'=>'Client List',   'href'=>route('client.index'),       'active'=>request()->routeIs('client.*'),        'always'=>true,
         'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'];
    }


    if ($canViewReports) {
        $navLinks[] = ['label'=>'Reports', 'href'=>url('/reports'), 'active'=>request()->routeIs('reports.*'), 'always'=>false,
            'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>'];
    }
    if ($canViewProjectManager) {
        $navLinks[] = ['label'=>'Project Manager', 'href'=>route('project-manager.index'), 'active'=>request()->routeIs('project-manager.*'), 'always'=>false,
            'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'];
    }
    if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
        $navLinks[] = ['label'=>'Admin', 'href'=>url('/admin'), 'active'=>request()->routeIs('admin.*'), 'always'=>false,
            'icon'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>'];
    }
@endphp

{{-- ─────────────────────────────────────────── --}}
{{-- INLINE STYLES  (glassmorphism variables)   --}}
{{-- ─────────────────────────────────────────── --}}
<style>
/* ── Glass Sidebar Panel ── */
#gbl-sidebar-panel {
    background: rgba(255, 255, 255, 0.55);
    backdrop-filter: blur(28px) saturate(180%);
    -webkit-backdrop-filter: blur(28px) saturate(180%);
    border-right: 1px solid rgba(255, 255, 255, 0.45);
    box-shadow:
        6px 0 40px rgba(15, 23, 42, 0.12),
        inset -1px 0 0 rgba(255, 255, 255, 0.6);
}
html.dark #gbl-sidebar-panel {
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(28px) saturate(160%);
    -webkit-backdrop-filter: blur(28px) saturate(160%);
    border-right: 1px solid rgba(255, 255, 255, 0.07);
    box-shadow:
        6px 0 48px rgba(0, 0, 0, 0.45),
        inset -1px 0 0 rgba(255, 255, 255, 0.04);
}

/* ── Glass Header ── */
#gbl-sidebar-header {
    background: rgba(255, 255, 255, 0.35);
    border-bottom: 1px solid rgba(255, 255, 255, 0.50);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
html.dark #gbl-sidebar-header {
    background: rgba(255, 255, 255, 0.04);
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

/* ── Glass User Card ── */
#gbl-sidebar-usercard {
    background: rgba(255, 255, 255, 0.30);
    border-bottom: 1px solid rgba(255, 255, 255, 0.40);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
html.dark #gbl-sidebar-usercard {
    background: rgba(255, 255, 255, 0.04);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

/* ── Glass Nav Links ── */
.gbl-nav-link {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.75rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #334155;
    border: 1px solid transparent;
    background: transparent;
    transition: all 0.2s ease;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
html.dark .gbl-nav-link { color: #94a3b8; }

.gbl-nav-link::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: rgba(255,255,255,0);
    transition: background 0.2s;
}
.gbl-nav-link:hover::before {
    background: rgba(255, 255, 255, 0.50);
}
html.dark .gbl-nav-link:hover::before {
    background: rgba(255, 255, 255, 0.06);
}
.gbl-nav-link:hover {
    color: #0f172a;
    border-color: rgba(255, 255, 255, 0.60);
    box-shadow: 0 2px 12px rgba(14, 165, 233, 0.10);
    transform: translateX(2px);
}
html.dark .gbl-nav-link:hover {
    color: #e2e8f0;
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 2px 12px rgba(0,0,0,0.3);
}

/* ── Active nav link — glowing glass pill ── */
.gbl-nav-active {
    color: #1d4ed8 !important;
    background: linear-gradient(135deg,
        rgba(219,234,254,0.80) 0%,
        rgba(224,242,254,0.65) 100%) !important;
    border-color: rgba(147,197,253,0.70) !important;
    box-shadow:
        inset 3px 0 0 #3b82f6,
        0 4px 20px rgba(59,130,246,0.18),
        inset 0 1px 0 rgba(255,255,255,0.80) !important;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    font-weight: 700;
    transform: none !important;
}
html.dark .gbl-nav-active {
    color: #93c5fd !important;
    background: linear-gradient(135deg,
        rgba(30,58,138,0.45) 0%,
        rgba(23,37,84,0.35) 100%) !important;
    border-color: rgba(59,130,246,0.35) !important;
    box-shadow:
        inset 3px 0 0 #60a5fa,
        0 4px 20px rgba(59,130,246,0.25),
        inset 0 1px 0 rgba(255,255,255,0.06) !important;
}

/* ── Nav Icon ── */
.gbl-nav-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.6rem;
    height: 1.6rem;
    border-radius: 0.45rem;
    flex-shrink: 0;
    background: rgba(255,255,255,0.40);
    border: 1px solid rgba(255,255,255,0.55);
    transition: all 0.2s;
}
html.dark .gbl-nav-icon {
    background: rgba(255,255,255,0.06);
    border-color: rgba(255,255,255,0.08);
}
.gbl-nav-link:hover .gbl-nav-icon {
    background: rgba(255,255,255,0.65);
    box-shadow: 0 2px 8px rgba(14,165,233,0.15);
}
html.dark .gbl-nav-link:hover .gbl-nav-icon {
    background: rgba(255,255,255,0.10);
}
.gbl-nav-active .gbl-nav-icon {
    background: rgba(59,130,246,0.15) !important;
    border-color: rgba(147,197,253,0.50) !important;
    color: #2563eb;
    box-shadow: 0 0 8px rgba(59,130,246,0.25);
}
html.dark .gbl-nav-active .gbl-nav-icon {
    background: rgba(59,130,246,0.20) !important;
    border-color: rgba(59,130,246,0.25) !important;
    color: #93c5fd;
}

/* ── Section labels ── */
.gbl-nav-section {
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    padding: 0 0.5rem;
    margin-bottom: 0.375rem;
    color: rgba(100,116,139,0.70);
}
html.dark .gbl-nav-section { color: rgba(148,163,184,0.45); }

/* ── Divider ── */
.gbl-nav-divider {
    height: 1px;
    margin: 0.625rem 0.5rem;
    background: linear-gradient(90deg,
        transparent,
        rgba(148,163,184,0.30) 30%,
        rgba(148,163,184,0.30) 70%,
        transparent);
}
html.dark .gbl-nav-divider {
    background: linear-gradient(90deg,
        transparent,
        rgba(255,255,255,0.08) 30%,
        rgba(255,255,255,0.08) 70%,
        transparent);
}

/* ── Scroll ── */
.gbl-sidebar-scroll {
    scrollbar-width: thin;
    scrollbar-color: rgba(148,163,184,0.35) transparent;
}
.gbl-sidebar-scroll::-webkit-scrollbar { width: 3px; }
.gbl-sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
.gbl-sidebar-scroll::-webkit-scrollbar-thumb {
    background: rgba(148,163,184,0.35);
    border-radius: 9999px;
}

/* ── Glass Footer ── */
#gbl-sidebar-footer {
    background: rgba(255,255,255,0.28);
    border-top: 1px solid rgba(255,255,255,0.45);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
html.dark #gbl-sidebar-footer {
    background: rgba(0,0,0,0.20);
    border-top: 1px solid rgba(255,255,255,0.05);
}

/* ── Toggle Tab Button ── */
#gbl-sidebar-toggle {
    background: linear-gradient(160deg,
        rgba(6,182,212,0.90) 0%,
        rgba(37,99,235,0.90) 100%);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.35);
    border-left: none;
    box-shadow:
        3px 0 18px rgba(6,182,212,0.45),
        inset 0 1px 0 rgba(255,255,255,0.30);
    transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
}
#gbl-sidebar-toggle:hover {
    width: 1.625rem;
    box-shadow:
        4px 0 28px rgba(6,182,212,0.70),
        inset 0 1px 0 rgba(255,255,255,0.35);
}

/* ── Backdrop ── */
#gbl-sidebar-backdrop {
    background: rgba(15,23,42,0.35);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}
html.dark #gbl-sidebar-backdrop {
    background: rgba(0,0,0,0.55);
}

/* ── Ambient orbs inside sidebar ── */
.gbl-orb {
    pointer-events: none;
    position: absolute;
    border-radius: 9999px;
    filter: blur(60px);
    opacity: 0.45;
}
</style>

{{-- ─────────────────────────────── --}}
{{-- TOGGLE TAB                      --}}
{{-- ─────────────────────────────── --}}
<button
    id="gbl-sidebar-toggle"
    onclick="gblToggleSidebar()"
    title="Toggle Navigation"
    aria-label="Toggle Navigation Sidebar"
    aria-expanded="false"
    class="fixed left-0 top-1/2 z-[80] -translate-y-1/2
           flex flex-col items-center justify-center gap-[3px]
           w-[1.35rem] h-[5rem] sm:w-[1.15rem] sm:h-[4.5rem] rounded-r-xl touch-manipulation">
    <span id="gbl-bar1" class="block h-[2px] w-[10px] rounded-full bg-white/90 transition-all duration-300 ease-in-out origin-center"></span>
    <span id="gbl-bar2" class="block h-[2px] w-[10px] rounded-full bg-white/90 transition-all duration-300 ease-in-out"></span>
    <span id="gbl-bar3" class="block h-[2px] w-[10px] rounded-full bg-white/90 transition-all duration-300 ease-in-out origin-center"></span>
</button>

{{-- ─────────────────────────────── --}}
{{-- BACKDROP                        --}}
{{-- ─────────────────────────────── --}}
<div id="gbl-sidebar-backdrop"
     onclick="gblCloseSidebar()"
     class="fixed inset-0 z-[70] hidden">
</div>

{{-- ─────────────────────────────── --}}
{{-- SIDEBAR PANEL                   --}}
{{-- ─────────────────────────────── --}}
<aside
    id="gbl-sidebar-panel"
    aria-label="Main Navigation"
    role="navigation"
    class="fixed top-0 left-0 z-[75] h-screen w-72 flex flex-col
           -translate-x-full
           transition-transform duration-300 ease-in-out">

    {{-- ── Ambient Background Orbs ── --}}
    <div class="gbl-orb w-48 h-48 -top-12 -left-12 bg-cyan-400/30 dark:bg-cyan-500/15"></div>
    <div class="gbl-orb w-40 h-40 bottom-16 -right-8 bg-blue-500/20 dark:bg-blue-600/10"></div>
    <div class="gbl-orb w-32 h-32 top-1/2 left-1/4 bg-indigo-400/15 dark:bg-indigo-500/08"></div>

    {{-- ── HEADER ── --}}
    <div id="gbl-sidebar-header"
         class="relative flex items-center justify-between px-5 py-4 shrink-0 z-10">
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group" aria-label="Go to Dashboard">
            <div class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-xl
                        bg-gradient-to-br from-cyan-400 to-blue-600
                        shadow-[0_0_18px_rgba(6,182,212,0.55)]
                        group-hover:shadow-[0_0_28px_rgba(6,182,212,0.80)]
                        transition-all duration-250 ring-2 ring-white/30">
                <svg class="h-5 w-5 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-[1.05rem] font-black tracking-wider text-slate-800 dark:text-white leading-none drop-shadow-sm">
                    TASK<span class="text-cyan-500 dark:text-cyan-400">FLOW</span>
                </p>
                <p class="text-[8.5px] font-bold uppercase tracking-[0.2em] text-slate-500/70 dark:text-slate-400/60 mt-0.5">Workspace</p>
            </div>
        </a>
        {{-- Close --}}
        <button onclick="gblCloseSidebar()" aria-label="Close sidebar"
                class="flex items-center justify-center h-8 w-8 rounded-xl
                       bg-white/30 dark:bg-white/05
                       border border-white/50 dark:border-white/08
                       text-slate-500 dark:text-slate-400
                       hover:bg-white/55 dark:hover:bg-white/10
                       hover:text-slate-800 dark:hover:text-white
                       transition-all duration-200 backdrop-blur-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    {{-- ── USER CARD ── --}}
    <div id="gbl-sidebar-usercard" class="relative px-4 py-3 shrink-0 z-10">
        <div class="flex items-center gap-3">
            @if(auth()->user()->profile_photo_path)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                     class="h-10 w-10 rounded-xl object-cover
                            ring-2 ring-white/60 dark:ring-white/15
                            shadow-[0_0_12px_rgba(6,182,212,0.30)]"
                     alt="{{ auth()->user()->name }}">
            @else
                <div class="flex h-10 w-10 items-center justify-center rounded-xl
                            bg-gradient-to-br from-blue-500 to-indigo-600
                            text-sm font-black text-white
                            ring-2 ring-white/40 dark:ring-white/10
                            shadow-[0_0_14px_rgba(79,70,229,0.40)]">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-bold text-slate-800 dark:text-white drop-shadow-sm">{{ auth()->user()->name }}</p>
                <p class="truncate text-[11px] text-slate-500/80 dark:text-slate-400/70">{{ auth()->user()->email }}</p>
            </div>
            {{-- Online dot --}}
            <span class="relative flex h-2.5 w-2.5 shrink-0">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 ring-2 ring-white/60 dark:ring-slate-900/80"></span>
            </span>
        </div>
    </div>

    {{-- ── NAVIGATION ── --}}
    <nav class="relative flex-1 overflow-y-auto px-3 py-3 gbl-sidebar-scroll z-10" aria-label="Sidebar navigation">

        <p class="gbl-nav-section">Main Menu</p>

        @foreach($navLinks as $link)
            @if($link['always'])
            <a href="{{ $link['href'] }}"
               class="gbl-nav-link {{ $link['active'] ? 'gbl-nav-active' : '' }}"
               @if($link['active']) aria-current="page" @endif>
                <span class="gbl-nav-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $link['icon'] !!}
                    </svg>
                </span>
                <span class="flex-1 truncate">{{ $link['label'] }}</span>
                @if(isset($link['badge']) && $link['badge'])
                    <span class="ml-auto flex h-5 min-w-[1.25rem] items-center justify-center rounded-full
                                 bg-rose-500 px-1.5 text-[10px] font-bold text-white
                                 shadow-[0_0_8px_rgba(239,68,68,0.55)]">
                        {{ $link['badge'] > 99 ? '99+' : $link['badge'] }}
                    </span>
                @endif
            </a>
            @endif
        @endforeach

        {{-- Inventory Hub section --}}
        @if(isset($inventoryLinks) && count($inventoryLinks) > 0)
            <div class="gbl-nav-divider"></div>
            <p class="gbl-nav-section">Inventory Hub</p>

            @foreach($inventoryLinks as $link)
                <a href="{{ $link['href'] }}"
                   class="gbl-nav-link {{ $link['active'] ? 'gbl-nav-active' : '' }}"
                   @if($link['active']) aria-current="page" @endif>
                    <span class="gbl-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $link['icon'] !!}
                        </svg>
                    </span>
                    <span class="flex-1 truncate">{{ $link['label'] }}</span>
                </a>
            @endforeach
        @endif

        {{-- Management section --}}
        @php $hasRoleLinks = collect($navLinks)->contains('always', false); @endphp
        @if($hasRoleLinks)
            <div class="gbl-nav-divider"></div>
            <p class="gbl-nav-section">Management</p>

            @foreach($navLinks as $link)
                @if(!$link['always'])
                <a href="{{ $link['href'] }}"
                   class="gbl-nav-link {{ $link['active'] ? 'gbl-nav-active' : '' }}"
                   @if($link['active']) aria-current="page" @endif>
                    <span class="gbl-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $link['icon'] !!}
                        </svg>
                    </span>
                    <span class="flex-1 truncate">{{ $link['label'] }}</span>
                </a>
                @endif
            @endforeach
        @endif
    </nav>

    {{-- ── FOOTER ── --}}
    <div id="gbl-sidebar-footer" class="relative px-3 py-3 shrink-0 z-10">
        @if(Route::has('logout'))
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5
                           text-sm font-semibold text-rose-600 dark:text-rose-400
                           bg-rose-50/60 dark:bg-rose-950/30
                           border border-rose-200/60 dark:border-rose-800/30
                           hover:bg-rose-100/80 dark:hover:bg-rose-900/40
                           backdrop-blur-sm
                           transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </button>
        </form>
        @endif
    </div>
</aside>

{{-- ─────────────────────────────── --}}
{{-- SCRIPT                          --}}
{{-- ─────────────────────────────── --}}
<script>
(function () {
    var _panel    = document.getElementById('gbl-sidebar-panel');
    var _backdrop = document.getElementById('gbl-sidebar-backdrop');
    var _btn      = document.getElementById('gbl-sidebar-toggle');
    var _b1       = document.getElementById('gbl-bar1');
    var _b2       = document.getElementById('gbl-bar2');
    var _b3       = document.getElementById('gbl-bar3');
    var _open     = false;

    function _setState(open) {
        _open = open;

        if (open) {
            _panel.classList.remove('-translate-x-full');
            _panel.classList.add('translate-x-0');
            _backdrop.classList.remove('hidden');
            /* hamburger → X */
            if (_b1) { _b1.style.transform = 'translateY(5px) rotate(45deg)'; }
            if (_b2) { _b2.style.opacity = '0'; _b2.style.transform = 'scaleX(0)'; }
            if (_b3) { _b3.style.transform = 'translateY(-5px) rotate(-45deg)'; }
            if (_btn) _btn.setAttribute('aria-expanded', 'true');
        } else {
            _panel.classList.add('-translate-x-full');
            _panel.classList.remove('translate-x-0');
            _backdrop.classList.add('hidden');
            /* X → hamburger */
            if (_b1) { _b1.style.transform = ''; }
            if (_b2) { _b2.style.opacity = ''; _b2.style.transform = ''; }
            if (_b3) { _b3.style.transform = ''; }
            if (_btn) _btn.setAttribute('aria-expanded', 'false');
        }
    }

    window.gblToggleSidebar = function () { _setState(!_open); };
    window.gblCloseSidebar  = function () { _setState(false); };
    window.gblOpenSidebar   = function () { _setState(true); };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && _open) gblCloseSidebar();
    });
}());
</script>
@endauth

