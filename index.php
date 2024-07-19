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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <title>Index Page</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <section id="video-section">
        <div class="video-container">
            <div class="bg-video left-video">
                <video autoplay muted loop>
                    <source src="Assets/nikemen.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="video-overlay"></div>
            </div>
            <div class="bg-video right-video">
                <video autoplay muted loop>
                    <source src="Assets/womenadidas.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="video-overlay"></div>
            </div>
        </div>

        <div class="video-paragraph left-paragraph">
            <p>Explore the latest men's collection, designed for performance and style. Our range includes everything from running shoes to casual wear, ensuring you look and feel your best.</p>
            <br><br>
            <form action="men.php">
                <button class="btngs">Get Started</button>
            </form>
        </div>

        <div class="video-paragraph right-paragraph">
            <p>Discover our women's collection, tailored for comfort and elegance. Whether you're hitting the gym or running errands, our apparel and accessories offer the perfect fit for your lifestyle.</p>
            <br><br>
            <form action="women.php">
                <button class="btngs">Get Started</button>
            </form>
        </div>
    </section>

    <div class="banner1">
    <h1 class="hover-effect">Choose your ESSENTIALS</h1>
    </div>
    <div class="featured-products">
    <h2>Featured Products</h2>
    <div class="product-grid">
        <!-- Product 1 -->
        <div class="product-item">
            <div class="product-image">
                <img src="Assets/lebronxxi.jpg" alt="Product 1">
                <div class="hover-info">
                    <a href="product1.php" class="btn">View Details</a>
                </div>
            </div>
            <div class="product-info">
                <h3>Running Shoes</h3>
                <p>$120.00</p>
            </div>
        </div>
        <!-- Product 2 -->
        <div class="product-item">
            <div class="product-image">
                <img src="Assets/jordanhydro4retro.jpg" alt="Product 2">
                <div class="hover-info">
                    <a href="product2.php" class="btn">View Details</a>
                </div>
            </div>
            <div class="product-info">
                <h3>Basketball Shoes</h3>
                <p>$150.00</p>
            </div>
        </div>
        <!-- Product 3 -->
        <div class="product-item">
            <div class="product-image">
                <img src="Assets/kd17sunrise.jpg" alt="Product 3">
                <div class="hover-info">
                    <a href="product3.php" class="btn">View Details</a>
                </div>
            </div>
            <div class="product-info">
                <h3>Casual Sneakers</h3>
                <p>$90.00</p>
            </div>
        </div>
        <!-- Product 4 -->
        <div class="product-item">
            <div class="product-image">
                <img src="Assets/forumlowclshoes.jpg" alt="Product 3">
                <div class="hover-info">
                    <a href="product3.php" class="btn">View Details</a>
                </div>
            </div>
            <div class="product-info">
                <h3>Casual Sneakers</h3>
                <p>$90.00</p>
            </div>
        </div>
        <!-- Product5 -->
        <div class="product-item">
            <div class="product-image">
                <img src="Assets/airjordan4retrooxidizedgreen.jpg" alt="Product 3">
                <div class="hover-info">
                    <a href="product3.php" class="btn">View Details</a>
                </div>
            </div>
            <div class="product-info">
                <h3>Casual Sneakers</h3>
                <p>$90.00</p>
            </div>
        </div>
    </div>
</div>

<div class="customer-reviews">
    <h2>What Our Customers Are Saying</h2>
    <div class="review">
        <p>"I absolutely love these running shoes! They’re comfortable and perfect for my morning jogs." - Alex</p>
    </div>
    <div class="review">
        <p>"The basketball shoes are great. Perfect fit and fantastic grip on the court." - Jamie</p>
    </div>
    <div class="review">
        <p>"Amazing quality and stylish design. Will definitely recommend to friends." - Morgan</p>
    </div>
</div>

<div class="promotions">
    <h2>Special Promotions</h2>
    <p>Get 20% off on your first purchase! Use code <strong>Kicks2024</strong> at checkout.</p><br>
    <a href="shop.php" class="btn-2">Shop Now</a>
</div>
    

    
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
