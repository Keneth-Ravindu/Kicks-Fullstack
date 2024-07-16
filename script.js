document.addEventListener("DOMContentLoaded", function() {
    const menuBtn = document.getElementById('menu-btn');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Toggle dropdown menu visibility
    menuBtn.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
    });

    // Close dropdown menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!menuBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });

    // Prevent closing dropdown when clicking inside
    dropdownMenu.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});













