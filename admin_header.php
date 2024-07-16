<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="header.css">
    <title>Admin Dashboard</title>
    
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="admin_pannel.php" class="logo"><img src="Assets/logo.png" alt="Logo"></a>
            <nav class="navbar">
                <a href="admin_pannel.php">home</a>
                <a href="admin_product.php">products</a>
                <a href="admin_order.php">orders</a>
                <a href="admin_user.php">users</a>
                <a href="admin_message.php">messages</a>
            </nav>
            <div class="icons">
                <i class="bi bi-person" id="menu-btn"></i>
                <div class="dropdown" id="dropdown-menu">
                    <div class="user-box">
                        <p>Username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
                        <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
                        
                    </div>
                    <form method="post" action="login.php">
                    <div class="logout-btn-container">
                    <button type="submit" class="logout-btn"><span></span><span></span><span></span><span></span>Log Out</button>    
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
   

    <script src="script.js"></script>
</body>
</html>
