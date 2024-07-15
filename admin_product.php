<?php 

	include 'connection.php';
	session_start();
	$admin_id = $_SESSION['admin_name'];

	if (!isset($admin_id)) {
		header('location:login.php');
	}

	if (isset($_POST['logout'])) {
		session_destroy();
		header('location:login.php');	
	}
	//adding products to database
	if (isset($_POST['add_product'])) {
		$product_name = mysqli_real_escape_string($conn, $_POST['name']);
		$product_price = mysqli_real_escape_string($conn, $_POST['price']);
		$product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
		$image = $_FILES['image']['name'];
		$image_size = $_FILES['image']['size'];
		$image_tmp_name = $_FILES['image']['tmp_name'];
		$image_folder = 'image/'.$image;

		$select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$product_name'") or die('query failed');
		if(mysqli_num_rows($select_product_name)>0){
			$message[] = 'Product Name Already Exist';
		}else{
			$insert_product = mysqli_query($conn, "INSERT INTO `products`(`name`, `price`, `product_detail`, `image`) VALUES ('$product_name','$product_price','$product_detail','$image')") or die('query failed');
			if ($insert_product) {
				if ($image_size > 2000000) {
					$message[] = 'Image Size Is Too Large';
				}else{
					move_uploaded_file($image_tmp_name, $image_folder);
					$message[] = 'Product Added Successfully';
				}
			}
		}
	}

	//delete products from database
	if (isset($_GET['delete'])) {
		$delete_id = $_GET['delete'];
		$select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
		$fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
		unlink('image/'.$fetch_delete_image['image']);

		mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
		mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
		mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

		header('location:admin_product.php');
	}

	//update product
	if (isset($_POST['updte_product'])) {
		$update_id = $_POST['update_id'];
		$update_name = $_POST['update_name'];
		$update_price = $_POST['update_price'];
		$update_detail = $_POST['update_detail'];
		$update_image = $_FILES['update_image']['name'];
		$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
		$update_image_folder='image/'.$update_image;

		$update_query = mysqli_query($conn, "UPDATE `products` SET `id`='$update_id',`name`='$update_name',`price`='$update_price',`product_detail`='$update_detail',`image`='$update_image' WHERE id = '$update_id'") or die('query failed');
		if($update_query){
			move_uploaded_file($update_image_tmp_name,$update_image_folder);
			header('location:admin_product.php');
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--box icon link-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style2.css">
	<style>

:root{
   
    --thin-border: 1px solid #ccc;
    --hover-border: 2px solid #90aead;
    --black: #000000;
    --color1: #244855;
    --color2: #E64833;
    --color3: #874f41;
    --color4: #90aead;
    --color5: #fbe9d0;
    --hover-color: #E64833;
    --hover-shadow: rgba(230, 72, 51, 0.4);
}

/* Banner styling */
.banner {
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--black);
    color: rgb(255, 255, 255);
    text-align: center;
    font-family: 'Apple Chancery', monospace;
    position: relative;
    overflow: hidden;
}

.banner .detail {
    position: relative;
    z-index: 2;
    text-align: center;
}

.banner .detail h1 {
    font-size: 48px;
    margin-bottom: 10px;
    text-transform: capitalize;
    font-family: 'Apple Chancery', monospace;
}

.banner .detail p {
    font-size: 18px;
}

.dashboard{
    background: var(--color1);
    padding: 7rem;
    margin-top: -3.5rem;
    position: relative;
}



/* Line divider styling */
.line {
    height: 5px;
    width: 100%;
    background-color: var(--color2);
    margin: 20px 0;
}


/* Add product section styling */
.add-products .input-field label {
    text-transform: capitalize;
}

.add-products {
    width: 50%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: #000000;
    background-color: #f9f9f9; /* Light grey background */
    box-shadow: 0 4px 8px var(--color2);
}

.add-products .input-field {
    margin-bottom: 15px;
}

.add-products .input-field label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    text-transform: capitalize;
}

.add-products .input-field input[type="text"],
.add-products .input-field textarea,
.add-products .input-field input[type="file"] {
    width: 100%;
    padding: 10px;
    border: var(--thin-border);
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.add-products .input-field input[type="text"]:hover,
.add-products .input-field textarea:hover,
.add-products .input-field input[type="file"]:hover {
    border: var(--hover-border);
}

.add-products .input-field textarea {
    resize: vertical;
    height: 100px;
}

.add-products .btn {
    display: block;
    margin: 0 auto;
    text-transform: capitalize;
    padding: 10px 20px;
    background-color: var(--color1);
    color: #fff;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
}

.add-products .btn:hover {
    background-color: var(--hover-color);
    box-shadow: 0 4px 15px var(--hover-shadow);
    transform: scale(1.05);
}

/* Box container styling */
.box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 50px;
    max-width: 1200px;
    margin: 20px auto;
    justify-content: center;
}

.box {
    background: #fff;
    padding: 20px;
    border-radius: 2px;
    box-shadow: var(--box-shadow);
    text-align: center;
    max-width: 200px;
    flex: 1;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px var(--hover-shadow);
}

