<?php 
	include 'connection.php';
	session_start();

	if (isset($_POST['submit-btn'])) {
		

		$filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$email = mysqli_real_escape_string($conn, $filter_email);

		$filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		$password = mysqli_real_escape_string($conn, $filter_password);

		$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

		if (mysqli_num_rows($select_user)>0) {
			$row = mysqli_fetch_assoc($select_user);
			if ($row['user_type']== 'admin') {
				$_SESSION['admin_name'] = $row['name'];
				$_SESSION['admin_email'] = $row['email'];
				$_SESSION['admin_id'] = $row['id'];
				header('location:admin_pannel.php');
			}else if($row['user_type']== 'user'){
				$_SESSION['user_name'] = $row['name'];
				$_SESSION['user_email'] = $row['email'];
				$_SESSION['user_id'] = $row['id'];
				header('location:index.php');
			}else{
				$message[] = 'incorrect email or password';
			}
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
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
	<style>
        /* General Styles */
:root{
    --box-shadow:0px 0px 0px 6px;
    --black:#000000;
    --color1:#244855;
    --color2:#E64833;
    --color3:#874f41;
    --color4:#90aead;
    --color5:#fbe9d0;
}

body {
    font-family: 'Helvetica Neue', sans-serif;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
}

#background-video {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: -1;
    filter: brightness(60%);
}

h1 {
    font-size: 2em;
    font-family: 'Apple Chancery', monospace;
    margin-bottom: 20px;
    color: #fff;
    text-align: center;
}

/* Form Container */
.form-container {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 80px;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 300px;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    text-transform: capitalize;
}


.message{
    text-align: center;
    text-transform: capitalize;
    margin: 0 auto;
    margin-bottom: 2rem;
    width: 59%;
    padding: .5rem 1.5rem;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    background: #fbe9d0;
    color: #ffffff;

}

.message i{
    cursor: pointer;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 8px;
    margin-bottom: 15px;
    border: 2px solid #ddd;
    border-radius: 5px;
    transition: border-color 0.3s, box-shadow 0.3s;
    font-size: 1em;
    width: 80%;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: var(--color2);
    box-shadow: 0 0 5px #ff6347;
    outline:#ddd;
}

.btn {
    padding: 12px;
    border: none;
    border-radius: 5px;
    background-color: var(--color3);
    color: #fff;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s, box-shadow 0.3s;
    text-transform: capitalize;
    
}

.btn:hover {
    background-color: var(--color2);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

p {
    margin-top: 20px;
    color: #ddd;
}

p a {
    color: #ff6347;
    text-decoration: none;
    transition: color 0.3s, border-bottom 0.3s;
    border-bottom: 2px solid transparent;
}

p a:hover {
    color: #ff4500;
}

/* Box Icon Styles */
.bx {
    font-size: 1.2em;
    margin-right: 8px;
    vertical-align: middle;
}

        
    </style>
	<title>Register page</title>
</head>
<body>

<video autoplay muted loop id="background-video">
        <source src="Assets/Demo.mp4">
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
			<h1>login now</h1>
			<div class="input-field">
				<br>
				<input type="email" name="email" placeholder="Enter Your Email" required>
			</div>
			<div class="input-field">
				
				<input type="password" name="password" placeholder="Enter Your Password" required>
			</div>
			<input type="submit" name="submit-btn" value="login now" class="btn">
			<p>do not have an account ? <a href="register.php">register now</a></p>
		</form>
	</section>
</body>
</html>