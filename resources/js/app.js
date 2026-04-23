import './bootstrap';
import 'flowbite';
import { initScrollSpy } from './landing';

// Dark mode setup
const htmlElement = document.documentElement;
const themeToggleBtn = document.getElementById('theme-toggle');

// Function to set theme
function setTheme(theme) {
    if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        htmlElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
}

// Initialize theme on load
const savedTheme = localStorage.getItem('theme');
setTheme(savedTheme);

// Toggle theme function
window.toggleDarkMode = function() {
    if (htmlElement.classList.contains('dark')) {
        setTheme('light');
    } else {
        setTheme('dark');
    }
};

if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', window.toggleDarkMode);
}


initScrollSpy();

window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('back-to-top');
    if (!backToTop) return;

    if (window.scrollY > 300) {
        backToTop.classList.remove('opacity-0', 'invisible');
        backToTop.classList.add('opacity-100', 'visible');
    } else {
        backToTop.classList.remove('opacity-100', 'visible');
        backToTop.classList.add('opacity-0', 'invisible');
    }
});

document.getElementById('back-to-top')?.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
