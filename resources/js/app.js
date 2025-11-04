import './bootstrap';

// Livewire 3 include già Alpine.js automaticamente!
// Aggiungiamo i plugin usando l'hook di Livewire

// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    if (darkMode) {
        document.documentElement.classList.add('dark');
    }
});

// Configura Alpine quando Livewire è pronto
document.addEventListener('livewire:init', () => {
    console.log('✅ Livewire initialized!');
});

// Importa i plugin Alpine per Livewire
import focus from '@alpinejs/focus'
import intersect from '@alpinejs/intersect'

// Esporta per Livewire
window.AlpinePlugins = [focus, intersect];
