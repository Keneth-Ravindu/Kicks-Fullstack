<?php 
	include 'connection.php';

	if (isset($_POST['submit-btn'])) {
		$filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$name = mysqli_real_escape_string($conn, $filter_name);

		$filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$email = mysqli_real_escape_string($conn, $filter_email);

		$filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		$password = mysqli_real_escape_string($conn, $filter_password);

		$filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
		$cpassword = mysqli_real_escape_string($conn, $filter_cpassword);

		$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

		if (mysqli_num_rows($select_user)>0) {
			$message[] = 'user already exist';
		}else{
			if ($password != $cpassword) {
				$message[] = 'wrong password';
			}else{
				mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$password')") or die('query failed');
				$message[] = 'registered successfully';
				header('location:login.php');
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--box icon line-->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Register Page</title>
</head>
<body>
    
    
    <video autoplay muted loop id="background-video">
        <source src="Assets/mendemo.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <section class="form-container">

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

        <form method="post">
            <h1>Register Now</h1>
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="password" name="cpassword" placeholder="Confirm your password" required>
            <input type="submit" name="submit-btn" value="Register Now" class="btn">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </section>
</body>
</html>