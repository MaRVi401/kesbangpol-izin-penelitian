// resources/js/landing.js
export function initScrollSpy() {
    window.addEventListener('scroll', () => {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');

        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= (sectionTop - 100)) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('text-blue-700', 'dark:text-blue-500', 'font-bold');
            link.classList.add('text-gray-900', 'dark:text-white');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('text-blue-700', 'dark:text-blue-500', 'font-bold');
                link.classList.remove('text-gray-900', 'dark:text-white');
            }
        });
    });
}
