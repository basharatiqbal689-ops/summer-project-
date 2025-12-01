<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['product_id']) && isset($_POST['rating'])) {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];

    // Insert rating into table
    mysqli_query($conn, "INSERT INTO product_ratings (product_id, rating) VALUES ('$product_id', '$rating')");
    echo "success";
}
?>
