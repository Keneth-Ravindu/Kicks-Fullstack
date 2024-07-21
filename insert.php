<?php
include 'connection.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$stmt = $conn->prepare("INSERT INTO `products` (`id`, `name`, `price`, `product_detail`, `image`) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isiss", $id, $name, $price, $product_detail, $image);

// Example data
$id = 2;
$name = 'Air Jordan1 Mid';
$price = 200;
$product_detail = 'Air Jordan1 Mid';
$image = 'Assets/airjordan1mid.jpg';
$stmt->execute();

$id = 3;
$name = 'Air jordan4 retro oxidized green';
$price = 200;
$product_detail = 'Air jordan4 retro oxidized green';
$image = 'Assets/airjordan4retrooxidizedgreen.jpg';
$stmt->execute();

echo 'Inserted';

$stmt->close();
$conn->close();
?>
