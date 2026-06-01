const App = (() => {

    const THEME_KEY    = 'pengaduanku_theme';
    const DARK_CLASS   = 'dark';
    const html         = document.documentElement;

    function getStoredTheme() {
        return localStorage.getItem(THEME_KEY) || 'light';
    }

    function applyTheme(theme) {
        if (theme === 'dark') {
            html.classList.add(DARK_CLASS);
        } else {
            html.classList.remove(DARK_CLASS);
        }
        updateThemeButtons(theme);
    }

    function toggleTheme() {
        const current = getStoredTheme();
        const next    = current === 'dark' ? 'light' : 'dark';
        localStorage.setItem(THEME_KEY, next);
        applyTheme(next);
    }

    function updateThemeButtons(theme) {
        document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
            const iconEl   = btn.querySelector('[data-theme-icon]');
            const labelEl  = btn.querySelector('[data-theme-label]');

            if (iconEl)  iconEl.textContent  = theme === 'dark' ? '☀️' : '🌙';
            if (labelEl) labelEl.textContent = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
        });
    }

    function openSidebar() {
        const sidebar  = document.getElementById('mobileSidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;

        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100');
        document.body.classList.add('overflow-hidden');
    }

    function closeSidebar() {
        const sidebar  = document.getElementById('mobileSidebar');
        const overlay  = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;

        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-100');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        document.body.classList.remove('overflow-hidden');
    }

    function init() {

        applyTheme(getStoredTheme());

        document.addEventListener('DOMContentLoaded', () => {

            document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
                btn.addEventListener('click', toggleTheme);
            });

            const hamburger = document.getElementById('hamburgerBtn');
            if (hamburger) hamburger.addEventListener('click', openSidebar);

            const overlay = document.getElementById('sidebarOverlay');
            if (overlay) overlay.addEventListener('click', closeSidebar);

            const closeBtn = document.getElementById('sidebarCloseBtn');
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeSidebar();
            });

            updateThemeButtons(getStoredTheme());
        });
    }

    return { init, toggleTheme, openSidebar, closeSidebar };

})();

App.init();
