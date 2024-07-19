console.log('Script loaded'); // This will confirm if the script is running

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    let lastScrollY = window.scrollY;
    let ticking = false;

    function updateHeader() {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                if (window.scrollY === 0) {
                    // At the top of the page
                    header.classList.remove('scrolling-up', 'scrolling-down');
                    header.style.background = 'var(--color7)'; // Default background
                    header.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)'; // Default shadow
                } else if (window.scrollY > lastScrollY) {
                    // Scrolling down
                    header.classList.remove('scrolling-up');
                    header.classList.add('scrolling-down');
                    header.style.background = 'rgba(0, 0, 0, 0.5)'; // Background when scrolling down
                    header.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.1)'; // Shadow when scrolling down
                } else {
                    // Scrolling up
                    header.classList.remove('scrolling-down');
                    header.classList.add('scrolling-up');
                    header.style.background = 'rgba(0, 0, 0, 0.8)'; // Background when scrolling up
                    header.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.3)'; // Shadow when scrolling up
                }
                lastScrollY = window.scrollY;
                ticking = false;
            });
            ticking = true;
        }
    }

    window.addEventListener('scroll', updateHeader);
});