<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle product addition
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    $target_dir = "images/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (name, category, description, price, stock, image)
                VALUES ('$name', '$category', '$description', '$price', '$stock', '$image_name')";
        if (mysqli_query($conn, $sql)) {

            // Redirect to category page
            $redirects = [
                "Electronics" => "electronics.php",
                "Clothing" => "clothing.php",
                "Beauty" => "beauty.php",
                "Accessories" => "accessories.php",
                "Home and Living" => "home_living.php",
                "Kids Collection" => "kids_collection.php",
                "Sports and Fitness" => "sports_fitness.php"
            ];

            $redirect_url = isset($redirects[$category]) ? $redirects[$category] : "shop.php";

            echo "<script>alert('✅ Product added successfully!'); window.location.href='$redirect_url';</script>";
        } else {
            echo "<script>alert('❌ Database Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Image upload failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>Add Product - BashiStore</title>
<style>
body{
  font-family:'Segoe UI';
  background:#f4f8ff;
  padding:50px;
}
form{
  background:white;
  width:400px;
  margin:auto;
  padding:20px;
  border-radius:10px;
  box-shadow:0 0 10px rgba(0,0,0,0.1);
}
input,textarea,select{
  width:100%;
  padding:8px;
  margin-bottom:15px;
  border:1px solid #ccc;
  border-radius:5px;
}
button{
  background:#003366;
  color:white;
  padding:10px;
  width:100%;
  border:none;
  border-radius:5px;
  cursor:pointer;
}
button:hover{
  background:#00509e;
}

/* 📱 Responsive Media Queries */
@media (max-width: 768px) {
  body {
    padding: 20px;
  }
  form {
    width: 90%;
    padding: 15px;
  }
}

@media (max-width: 480px) {
  form {
    width: 100%;
    padding: 10px;
  }
}
</style>
</head>
<body>
<h2 style="text-align:center;color:#003366;">➕ Add Product</h2>
<form action="" method="POST" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Product Name" required>
  
  <select name="category" required>
    <option value="">-- Select Category --</option>
    <option value="Electronics">Electronics</option>
    <option value="Clothing">Clothing</option>
    <option value="Beauty">Beauty</option>
    <option value="Accessories">Accessories</option>
    <option value="Home and Living">Home and Living</option>
    <option value="Kids Collection">Kids Collection</option>
    <option value="Sports and Fitness">Sports and Fitness</option>
  </select>

  <textarea name="description" placeholder="Description" rows="3" required></textarea>
  <input type="number" name="price" placeholder="Price (Rs)" required>
  <input type="number" name="stock" placeholder="Stock Quantity" required>
  <input type="file" name="image" accept="image/*" required>
  <button type="submit" name="add_product">Add Product</button>
</form>
</body>
</html>
