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
    <header class="header">
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
    const menuBtn2 = document.getElementById('menu-btn2');
    const dropdownMenu2 = document.getElementById('dropdown-menu2');

    // Toggle dropdown menu visibility
    menuBtn2.addEventListener('click', function() {
        dropdownMenu2.classList.toggle('show');
    });

    // Close dropdown menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!menuBtn2.contains(event.target) && !dropdownMenu2.contains(event.target)) {
            dropdownMenu2.classList.remove('show');
        }
    });

    // Prevent closing dropdown when clicking inside
    dropdownMenu2.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});
    </script>
    <script src="script.js"></script>
</body>
</html>
