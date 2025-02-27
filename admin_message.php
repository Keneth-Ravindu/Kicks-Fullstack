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
		
		mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');

		header('location:admin_message.php');
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
	
	<title>admin message</title>
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
            <h1>Messages</h1>
            <p>Your messages.</p>
        </div>
    </div>
    <br><br>
    <div class="dashboard">
	<div class="line4"></div>
	<section class="message-container">
		<h1 class="title">unread message</h1>
		<div class="box-container">
			<?php 
				$select_message = mysqli_query($conn,"SELECT * FROM `message`") or die('query failed');
				if (mysqli_num_rows($select_message)>0) {
					while($fetch_message = mysqli_fetch_assoc($select_message)){


			?>
			<div class="box">
				<p>user id: <span><?php echo $fetch_message['id']; ?></span></p>
				<p>name: <span><?php echo $fetch_message['name']; ?></span></p>
				<p>email: <span><?php echo $fetch_message['email']; ?></span></p>
				<p><?php echo $fetch_message['message']; ?></p>
				<a href="admin_message.php?delete=<?php echo $fetch_message['id']; ?>;" onclick="return confirm('delete this message');" class="delete">delete</a>
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
	</section></div>
	<div class="line"></div>
	
	
</body>
</html>