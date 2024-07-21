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
    <!------------------------bootstrap icon link------------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="main.css">
    <title>Kicks Wishlist</title>
    <style>
        /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.banner {
    background: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
}

.detail h1 {
    margin: 0;
    font-size: 2em;
}

.detail p {
    font-size: 1.2em;
}

.detail a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.detail span {
    color: #bbb;
}

/* Wishlist Section */
.shop {
    padding: 20px;
    background-color: #fff;
}

.title {
    text-align: center;
    font-size: 2em;
    margin-bottom: 20px;
}

.box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.box {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    width: 250px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.box:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.box img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.price {
    font-size: 1.5em;
    font-weight: bold;
    margin: 10px;
}

.name {
    padding: 10px;
    font-size: 1.2em;
}

.icon {
    text-align: center;
    padding: 10px;
}

.icon a {
    font-size: 1.5em;
    margin: 0 10px;
    color: #333;
    text-decoration: none;
}

.icon a:hover {
    color: #007bff;
}

.icon button {
    font-size: 1.5em;
    background: none;
    border: none;
    cursor: pointer;
    color: #007bff;
}

.icon button:hover {
    color: #0056b3;
}

/* Wishlist Total */
.wishlist_total {
    text-align: center;
    padding: 20px;
    background-color: #fff;
    border-top: 1px solid #ddd;
}

.wishlist_total p {
    font-size: 1.5em;
    font-weight: bold;
}

.wishlist_total .btn {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 1em;
    margin: 10px;
    display: inline-block;
}

.wishlist_total .btn:hover {
    background: #0056b3;
}

.wishlist_total .btn.disabled {
    background: #ccc;
    cursor: not-allowed;
}

    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>my wishlist</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
            <a href="index.php">home</a><span>/ wishlist</span>
        </div>
    </div>
    <div class="line"></div>
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
    <script type="text/javascript" src="script.js"></script>
</body>
</html>