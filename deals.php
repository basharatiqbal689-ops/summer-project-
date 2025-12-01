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

// Fetch deals from database
$sql = "SELECT * FROM deals";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <meta charset="UTF-8">
  <title>Deals -  BashiStore.pk</title>
  <style>
    body { font-family: Arial; margin: 0; padding: 0; background: #f8f9fa; }
    nav { background: #003366; padding: 15px; text-align: center; }
    nav a { color: white; margin: 0 15px; text-decoration: none; font-weight: bold; }
    nav a:hover { text-decoration: underline; }

    .deals-container { padding: 30px; text-align: center; }
    .deal-box {
      background: white;
      border-radius: 10px;
      width: 250px;
      display: inline-block;
      margin: 15px;
      padding: 15px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      vertical-align: top;
    }
    .deal-box:hover { transform: scale(1.05); }
    .deal-box img {
      width: 100%;
      height: 200px;
      border-radius: 10px;
      object-fit: cover;
    }
    .deal-box h3 { color: #333; margin: 10px 0 5px; }
    .deal-box p { color: #777; margin: 5px 0; }
    .deal-box .price { color: #d35400; font-weight: bold; }
    .deal-box a {
      display: inline-block;
      background: #ff6600;
      color: white;
      padding: 8px 12px;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 8px;
    }
    .deal-box a:hover { background: #e65c00; }

    /* =====================
       ✅ Responsive Design
       ===================== */

    /* 📱 Mobile Devices (up to 500px) */
    @media (max-width: 600px) {
      nav { padding: 10px; }
      nav a { display: block; margin: 10px 0; }
      .deals-container { padding: 15px; }
      .deal-box {
        width: 90%;
        margin: 10px auto;
        display: block;
      }
      .deal-box img {
        height: 180px;
      }
      h2 { font-size: 20px; }
    }

    /* 📲 Tablets (601px to 900px) */
    @media (min-width: 601px) and (max-width: 900px) {
      .deal-box {
        width: 45%;
        margin: 10px;
      }
      nav a { margin: 8px; font-size: 15px; }
      h2 { font-size: 22px; }
    }

    /* 💻 Desktops (above 900px) */
    @media (min-width: 901px) {
      .deal-box { width: 250px; }
    }

    @media screen and (max-width: 600px) {
  body {
    font-size: 14px;
    padding: 10px;
  }

  .container {
    width: 100%;
    padding: 10px;
  }

  nav ul {
    flex-direction: column;
    text-align: center;
  }

  nav ul li {
    display: block;
    margin: 10px 0;
  }

  .form-box {
    width: 90%;
    margin: auto;
  }

  img {
    width: 100%;
    height: auto;
  }

  h1, h2, h3 {
    font-size: 1.2em;
  }

  button {
    width: 100%;
    padding: 12px;
    font-size: 16px;
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

  <div class="deals-container">
    <h2>🔥 Hot Deals Just for You!</h2>
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $discounted_price = $row['price'] - ($row['price'] * $row['discount'] / 100);
            echo "
            <div class='deal-box'>
              <img src='./{$row['image']}' alt='{$row['name']}'>
              <h3>{$row['name']}</h3>
              <p>{$row['description']}</p>
              <p class='price'>Discount: {$row['discount']}% Off</p>
              <p><del>Rs {$row['price']}</del> → <strong>Rs " . number_format($discounted_price, 2) . "</strong></p>
              <a href='deals_detail.php?id={$row['id']}'>View Deal</a>
            </div>";
        }
    } else {
        echo "<p>No deals available right now.</p>";
    }
    mysqli_close($conn);
    ?>
  </div>
</body>
</html>
