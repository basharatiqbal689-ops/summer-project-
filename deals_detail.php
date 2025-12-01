<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get deal ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM deals WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $deal = mysqli_fetch_assoc($result);
} else {
    die("Deal not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title><?php echo $deal['name']; ?> - Deal Details</title>
  <style>
    body { font-family: Arial; margin: 0; padding: 0; background: #f4f4f4; }
    nav { background: #003366; padding: 15px; text-align: center; }
    nav a { color: white; margin: 0 15px; text-decoration: none; font-weight: bold; }
    nav a:hover { text-decoration: underline; }

    .deal-details {
      text-align: center;
      padding: 40px;
      background: white;
      margin: 40px auto;
      width: 60%;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .deal-details img {
      width: 300px;
      height: 300px;
      border-radius: 10px;
      object-fit: cover;
    }
    .deal-details h2 { color: #333; }
    .deal-details p { color: #666; font-size: 16px; }
    .deal-details .price {
      color: #d35400;
      font-size: 18px;
      font-weight: bold;
      margin: 10px 0;
    }
    .deal-details button {
      background: #ff6600;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 10px;
    }
    .deal-details button:hover { background: #e65c00; }

    /* 🌐 Responsive Design */
    @media (max-width: 1024px) {
      .deal-details {
        width: 80%;
        padding: 30px;
      }
      .deal-details img {
        width: 250px;
        height: 250px;
      }
      nav a {
        margin: 0 10px;
        font-size: 15px;
      }
    }

    @media (max-width: 768px) {
      .deal-details {
        width: 90%;
        padding: 25px;
      }
      .deal-details img {
        width: 220px;
        height: 220px;
      }
      nav {
        padding: 10px;
      }
      nav a {
        display: inline-block;
        margin: 5px 8px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      nav {
        padding: 8px;
      }
      nav a {
        display: block;
        margin: 6px 0;
        font-size: 13px;
      }
      .deal-details {
        width: 95%;
        margin: 20px auto;
        padding: 20px;
      }
      .deal-details img {
        width: 180px;
        height: 180px;
      }
      .deal-details p {
        font-size: 14px;
      }
      .deal-details .price {
        font-size: 16px;
      }
      .deal-details button {
        width: 100%;
        padding: 12px;
        font-size: 15px;
      }
    }
  </style>
</head>
<body>
  <nav>
    <a href="home.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="categories.php">Categories</a>
    <a href="deals.php">Deals</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
  </nav>

  <div class="deal-details">
    <img src="<?php echo $deal['image']; ?>" alt="<?php echo $deal['name']; ?>">
    <h2><?php echo $deal['name']; ?></h2>
    <p><?php echo $deal['description']; ?></p>
    <?php
      $discounted_price = $deal['price'] - ($deal['price'] * $deal['discount'] / 100);
      echo "<p class='price'><del>Rs {$deal['price']}</del> → Rs " . number_format($discounted_price, 2) . "</p>";
    ?>
    <a href="cart.php"><button>Add to Cart 🛒</button></a>
  </div>
</body>
</html>
<?php mysqli_close($conn); ?>
