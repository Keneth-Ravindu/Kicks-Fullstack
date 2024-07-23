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
    if (isset($_POST['order_btn'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $number = mysqli_real_escape_string($conn, $_POST['number']);
        $method = mysqli_real_escape_string($conn, $_POST['method']);
        $address = mysqli_real_escape_string($conn, 'flat no. '.$_POST['flate'].','.$_POST['street'].','.$_POST['city'].','.$_POST['state'].','.$_POST['country'].','.$_POST['pin']);
        $placed_on = date('d-M-Y');
        $cart_total = 0;
        $cart_product = [];
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $cart_product[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
                $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                $cart_total += $sub_total;
            }
        }
        $total_products = implode(', ', $cart_product);
        mysqli_query($conn, "INSERT INTO `orders`(`user_id`,`name`,`number`,`email`,`method`,`address`,`total_products`,`total_price`,`placed_on`) VALUES('$user_id','$name','$number','$email','$method','$address','$total_products','$cart_total','$placed_on')");
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'");
        $message[] = 'Order placed successfully';
        header('location:checkout.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <title>Kicks Checkout</title>

</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Order</h1>
            <p>Make your payment easily</p>
        </div>
    </div>
    <div class="line"></div>
    <div class="checkout-form">
        <h1 class="title">Payment Process</h1>
        <?php 
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '
                        <div class="message">
                            <span>'.$message.'</span>
                            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                        </div>
                    ';
                }
            }
        ?>
        <div class="display-order">
            <div class="box-container">
            <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
                $total = 0;
                $grand_total = 0;
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                        $grand_total = $total += $total_price;
                    
                ?>
                
                    <div class="box">
                        <img src="Assets/<?php echo $fetch_cart['image'];?>">
                        <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                    </div>
                
                <?php 
                        }
                    }
                ?>
            </div><br><br>
            <span class="grand-total"><center>Total Amount Payable : $<?= $grand_total; ?></center></span>
        </div><br><br>
        <form method="post">
            <div class="input-field">
                <label>Your Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-field">
                <label>Your Number</label>
                <input type="number" name="number" placeholder="Enter your number" required>
            </div>
            <div class="input-field">
                <label>Your Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-field">
                <label>Payment Method</label>
                <select name="method" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            <div class="input-field">
                <label>Flat No.</label>
                <input type="text" name="flate" placeholder="Flat No." required>
            </div>
            <div class="input-field">
                <label>Street</label>
                <input type="text" name="street" placeholder="Street" required>
            </div>
            <div class="input-field">
                <label>City</label>
                <input type="text" name="city" placeholder="City" required>
            </div>
            <div class="input-field">
                <label>State</label>
                <input type="text" name="state" placeholder="State" required>
            </div>
            <div class="input-field">
                <label>Country</label>
                <input type="text" name="country" placeholder="Country" required>
            </div>
            <div class="input-field">
                <label>PIN Code</label>
                <input type="text" name="pin" placeholder="PIN Code" required>
            </div>
            <button type="submit" name="order_btn" class="btn">Place Order</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>
