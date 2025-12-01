<?php
session_start();

// 🧠 Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize Cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ Add to Cart Logic
if (isset($_GET['action']) && $_GET['action'] == "add" && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id LIMIT 1");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }

    // Redirect with JS alert
    echo "<script>
        alert('Product added to cart!');
        window.location.href='cart.php';
    </script>";
    exit();
}

// ✅ Search Query
$search = "";
if (isset($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']);
    $query = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Products</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; }
    .product {
      display: inline-block; width: 250px; background: white;
      margin: 10px; padding: 10px; border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-align: center;
    }
    .product img { width: 100%; height: 180px; object-fit: cover; border-radius: 8px; }
    .btn { background: #007bff; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px; }
    .btn:hover { background: #0056b3; }

    /* ===== Media Queries for Responsiveness ===== */
    @media (max-width: 768px) {
      .product {
        width: 45%;
        margin: 10px 2.5%;
      }
      .product img {
        height: 150px;
      }
      .btn {
        padding: 6px 10px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .product {
        width: 100%;
        margin: 10px 0;
      }
      .product img {
        height: 120px;
      }
      .btn {
        padding: 5px 8px;
        font-size: 13px;
      }
    }

    h2 {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h2>Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>
  <?php
  if (isset($result) && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo "<div class='product'>
                  <img src='images/{$row['image']}' alt='{$row['name']}'>
                  <h3>{$row['name']}</h3>
                  <p>Rs {$row['price']}</p>
                  <a href='search.php?action=add&id={$row['id']}' class='btn'>Add to Cart</a>
                </div>";
      }
  } else {
      echo "<p style='text-align:center;'>No products found.</p>";
  }
  ?>
</body>
</html>
