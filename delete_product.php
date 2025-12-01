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

// ✅ Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('⚠️ Product ID missing!'); window.location.href='manage_products.php';</script>";
    exit();
}

$id = intval($_GET['id']);

// ✅ Fetch product details
$checkQuery = "SELECT * FROM products WHERE id = $id";
$checkResult = mysqli_query($conn, $checkQuery);
$product = mysqli_fetch_assoc($checkResult);

if (!$product) {
    echo "<script>alert('❌ Product not found!'); window.location.href='manage_products.php';</script>";
    exit();
}

// ✅ Confirm deletion
if (isset($_POST['confirm_delete'])) {
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    echo "<script>alert('🗑️ Product deleted successfully!'); window.location.href='manage_products.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>Delete Product - BashiStore</title>
<style>
body {
  font-family: 'Segoe UI', sans-serif;
  background: #fff5f5;
  text-align: center;
  padding: 80px;
}
.container {
  display: inline-block;
  background: white;
  padding: 30px 40px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
h2 {
  color: #dc3545;
}
p {
  font-size: 16px;
}
button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: 5px;
  font-weight: bold;
}
.delete {
  background: #dc3545;
  color: white;
}
.cancel {
  background: #6c757d;
  color: white;
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 5px;
}
.delete:hover { background: #c82333; }
.cancel:hover { background: #5a6268; }

/* =====================
   ✅ Responsive Design
   ===================== */

/* 📱 Mobile Devices (up to 600px) */
@media (max-width: 600px) {
  body {
    padding: 20px;
  }
  .container {
    width: 90%;
    padding: 20px;
  }
  h2 {
    font-size: 20px;
  }
  p {
    font-size: 14px;
  }
  button, .cancel {
    width: 100%;
    display: block;
    margin: 10px 0;
    font-size: 15px;
  }
}

/* 📲 Tablets (601px to 900px) */
@media (min-width: 601px) and (max-width: 900px) {
  body {
    padding: 40px;
  }
  .container {
    width: 70%;
  }
  button, .cancel {
    padding: 10px 18px;
    font-size: 15px;
  }
}

/* 💻 Desktops (above 900px) */
@media (min-width: 901px) {
  .container {
    width: auto;
  }
}
</style>
</head>
<body>

<div class="container">
  <h2>⚠️ Confirm Deletion</h2>
  <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($product['name']); ?></strong>?</p>

  <form method="POST">
    <button type="submit" name="confirm_delete" class="delete">🗑️ Yes, Delete</button>
    <a href="manage_products.php" class="cancel">Cancel</a>
  </form>
</div>

</body>
</html>
