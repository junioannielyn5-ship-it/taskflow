// Dark mode helpers for Movaflex dashboard
function applyTheme(theme) {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
}

function getStoredTheme() {
    return localStorage.getItem('theme');
}

function getPreferredTheme() {
    if (getStoredTheme()) {
        return getStoredTheme();
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function setTheme(theme) {
    localStorage.setItem('theme', theme);
    applyTheme(theme);
}

function toggleDarkMode() {
    const nextTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
    setTheme(nextTheme);
}

applyTheme(getPreferredTheme());

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (event) {
    if (!getStoredTheme()) {
        applyTheme(event.matches ? 'dark' : 'light');
    }
});

window.toggleDarkMode = toggleDarkMode;
