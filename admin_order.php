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
	

	//delete products from database
	if (isset($_GET['delete'])) {
		$delete_id = $_GET['delete'];
		
		mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
		$message[]='user removed successfuly';
		header('location:admin_order.php');
	}

	//updating payment status

	if (isset($_POST['update_order'])) {
		$order_id = $_POST['order_id'];
		$update_payment = $_POST['update_payment'];

		mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id='$order_id'") or die('query failed');

	}
	
?>

<style type="text/css">

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

.box-container{
		padding: 2% 8%;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(15rem,1fr));
		column-gap: 1rem;
	}
	.box-container .box{
		background: #fff;
		box-shadow: var(--box-shadow);
		padding: 2rem;
		text-align: center;
		border-radius: 5px;
		margin: 1rem;
	}
	.dashboard h3{
		text-align: center;
		font-size: 2rem;
	}
	.dashboard p{
		font-size: 20px;
		text-transform: capitalize;
		margin: .5rem 0;
	}

	
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order</title>
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
            <h1>Orders</h1>
            <p>Manage store orders.</p>
        </div>
    </div>
    <br><br>
    <div class="dashboard">

    <section class="order-container">
		<h1 class="title">total order placed</h1>
		<div class="box-container">
			<?php 
				$select_orders = mysqli_query($conn,"SELECT * FROM `orders`") or die('query failed');
				if (mysqli_num_rows($select_orders)>0) {
					while($fetch_orders = mysqli_fetch_assoc($select_orders)){


			?>
			<div class="box">
				<p>user name: <span><?php echo $fetch_orders['name']; ?></span></p>
				<p>user id: <span><?php echo $fetch_orders['user_id']; ?></span></p>
				<p>placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
				<p>number : <span><?php echo $fetch_orders['number']; ?></span></p>
				<p>email : <span><?php echo $fetch_orders['email']; ?></span></p>
				<p>total price : <span><?php echo $fetch_orders['total_price']; ?></span></p>
				<p>method : <span><?php echo $fetch_orders['method']; ?></span></p>
				<p>address : <span><?php echo $fetch_orders['address']; ?></span></p>
				<p>total product : <span><?php echo $fetch_orders['total_products']; ?></span></p>
				<form method="post">
					<input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
					<select name="update_payment">
						<option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
						<option value="pending">Pending</option>
						<option value="complete">complete</option>
					</select>
					<input type="submit" name="update_order" value="update payment" class="btn">
					<a href="admin_order.php?delete=<?php echo $fetch_orders['id']; ?>;" onclick="return confirm('delete this message');" class="delete">delete</a>
				</form>
				
			</div>
			<?php 
					}
				}else{
						echo '
							<div class="empty">
								<p>no order placed yet!</p>
							</div>
						';
				}		
			?>
		</div>
	</section>

    </div>

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



        
    
</body>
</html>

