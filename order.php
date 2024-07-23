<?php 
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if (!isset($user_id)) {
        header('location:login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location: login.php");
    }
    if (isset($_POST['submit-btn'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name= '$name' AND email='$email' AND number = '$number' AND message= '$message'") or die('query failed');
        if (mysqli_num_rows($select_message)>0) {
            echo 'message already sent';
        }else{
            mysqli_query($conn, "INSERT INTO `message`(`user_id`,`name`,`email`,`number`,`message`) VALUES('$user_id','$name','$email','$number','$message')") or die('query failed');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!------------------------bootstrap icon link------------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Kicks Orders Page</title>
    <style>
        /* Keyframe animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Order section styling */
        .order-section {
            padding: 20px;
            background: #1c1c1c;
            color: #fff;
            animation: fadeIn 1s ease-in-out;
        }

        .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .box {
            background: #2e2e2e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.5s ease-out;
            flex: 1 1 calc(33.333% - 20px);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .box:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .box p {
            margin: 0;
            padding: 5px 0;
        }

        .box p span {
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 50px;
            font-size: 1.2em;
            color: #ccc;
            background: #2e2e2e;
            border-radius: 10px;
            animation: fadeIn 1s ease-in-out;
        }

        /* Order summary section */
        .order-summary {
            margin: 20px 0;
            padding: 20px;
            background: #333;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .order-summary h2 {
            margin-bottom: 15px;
            color: #f2a02f;
        }

        .order-summary ul {
            list-style: none;
            padding: 0;
        }

        .order-summary ul li {
            padding: 10px 0;
            border-bottom: 1px solid #444;
            color: #ddd;
        }

        .order-summary ul li:last-child {
            border-bottom: none;
        }

        .order-summary ul li span {
            font-weight: bold;
        }

        /* Customer support section */
        .customer-support {
            margin-top: 40px;
            padding: 20px;
            background: #333;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .customer-support h2 {
            margin-bottom: 15px;
            color: #f2a02f;
        }

        .customer-support p {
            margin: 0;
            color: #ddd;
        }

        .contact-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #f2a02f;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .contact-button:hover {
            background: #e08e0a;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Orders</h1>
            <p>View your placed orders below.</p>
            <a href="index.php">Home</a><span>/ Orders</span>
        </div>
    </div>
    <div class="line"></div>
    <div class="order-section">
        <!-- Order Summary -->
        <div class="order-summary">
            <h2>Order Summary</h2>
            <ul>
                <?php 
                    $select_orders = mysqli_query($conn, "SELECT COUNT(*) AS order_count, SUM(total_price) AS total_spent FROM `orders` WHERE user_id='$user_id'") or die('query failed');
                    if ($fetch_summary = mysqli_fetch_assoc($select_orders)) {
                        echo '<li>Total Orders: <span>' . $fetch_summary['order_count'] . '</span></li>';
                        echo '<li>Total Spent: <span>$' . number_format($fetch_summary['total_spent'], 2) . '</span></li>';
                    } else {
                        echo '<li>No orders found.</li>';
                    }
                ?>
            </ul>
        </div>

        <div class="box-container">
            <?php 
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id='$user_id'") or die('query failed');
                if (mysqli_num_rows($select_orders) > 0) {
                    while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
            <div class="box">
                <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
                <p>Number: <span><?php echo $fetch_orders['number']; ?></span></p>
                <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
                <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
                <p>Payment method: <span><?php echo $fetch_orders['method']; ?></span></p>
                <p>Your order: <span><?php echo $fetch_orders['total_products']; ?></span></p>
                <p>Total price: <span><?php echo $fetch_orders['total_price']; ?></span></p>
                <p>Payment status: <span><?php echo $fetch_orders['payment_status']; ?></span></p>
            </div>
            <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No orders placed yet!</p>
                        </div>
                    ';
                }
            ?>
        </div>

        <!-- Customer Support -->
        <div class="customer-support">
            <h2>Need Help?</h2>
            <p>If you have any questions or need assistance with your orders, please don't hesitate to reach out to our customer support team.</p>
            <a href="contact.php" class="contact-button">Contact Us</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>
