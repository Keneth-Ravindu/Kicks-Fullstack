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
    //adding product in wishlist
    if (isset($_POST['add_to_wishlist'])) {
    	$product_id = $_POST['product_id'];
    	$product_name = $_POST['product_name'];
    	$product_price = $_POST['product_price'];
    	$product_image = $_POST['product_image'];

    	$wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
    	$cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
    	if (mysqli_num_rows($wishlist_number)>0) {
    		$message[]='product already exist in wishlist';
    	}else if (mysqli_num_rows($cart_num)>0) {
    		$message[]='product already exist in cart';
    	}else{
    		mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`,`price`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_image')");
    		$message[]='product successfuly added in your wishlist';
    	}
    }

     //adding product in cart
    if (isset($_POST['add_to_cart'])) {
    	$product_id = $_POST['product_id'];
    	$product_name = $_POST['product_name'];
    	$product_price = $_POST['product_price'];
    	$product_image = $_POST['product_image'];
    	$product_quantity = $_POST['product_quantity'];

    	$cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
    	if (mysqli_num_rows($cart_num)>0) {
    		$message[]='product already exist in cart';
    	}else{
    		mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
    		$message[]='product successfuly added in your cart';
    	}
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Index Page</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section id="video-section">
        <div class="video-container">
            <video class="bg-video left-video" autoplay muted loop>
                <source src="Assets/nikemen.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <video class="bg-video right-video" autoplay muted loop>
                <source src="Assets/nikewomen.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="video-paragraph left-paragraph">
                <p>Explore the latest men's collection, designed for performance and style. Our range includes everything from running shoes to casual wear, ensuring you look and feel your best.</p>
            </div>
            <div class="video-paragraph right-paragraph">
                <p>Discover our women's collection, tailored for comfort and elegance. Whether you're hitting the gym or running errands, our apparel and accessories offer the perfect fit for your lifestyle.</p>
            </div>
    </section>

    
    

    
</body>
</html>