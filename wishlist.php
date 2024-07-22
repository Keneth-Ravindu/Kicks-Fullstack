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

     //adding product in cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = 1;

        $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id ='$user_id'") or die('query failed');
        if (mysqli_num_rows($cart_num)>0) {
            $message[]='product already exist in cart';
        }else{
            mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
            $message[]='product successfuly added in your cart';
        }
    }
    //delete product from wishlist
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');

        header('location:wishlist.php');
    }
    //delete product from wishlist
    if (isset($_GET['delete_all'])) {

        mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');

        header('location:wishlist.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <title>Kicks Wishlist</title>
    
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>my wishlist</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
        </div>
    </div>
    <section class="shop">
        <h1 class="title">products added in wishlist</h1>
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
        <div class="box-container">
            <?php 
                $grand_total=0;
                $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id='$user_id'") or die('query failed');
                if (mysqli_num_rows($select_wishlist)>0) {
                    while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
            ?>
            <form method="post" class="box">
                <img src="Assets/<?php echo $fetch_wishlist['image']; ?>">
                <div class="price">$<?php echo $fetch_wishlist['price']; ?>/-</div>
                <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
                <div class="icon">
                    <a href="view_page.php?pid=<?php echo $fetch_wishlist['id']; ?>" class="bi bi-eye-fill"></a>
                    <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="bi bi-x" onclick="return confirm('do you want to delete this product from your wishlist')"></a>
                    <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                </div>
            </form>
            <?php 
                    $grand_total+=$fetch_wishlist['price'];
                    }
                } else {
                    echo '<p class="empty">no products added yet!</p>';
                }
            ?>
        </div>
        <div class="wishlist_total">
            <p>total amount payable : <span>$<?php echo $grand_total; ?>/-</span></p>
            <br>
            <a href="shop.php" class="btn">continue shopping</a>
            <a href="wishlist.php?delete_all" class="btn delete_all <?php echo ($grand_total) ? '' : 'disabled' ?>" onclick="return confirm('do you want to delete all items in your wishlist')">delete all</a>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
    // Example: Handle confirmation before deleting all items from wishlist
    const deleteAllButton = document.querySelector('.wishlist_total .btn.delete_all');
    if (deleteAllButton) {
        deleteAllButton.addEventListener('click', (e) => {
            if (!confirm('Do you want to delete all items in your wishlist?')) {
                e.preventDefault();
            }
        });
    }
});

    </script>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>