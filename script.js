console.log('Script1 loaded');
    document.addEventListener("DOMContentLoaded", function() {
        const toggleDropdown = (btnId, menuId) => {
            const menuBtn = document.getElementById(btnId);
            const dropdownMenu = document.getElementById(menuId);

            let timeout;

            menuBtn.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the event from bubbling up to the document
                dropdownMenu.classList.toggle('show');
                
                // Clear any previous timeout
                if (timeout) clearTimeout(timeout);

                // Hide dropdown after 500ms if clicking outside
                timeout = setTimeout(() => {
                    document.addEventListener('click', function(event) {
                        if (!menuBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                            dropdownMenu.classList.remove('show');
                        }
                    }, { once: true });
                }, 500); // Delay to allow for clicks inside dropdown
            });

            dropdownMenu.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the event from bubbling up to the document
            });
        };

        // Initialize both dropdowns
        toggleDropdown('menu-btn', 'dropdown-menu');
        toggleDropdown('menu-btn2', 'dropdown-menu2');
    });

