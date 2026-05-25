const fs = require('fs');
let content = fs.readFileSync('resources/views/tasks/index.blade.php', 'utf8');

const styleBlock = `<style>
    .tasks-table th:last-child,
    .tasks-table td:last-child {
        position: sticky;
        right: 0;
        z-index: 5;
    }
    .tasks-table thead th:last-child {
        z-index: 15;
    }
    /* Priority pin badges */
    .priority-pin {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.12);
        border: 1px solid transparent;
    }
    .pin-dot {
        box-shadow: 0 0 0 3px rgba(255,255,255,0.45);
    }
    .dark .pin-dot {
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.5);
    }
    .priority-pin.pin-urgent {
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border-color: #fca5a5 !important;
    }
    .priority-pin.pin-high {
        background: #fff7ed !important;
        color: #ea580c !important;
        border-color: #fdba74 !important;
    }
    .priority-pin.pin-medium {
        background: #fefce8 !important;
        color: #ca8a04 !important;
        border-color: #fde047 !important;
    }
    .priority-pin.pin-low {
        background: #f0fdf4 !important;
        color: #16a34a !important;
        border-color: #86efac !important;
    }
    .dark .priority-pin.pin-urgent {
        background: rgba(220, 38, 38, 0.15) !important;
        color: #fca5a5 !important;
        border-color: rgba(220, 38, 38, 0.3) !important;
    }
    .dark .priority-pin.pin-high {
        background: rgba(234, 88, 12, 0.15) !important;
        color: #fdba74 !important;
        border-color: rgba(234, 88, 12, 0.3) !important;
    }
    .dark .priority-pin.pin-medium {
        background: rgba(202, 138, 4, 0.15) !important;
        color: #fde047 !important;
        border-color: rgba(202, 138, 4, 0.3) !important;
    }
    .dark .priority-pin.pin-low {
        background: rgba(22, 163, 74, 0.15) !important;
        color: #86efac !important;
        border-color: rgba(22, 163, 74, 0.3) !important;
    }
    .dark .pin-dot {
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.5);
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: flex-end;
    }
    .filter-group > div {
        flex: 1 1 160px;
        min-width: 120px;
    }
    .filter-advanced-toggle {
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        font-size: 1.2em;
        margin-left: 0.5rem;
        padding: 0.25em;
        transition: color 0.2s;
    }
    .filter-advanced-toggle:hover {
        color: #0ea5e9;
    }
    .action-btn {
        background: none;
        border: none;
        padding: 0.4em 0.6em;
        border-radius: 0.5em;
        color: #64748b;
        transition: background 0.2s, color 0.2s;
        font-size: 1.1em;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .action-btn:hover {
        background: #e0e7ef;
        color: #0ea5e9;
    }
    .dark .action-btn:hover {
        background: #334155;
        color: #38bdf8;
    }
    .tasks-table th.w-20, .tasks-table td.w-20 { width: 80px !important; min-width: 60px; }
    .tasks-table th.w-40, .tasks-table td.w-40 { width: 180px !important; min-width: 120px; }
    .tasks-table th.w-44, .tasks-table td.w-44 { width: 220px !important; min-width: 140px; }
    .tasks-table th.w-48, .tasks-table td.w-48 { width: 260px !important; min-width: 160px; }
    .tasks-table th.w-52, .tasks-table td.w-52 { width: 280px !important; min-width: 180px; }
    .tasks-table th.w-36, .tasks-table td.w-36 { width: 140px !important; min-width: 100px; }
    .tasks-table th.w-28, .tasks-table td.w-28 { width: 110px !important; min-width: 80px; }
    .tasks-table th.w-24, .tasks-table td.w-24 { width: 90px !important; min-width: 70px; }
    .tasks-table th.w-32, .tasks-table td.w-32 { width: 120px !important; min-width: 90px; }
</style>`;

content = content.replace(/<style>[\s\S]*?<\/style>/, styleBlock);
fs.writeFileSync('resources/views/tasks/index.blade.php', content);
console.log('Done');
