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
    --box-shadow: 0px 0px 0px 6px;
    --black: #000000;
    --color1: #244855;
    --color2: #E64833;
    --color3: #874f41;
    --color4: #90aead;
    --color5: #fbe9d0;
    --hover-color: #E64833;
    --hover-shadow: rgba(230, 72, 51, 0.4);
}

.dashboard{
    background: var(--color1);
    padding: 7rem;
    margin-top: -3.5rem;
    position: relative;
}

.dashboard::before{
    position: absolute;
    content: '';
    top: -25%;
    left: -10px;
    width: 225px;
    height: 220px;
    background-size: 225px;
    background-repeat: no-repeat;
    z-index: 100;
}

.box-container{
    padding: 2% 8%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
    column-gap: 1rem;
}

.box-container .box{
    background: var(--color5);
    box-shadow: var(--box-shadow);
    padding: 2rem;
    text-align: center;
    border-radius: 5px;
    margin: 1rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}

.box-container .box:hover{
    transform: scale(1.2);
    background-color: #fde8d9;
    box-shadow: 0px 10px 20px var(--box-shadow);
}

.dashboard h3{
    text-align: center;
    font-size: 2rem;
}

.dashboard p{
    font-size: 20px;
    text-transform: capitalize;
    margin: 0.5rem 0;
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

/* Line divider styling */
.line {
    height: 2px;
    background-color: var(--color1);
    margin: 20px 0;
}



    </style>
	<title>admin pannel</title>
</head>
<body>

	<?php include 'admin_header.php'; ?>

    <div class="banner">
        <div class="detail">
            <h1>Admin Dashboard</h1>
            <p>Welcome Admin!</p>
        </div>
    </div>
    
    <script type="text/javascript" src="script2.js"></script>
	<div class="line4"></div>
	<section class="dashboard">
		<div class="box-container">
			<div class="box">
				<?php 
					$total_pendings = 0;
					$select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
					while ($fetch_pending = mysqli_fetch_assoc($select_pendings)) {
						$total_pendings += $fetch_pending['total_price'];
					}
				?>
				<h3>$ <?php echo $total_pendings; ?>/-</h3>
				<p>total pendings</p>
			</div>
			<div class="box">
				<?php 
					$total_completes = 0;
					$select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'complete'") or die('query failed');
					while ($fetch_completes = mysqli_fetch_assoc($select_completes)) {
						$total_completes += $fetch_completes['total_price'];
					}
				?>
				<h3>$ <?php echo $total_completes; ?>/-</h3>
				<p>total completes</p>
			</div>
			<div class="box">
				<?php 
					$select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
					$num_of_orders = mysqli_num_rows($select_orders);
				?>
				<h3><?php echo $num_of_orders; ?></h3>
				<p>order placed</p>
			</div>
			<div class="box">
				<?php 
					$select_products = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
					$num_of_products = mysqli_num_rows($select_products);
				?>
				<h3><?php echo $num_of_products; ?></h3>
				<p>product added</p>
			</div>
			<div class="box">
				<?php 
					$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
					$num_of_users = mysqli_num_rows($select_users);
				?>
				<h3><?php echo $num_of_users; ?></h3>
				<p>total normal users</p>
			</div>
			<div class="box">
				<?php 
					$select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
					$num_of_admin = mysqli_num_rows($select_admins);
				?>
				<h3><?php echo $num_of_admin; ?></h3>
				<p>total admin</p>
			</div>
			<div class="box">
				<?php 
					$select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
					$num_of_users = mysqli_num_rows($select_users);
				?>
				<h3><?php echo $num_of_users; ?></h3>
				<p>total registered users</p>
			</div>
			<div class="box">
				<?php 
					$select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
					$num_of_message = mysqli_num_rows($select_message);
				?>
				<h3><?php echo $num_of_message; ?></h3>
				<p>new messages</p>
			</div>
		</div>
	</section>
	<div class="line4"></div>
	
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