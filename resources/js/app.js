import './bootstrap';

// Livewire 3 include già Alpine.js automaticamente!
// Aggiungiamo i plugin usando l'hook di Livewire

// Initialize dark mode on page load - ALWAYS use localStorage, ignore system preference
(function() {
    // Get saved preference, default to LIGHT mode (not system preference)
    const savedMode = localStorage.getItem('darkMode');
    
    // If no preference saved, default to light mode
    if (savedMode === null) {
        localStorage.setItem('darkMode', 'false');
        document.documentElement.classList.remove('dark');
    } else if (savedMode === 'true') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

// Global function to toggle dark mode
window.toggleDarkMode = function() {
    const isDark = document.documentElement.classList.contains('dark');
    if (isDark) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'false');
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
    }
};

// Configura Alpine quando Livewire è pronto
document.addEventListener('livewire:init', () => {
    console.log('✅ Livewire initialized!');
    
    // Mantieni il dark mode durante la navigazione Livewire
    Livewire.hook('morph.updated', ({ el, component }) => {
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'true') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
    
    // Mantieni il dark mode quando Livewire naviga con wire:navigate
    Livewire.hook('navigate', ({ path }) => {
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'true') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
    
    // Mantieni il dark mode dopo che Livewire completa la navigazione
    Livewire.hook('navigate.complete', ({ path }) => {
        const savedMode = localStorage.getItem('darkMode');
        if (savedMode === 'true') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
});

// Importa i plugin Alpine per Livewire
import focus from '@alpinejs/focus'
import intersect from '@alpinejs/intersect'

// Esporta per Livewire
window.AlpinePlugins = [focus, intersect];
