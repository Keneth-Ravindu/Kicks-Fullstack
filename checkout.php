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
        $cart_total=0;
        $cart_product[]='';
        $cart_query=mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($cart_query)>0) {
            while($cart_item=mysqli_fetch_assoc($cart_query)){
                $cart_product[]=$cart_item['name'].' ('.$cart_item['quantity'].')';
                $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                $cart_total+=$sub_total;
            }
        }
        $total_products = implode(', ', $cart_product);
        mysqli_query($conn, "INSERT INTO `orders`(`user_id`,`name`,`number`,`email`,`method`,`address`,`total_products`,`total_price`,`placed_on`) VALUES('$user_id','$name','$number','$email','$method','$address','$total_product','$cart_total','$placed_on')");
        mysqli_query($conn,"DELETE FROM `cart` WHERE user_id='$user_id'");
        $message[]='order placed successfully';
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
    <title>Kicks About Us</title>
</head>

<body class="dark-theme">
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>order</h1>
            <p>Make your payment easily</p>
        </div>
    </div>
    <div class="line"></div>
    <div class="checkout-form">
        <h1 class="title">payment process</h1>
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
                $select_cart=mysqli_query($conn,"SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
                $total=0;
                $grand_total=0;
                if (mysqli_num_rows($select_cart)>0) {
                    while($fetch_cart=mysqli_fetch_assoc($select_cart)){
                        $total_price=($fetch_cart['price'] * $fetch_cart['quantity']);
                        $grand_total=$total+=$total_price;
                    
                ?>
                
                    <div class="box">
                        <img src="Assets/<?php echo $fetch_cart['image'];?>">
                        <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                    </div>
                
                <?php 
                        }
                    }
                ?>
            </div>
            <span class="grand-total">Total Amount Payable : $<?= $grand_total; ?></span>
        </div>
        <form method="post">
            <div class="input-field">
                <label>your name</label>
                <input type="text" name="name" placeholder="enter your name">
            </div>
            <div class="input-field">
                <label>your number</label>
                <input type="number" name="number" placeholder="enter your number">
            </div>
            <div class="input-field">
                <label>your email</label>
                <input type="text" name="email" placeholder="enter your email">
            </div>

            <div class="input-field">
                <label>select payment method</label>
                <select name="method">
                    <option selected disabled>select payment method</option>
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="cradit card">cradit card</option>
                    <option value="paytm">paytm</option>
                    <option value="paypal">paypal</option>   
                </select>
            </div>
            <div class="input-field">
                <label>address line 1</label>
                <input type="text" name="flate" placeholder="e.g flate no.">
            </div>
            <div class="input-field">
                <label>address line 2</label>
                <input type="text" name="street" placeholder="e.g street name">
            </div>
            <div class="input-field">
                <label>city</label>
                <input type="text" name="city" placeholder="e.g  delhi">
            </div>
            <div class="input-field">
                <label>state</label>
                <input type="text" name="state" placeholder="e.g new delhi">
            </div>
            <div class="input-field">
                <label>country</label>
                <input type="text" name="country" placeholder="e.g India">
            </div>
            <div class="input-field">
                <label>pin code</label>
                <input type="text" name="pin" placeholder="e.g 110012">
            </div>
            <input type="submit" name="order_btn" class="btn" value="order now">
        </form>
    </div>
    <script>
        document.querySelector('#theme-toggle').addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
});

    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>