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
		
		mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
		$message[]='user removed successfuly';
		header('location:admin_user.php');
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
	<!--box icon link-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="style2.css">
	<title>admin user pannel</title>
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

<div class="banner">
        <div class="detail">
            <h1>Messages</h1>
            <p>Your messages.</p>
        </div>
    </div>
    <br><br>
	<div class="line4"></div>
    <div class="dashboard">
	<section class="message-container">
		<h1 class="title">total user account</h1>
		<div class="box-container">
			<?php 
				$select_users = mysqli_query($conn,"SELECT * FROM `users`") or die('query failed');
				if (mysqli_num_rows($select_users)>0) {
					while($fetch_users = mysqli_fetch_assoc($select_users)){


			?>
			<div class="box">
				<p>user id: <span><?php echo $fetch_users['id']; ?></span></p>
				<p>name: <span><?php echo $fetch_users['name']; ?></span></p>
				<p>email: <span><?php echo $fetch_users['email']; ?></span></p>
				<p>user type : <span style="color:<?php if($fetch_users['user_type']=='admin'){echo 'orange';}; ?>"><?php echo $fetch_users['user_type']; ?></span></p>
				<a href="admin_user.php?delete=<?php echo $fetch_users['id']; ?>;" onclick="return confirm('delete this message');" class="delete">delete</a>
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
	</section>
	<div class="line"></div></div>

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