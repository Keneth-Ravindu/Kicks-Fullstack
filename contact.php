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

        $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name= '$name' AND email='$email' AND $number = '$number' AND message= '$message'") or die('query failed');
        if (mysqli_num_rows($select_message)>0) {
            echo 'message already send';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="contact.css">
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
    <title>Kicks contact us</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>contact</h1>
        </div>
    </div>
    <div class="services">
        <div class="row">
            <div class="box">
                <img src="Assets/icon.png">
                <div>
                    <h1>Free Shipping Fast</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="box">
                <img src="Assets/icon1.png">
                <div>
                    <h1>Money Back & Guarantee</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <div class="box">
                <img src="Assets/icon2.png">
                <div>
                    <h1>Online Support 24/7</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-container">
        <h1 class="title">leave a message</h1>
        <form method="post">
            <div class="input-field">
                <label>your name</label><br>
                <input type="text" name="name">
            </div>
            <div class="input-field">
                <label>your email</label><br>
                <input type="text" name="email">
            </div>
            <div class="input-field">
                <label>your message</label><br>
                <textarea name="message"></textarea>
            </div>
            <button type="submit" name="submit-btn">send message</button>
        </form>
    </div>
    <div class="address">
        <h1 class="title">our contact</h1>
        <div class="row">
            <div class="box">
                <i class="bi bi-map-fill"></i><br><br>
                <div>
                    <h4>address</h4>
                    <p>Kicks, Kollupitiya<br> Sri Lanka</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-telephone-fill"></i><br><br>
                <div>
                    <h4>phone number</h4>
                    <p>+94761234567</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-envelope-fill"></i><br><br>
                <div>
                    <h4>email</h4>
                    <p>kicksshopcontact@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'footer.php'; ?>
    
</body>
</html>
