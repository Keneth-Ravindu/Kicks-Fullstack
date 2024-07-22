<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="userheader.css">
    <title>User Dashboard</title>
</head>
<body>
    <header class="header" id="mainHeader">
        <div class="flex">
            <a href="index.php" class="logo"><img src="Assets/logo.png" alt="Logo"></a>
            <nav class="navbar">
                <a href="index.php">home</a>
                <a href="about.php">about us</a>
                <a href="shop.php">shop</a>
                <a href="order.php">order</a>
                <a href="contact.php">contact</a>
            </nav>
            <div class="icons">
                <?php 
                    $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id='$user_id'") or die ('query failed');
                    $wishlist_num_rows = mysqli_num_rows($select_wishlist);
                ?>
                <a href="wishlist.php">
                    <i class="bi bi-suit-heart"></i>
                    <sup><?php echo $wishlist_num_rows; ?></sup></a>
                <?php 
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die ('query failed');
                    $cart_num_rows = mysqli_num_rows($select_cart);
                ?>
                <a href="cart.php">
                <i class="bi bi-cart2"></i>
                    <sup><?php echo $cart_num_rows; ?></sup></a>
                <i class="bi bi-person" id="menu-btn"></i>
                <div class="dropdown" id="dropdown-menu">
                    <div class="user-box">
                        <p>Username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                        <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                    </div>
                    <form method="post" action="login.php">
                        <div class="logout-btn-container">
                            <button type="submit" class="logout-btn"><span></span><span></span><span></span><span></span>Log Out</button>
                        </div>
                    </form>
                </div>
                <i class="bi bi-list" id="menu-btn2"></i>
                <div class="dropdown2" id="dropdown-menu2">
                    <a href="user.php">User</a>
                    <a href="settings.php">Settings</a>
                    <a href="find_store.php">Find a Store</a>
                    <a href="help.php">Help</a>
                    <a href="join_kicks_club.php">Join Kicks Club</a>
                </div>
            </div>
        </div>
    </header>
    
    
        <script>
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

    
</script>
<script>


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

</script>
<script src="script.js"></script>
<script src="script2.js"></script>

    
</body>
</html>
