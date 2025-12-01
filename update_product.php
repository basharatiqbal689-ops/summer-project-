<?php
// 🧠 Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 🧠 Get Product by ID
if (!isset($_GET['id'])) {
    die("Product ID missing!");
}
$id = intval($_GET['id']);
$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found!");
}

// 🧠 Update Process
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    $sql = "UPDATE products SET 
            name='$name', 
            category='$category', 
            description='$description', 
            price='$price', 
            stock='$stock' 
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('✅ Product updated successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('❌ Update failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Update Product - BashiStore</title>
  <style>
    body { font-family:'Segoe UI'; background:#f4f8ff; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
    form { background:white; padding:30px; width:400px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
    input, textarea { width:100%; margin-bottom:12px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:16px; }
    button { background:#007bff; color:white; padding:10px; border:none; border-radius:5px; width:100%; cursor:pointer; font-size:16px; }
    button:hover { background:#0056b3; }

    /* ===== Media Queries ===== */
    @media (max-width: 768px) {
      form { width: 80%; padding: 20px; }
      input, textarea { font-size: 15px; padding:7px; }
      button { font-size: 15px; padding:9px; }
    }

    @media (max-width: 480px) {
      form { width: 95%; padding: 15px; }
      input, textarea { font-size: 14px; padding:6px; }
      button { font-size: 14px; padding:8px; }
      h2 { font-size: 20px; }
    }
  </style>
</head>
<body>

  <form method="POST">
    <h2 style="text-align:center;color:#003366;">✏️ Update Product</h2>

    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
    <input type="text" name="category" value="<?php echo $product['category']; ?>" required>
    <textarea name="description" rows="3" required><?php echo $product['description']; ?></textarea>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
    <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

    <button type="submit" name="update_product">Update Product</button>
  </form>

</body>
</html>
