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

// 🧠 Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta charset="UTF-8">
  <title>Manage Products - BashiStore</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; background: #f4f8ff; padding: 30px; }
    h2 { text-align: center; color: #003366; }
    table { width: 90%; margin: 20px auto; border-collapse: collapse; background: #fff; }
    th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
    th { background: #003366; color: white; }
    img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
    a.btn { text-decoration: none; padding: 6px 10px; border-radius: 4px; color: white; }
    .update { background: #28a745; }
    .delete { background: #dc3545; }
    .add { background: #007bff; display: inline-block; margin: 15px auto; }
  </style>
</head>
<body>

  <h2>🛍️ Manage Products</h2>

  <div style="text-align:center;">
    <a href="add_product.php" class="btn add">➕ Add New Product</a>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Image</th>
      <th>Name</th>
      <th>Category</th>
      <th>Price (Rs)</th>
      <th>Stock</th>
      <th>Actions</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
              <td>{$row['id']}</td>
              <td><img src='images/{$row['image']}' alt='{$row['name']}'></td>
              <td>{$row['name']}</td>
              <td>{$row['category']}</td>
              <td>{$row['price']}</td>
              <td>{$row['stock']}</td>
              <td>
                <a href='update_product.php?id={$row['id']}' class='btn update'>✏️ Update</a>
                <a href='delete_product.php?id={$row['id']}' class='btn delete' 
                   onclick=\"return confirm('Are you sure you want to delete this product?')\">🗑️ Delete</a>
              </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No products found.</td></tr>";
    }
    ?>
  </table>

</body>
</html>
