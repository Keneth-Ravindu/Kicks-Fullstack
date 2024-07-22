<?php 
    include 'connection.php';
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_email'])) {
        header('location:login.php');
        exit();
    }

    $email = $_SESSION['user_email'];
    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');
    $user = mysqli_fetch_assoc($select_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <title>User Profile</title>

</head>
<body>
    <?php include 'header.php'; ?>

    <div class="profile-container">
        <h1>User Profile</h1>
        <img src="Assets/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Picture">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p><br>
    </div>

    
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