.box img {
    max-width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

.box h4 {
    font-size: 1.5rem;
    color: var(--color1);
    margin-bottom: 10px;
}

.box p {
    font-size: 1.2rem;
    color: var(--color3);
    margin-bottom: 15px;
}

.box details {
    font-size: 1rem;
    color: var(--color4);
    margin-bottom: 15px;
}

.edit,
.delete {
    display: inline-block;
    padding: 10px 10px;
    margin: 5px;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    text-transform: capitalize;
}

.edit {
    background: var(--color4);
}

.edit:hover {
    background: var(--color1);
    box-shadow: 0 4px 15px var(--hover-shadow);
    transform: scale(1.05);
}

.delete {
    background: var(--color2);
}

.delete:hover {
    background: var(--hover-color);
    box-shadow: 0 4px 15px var(--hover-shadow);
    transform: scale(1.05);
}

/* Update container styling */
.update-container {
    display: none;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: #000000;
    background-color: #f9f9f9; /* Light grey background */
    
}

.update-container form {
    display: flex;
    flex-direction: column;
}

.update-container img {
    max-width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

.update-container input,
.update-container textarea {
    margin-bottom: 15px;
    padding: 10px;
    border: var(--thin-border);
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.update-container input[type="file"] {
    padding: 3px;
}

.update-container input:hover,
.update-container textarea:hover,
.update-container input[type="file"]:hover {
    border: var(--hover-border);
    
}

.edit,
.option-btn {
    display: inline-block;
    padding: 10px;
    margin: 5px 0;
    background: var(--color1);
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    text-transform: capitalize;
}

.edit:hover,
.option-btn:hover {
    background: var(--hover-color);
    box-shadow: 0 4px 15px var(--hover-shadow);
    transform: scale(1.05);
}

.message {
    background: var(--color2);
    color: #fff;
    padding: 10px;
    margin: 20px 0;
    text-align: center;
    border-radius: 5px;
    position: relative;
}

.message i {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}




    </style>
	<title>admin product pannel</title>
</head>
<body>


    
	<?php include 'admin_header.php'; ?>
   
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

<div class="line2"></div>
<div class="banner">
        <div class="detail">
            <h1>Products</h1>
            <p>Add or Delete products.</p>
        </div>
    </div>
    <br><br>
        
	
	
    <div class="dashboard">    
    <section class="add-products form-container">
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="input-field">
				<label>product name</label>
				<input type="text" name="name" required>
			</div>
			<div class="input-field">
				<label>product price</label>
				<input type="text" name="price" required>
			</div>
			<div class="input-field">
				<label>product detail</label>
				<textarea name="detail" required></textarea>
			</div>
			<div class="input-field">
				<label>product image</label>
				<input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
			</div>
			<input type="submit" name="add_product" value="add product" class="btn">
		</form>
	</section><br><br>
	<div class="line3"></div>
	<div class="line4"></div>
	<section class="show-products">
		<div class="box-container">
			<?php 
				$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
				if (mysqli_num_rows($select_products)>0) {
					while($fetch_products = mysqli_fetch_assoc($select_products)){

			?>
			<div class="box">
				<img src="Assets/<?php echo $fetch_products['image']; ?>">
				<p>Price : $<?php echo $fetch_products['price']; ?> </p>
				<h4><?php echo $fetch_products['name']; ?></h4>
				<details><?php echo $fetch_products['product_detail']; ?></details>
				<a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">edit</a>
				<a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm('want to delete this product');">delete</a>
			</div>
			<?php 
					}
				}else{
						echo '
							<div class="empty">
								<p>no products added yet!</p>
							</div>
						';
				}
			?>
			
		</div>
	</section><br>
	<div class="line"></div><br>
	<section class="update-container">
		<?php 
			if (isset($_GET['edit'])) {
				$edit_id = $_GET['edit'];
				$edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$edit_id'") or die('query failed');
				if (mysqli_num_rows($edit_query)>0) {
					while($fetch_edit = mysqli_fetch_assoc($edit_query)){


				
		?>
		<form method="POST" enctype="multipart/form-data">
			<img src="Assets/<?php echo $fetch_edit['image']; ?>">
			<input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
			<input type="text" name="update_name" value="<?php echo $fetch_edit['name']; ?>">
			<input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price']; ?>">
			<textarea name="update_detail"><?php echo $fetch_edit['product_detail']; ?></textarea>
			<input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp">
			<input type="submit" name="update_product" value="update" class="edit">
			<input type="reset" name="" value="cancel" class="option-btn btn" id="close-form">
		</form>
		<?php 
					}
				}
				echo "<script>document.querySelector('.update-container').style.display='block'</script>";
			}
		?>
	</section>
	<script type="text/javascript" src="script.js"></script>
	<script type="text/javascript">
		const closeBtn = document.querySelector('#close-form');

closeBtn.addEventListener('click',()=>{
    document.querySelector('.update-container').style.display='none'
})
	</script></div>

<button class="go-to-top hidden" id="goToTopBtn">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script>
        // Show or hide the go to top button
        window.onscroll = function() {
            const goToTopBtn = document.getElementById('goToTopBtn');
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                goToTopBtn.classList.remove('hidden');
            } else {
                goToTopBtn.classList.add('hidden');
            }
        };

        // Scroll to top smoothly
        document.getElementById('goToTopBtn').onclick = function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
    </script>

    





    
    
    <script src="script.js"></script>
    </body>
</html>
	