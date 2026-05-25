const fs = require('fs');

const files = [
    'resources/views/projects/create.blade.php',
    'resources/views/projects/edit.blade.php',
    'resources/views/projects/show.blade.php',
    'resources/views/tasks/create.blade.php',
    'resources/views/tasks/edit.blade.php',
    'resources/views/tasks/kanban.blade.php'
];

files.forEach(file => {
    if (fs.existsSync(file)) {
        let content = fs.readFileSync(file, 'utf8');
        content = content
            .replace(/bg-white(?!(\s+dark:))/g, 'bg-white dark:bg-slate-800')
            .replace(/text-slate-800(?!(\s+dark:))/g, 'text-slate-800 dark:text-slate-100')
            .replace(/text-slate-700(?!(\s+dark:))/g, 'text-slate-700 dark:text-slate-300')
            .replace(/text-slate-600(?!(\s+dark:))/g, 'text-slate-600 dark:text-slate-400')
            .replace(/text-slate-500(?!(\s+dark:))/g, 'text-slate-500 dark:text-slate-400')
            .replace(/border-slate-300(?!(\s+dark:))/g, 'border-slate-300 dark:border-slate-600')
            .replace(/border-slate-200(?!(\s+dark:))/g, 'border-slate-200 dark:border-slate-700')
            .replace(/bg-slate-50(?!\/|(\s+dark:))/g, 'bg-slate-50 dark:bg-slate-700/50')
            .replace(/bg-slate-100(?!(\s+dark:))/g, 'bg-slate-100 dark:bg-slate-700')
            .replace(/hover:bg-slate-50(?!(\s+dark:))/g, 'hover:bg-slate-50 dark:hover:bg-slate-700')
            .replace(/bg-amber-50(?!\/|(\s+dark:))/g, 'bg-amber-50 dark:bg-amber-900/30')
            .replace(/border-amber-200(?!(\s+dark:))/g, 'border-amber-200 dark:border-amber-800')
            .replace(/text-amber-700(?!(\s+dark:))/g, 'text-amber-700 dark:text-amber-400')
            .replace(/text-amber-800(?!(\s+dark:))/g, 'text-amber-800 dark:text-amber-300')
            .replace(/text-amber-900(?!(\s+dark:))/g, 'text-amber-900 dark:text-amber-200')
            .replace(/bg-emerald-50(?!\/|(\s+dark:))/g, 'bg-emerald-50 dark:bg-emerald-900/30')
            .replace(/bg-emerald-100(?!(\s+dark:))/g, 'bg-emerald-100 dark:bg-emerald-900/40')
            .replace(/border-emerald-200(?!(\s+dark:))/g, 'border-emerald-200 dark:border-emerald-800')
            .replace(/text-emerald-700(?!(\s+dark:))/g, 'text-emerald-700 dark:text-emerald-400')
            .replace(/text-emerald-800(?!(\s+dark:))/g, 'text-emerald-800 dark:text-emerald-300')
            .replace(/bg-green-50(?!\/|(\s+dark:))/g, 'bg-green-50 dark:bg-green-900/30')
            .replace(/border-green-200(?!(\s+dark:))/g, 'border-green-200 dark:border-green-800')
            .replace(/text-green-700(?!(\s+dark:))/g, 'text-green-700 dark:text-green-400')
            .replace(/bg-blue-50(?!\/|(\s+dark:))/g, 'bg-blue-50 dark:bg-blue-900/30')
            .replace(/border-blue-200(?!(\s+dark:))/g, 'border-blue-200 dark:border-blue-800')
            .replace(/text-blue-700(?!(\s+dark:))/g, 'text-blue-700 dark:text-blue-400');
        fs.writeFileSync(file, content);
    }
});
