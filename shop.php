<?php 
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if (!isset($user_id)) {
        header('location:login.php');
        exit;
    }
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
        exit;
    }

    // Adding product to wishlist
    if (isset($_POST['add_to_wishlist'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];

        $wishlist_number = mysqli_query($conn, "SELECT * FROM wishlist WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        $cart_num = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        if (mysqli_num_rows($wishlist_number) > 0) {
            $message[] = 'Product already exists in wishlist';
        } else if (mysqli_num_rows($cart_num) > 0) {
            $message[] = 'Product already exists in cart';
        } else {
            mysqli_query($conn, "INSERT INTO wishlist(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')");
            $message[] = 'Product successfully added to your wishlist';
        }
    }

    // Adding product to cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $cart_num = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        if (mysqli_num_rows($cart_num) > 0) {
            $message[] = 'Product already exists in cart';
        } else {
            mysqli_query($conn, "INSERT INTO cart(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
            $message[] = 'Product successfully added to your cart';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
</head>
<body>
   <?php include 'header.php'; ?>
   <div class="video-background">
        <video autoplay muted loop>
            <source src="assets/nikemen.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
    </div>

    <div class="banner">
        <div class="detail">
            <h1>Exclusive Selections</h1>
            <p>Upgrade your shoe game with our top-rated sports shoes.</p>
        </div>
    </div>

    
    
    <section class="shop">
        <h1 class="title">Shop Best Sellers</h1>
        
        <?php 
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '
                        <div class="message">
                            <span>'.$msg.'</span>
                            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                        </div>
                    ';
                }
            }
        ?>
        
        <div class="box-container">
            <?php 
                $select_products = mysqli_query($conn, "SELECT * FROM products") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <form method="post" class="box">
                <img src="Assets/<?php echo $fetch_products['image']; ?>" alt="<?php echo $fetch_products['name']; ?>">
                <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_quantity" value="1">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
                    <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
            <?php 
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
            ?>
        </div>
    </section>
    <br><br>            
    <section id="photo-section">
        <div class="photo-container">
            <div class="bg-photo left-photo">
                
                    <img src="Assets/new11.jpg" >
                    
                
                <div class="photo-overlay"></div>
            </div>
            <div class="bg-photo right-photo">
                
                    <img src="Assets/new9.jpg" >
                    
                
                <div class="photo-overlay"></div>
            </div>
        </div>

        <div class="photo-paragraph left-paragraph">
            <p>Explore the latest men's collection, designed for performance and style. Our range includes everything from running shoes to casual wear, ensuring you look and feel your best.</p>
            <br><br>
            <form action="men.php">
                <button class="btngs">Get Started</button>
            </form>
        </div>

        <div class="photo-paragraph right-paragraph">
            <p>Discover our women's collection, tailored for comfort and elegance. Whether you're hitting the gym or running errands, our apparel and accessories offer the perfect fit for your lifestyle.</p>
            <br><br>
            <form action="women.php">
                <button class="btngs">Get Started</button>
            </form>
        </div>
    </section>



    <script>
        document.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.parallax');
            parallax.style.transform = 'translateY(' + scrolled * 0.5 + 'px)';
        });   
    </script>

    

    
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
