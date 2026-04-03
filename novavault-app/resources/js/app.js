import './bootstrap';

import Alpine from 'alpinejs';

// Theme toggle — persisted in localStorage
Alpine.data('themeToggle', () => ({
    dark: true,
    init() {
        const stored = localStorage.getItem('nv-theme');
        if (stored === 'light') {
            this.dark = false;
        } else if (stored === 'dark') {
            this.dark = true;
        }
        // else: default to dark (NovaVault brand)
        this.apply();
    },
    toggle() {
        this.dark = !this.dark;
        localStorage.setItem('nv-theme', this.dark ? 'dark' : 'light');
        this.apply();
    },
    apply() {
        document.documentElement.classList.toggle('light', !this.dark);
        document.documentElement.classList.toggle('dark', this.dark);
    },
}));

window.Alpine = Alpine;

Alpine.start();
