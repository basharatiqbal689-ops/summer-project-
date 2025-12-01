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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Agar login nahi hua, to redirect kar do
    header("Location: login.php");
    exit();
}
// Main categories page
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Categories - BashiStore.pk</title>
  <style>
    /* Reset & Body */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
      background: linear-gradient(135deg, #e0f7fa, #80deea); 
      min-height: 100vh; 
    }

    /* Navigation */
    nav { 
      background: #0d47a1; 
      padding: 15px; 
      text-align: center; 
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    nav a { 
      color: #fff; 
      margin: 0 18px; 
      text-decoration: none; 
      font-weight: bold; 
      font-size: 16px;
      transition: 0.3s;
    }
    nav a:hover { 
      color: #ffd600; 
      transform: scale(1.1);
    }

    /* Heading */
    h2 { 
      text-align: center; 
      margin: 30px 0; 
      color: #0d47a1; 
      font-size: 36px; 
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    /* Grid */
    .grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
      gap: 30px; 
      padding: 0 50px 50px; 
    }

    /* Category Card */
    .category { 
      background: #fff; 
      border-radius: 15px; 
      padding: 15px; 
      text-align: center; 
      box-shadow: 0 8px 20px rgba(0,0,0,0.15); 
      transition: transform 0.3s, box-shadow 0.3s;
      overflow: hidden;
      position: relative;
    }
    .category:hover { 
      transform: translateY(-10px) scale(1.03); 
      box-shadow: 0 12px 30px rgba(0,0,0,0.25);
    }

    /* Category Image */
    .category img { 
      width: 100%; 
      height: 220px; 
      object-fit: cover; 
      border-radius: 12px; 
      transition: transform 0.3s;
    }
    .category:hover img { 
      transform: scale(1.1) rotate(2deg); 
    }

    /* Category Button */
    .category a { 
      display: inline-block; 
      margin-top: 12px; 
      background: linear-gradient(45deg, #00c853, #64dd17); 
      color: white; 
      padding: 10px 20px; 
      border-radius: 25px; 
      text-decoration: none; 
      font-weight: bold;
      font-size: 16px;
      transition: 0.3s;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .category a:hover { 
      background: linear-gradient(45deg, #64dd17, #00c853); 
      transform: scale(1.1); 
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    /* Responsive Media Queries */
    @media (max-width: 1024px) {
      nav a { margin: 0 10px; font-size: 15px; }
      h2 { font-size: 32px; }
      .grid { padding: 0 30px 40px; gap: 20px; }
    }

    @media (max-width: 768px) {
      nav { padding: 10px; }
      nav a { display: inline-block; margin: 5px 8px; font-size: 14px; }
      h2 { font-size: 28px; }
      .grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); padding: 0 20px 30px; }
      .category img { height: 180px; }
      .category a { font-size: 14px; padding: 8px 16px; }
    }

    @media (max-width: 480px) {
      nav { padding: 8px; }
      nav a { display: block; margin: 5px 0; font-size: 13px; }
      h2 { font-size: 22px; margin: 20px 0; }
      .grid { grid-template-columns: 1fr; padding: 0 15px 20px; }
      .category { padding: 10px; }
      .category img { height: 150px; }
      .category a { font-size: 13px; padding: 6px 12px; }
    }

  </style>
</head>
<body>
  <nav>
    <a href="index.php">Home</a>
    <a href="cart.php">🛒 Cart</a>
    <a href="shop.php">Shop</a>
    <a href="categories.php">Categories</a>
    <a href="deals.php">Deals</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
  </nav>

  <h2>Shop by Categories</h2>
  <div class="grid">
    <div class="category">
      <img src="apple-1282241_1280.jpg" alt="Electronics">
      <a href="electronics.php">Electronics</a>
    </div>
    <div class="category">
      <img src="download (3).webp" alt="Clothing">
      <a href="clothing.php">Clothing</a>
    </div>
    <div class="category">
      <img src="facewash.webp" alt="Beauty">
      <a href="beauty.php">Beauty</a>
    </div>
    <div class="category">
      <img src="leather-wallet-7006894_1280.jpg" alt="Accessories">
      <a href="accessories.php">Accessories</a>
    </div>

    <!-- ✅ New Categories Added Below -->
    <div class="category">
      <img src="living-room-1835923_1280.jpg" alt="Home and Living">
      <a href="home_living.php">Home & Living</a>
    </div>
    <div class="category">
      <img src="baby-1399332_1280.jpg" alt="Kids Collection">
      <a href="kids_collection.php">Kids Collection</a>
    </div>
    <div class="category">
      <img src="sports.jpg" alt="Sports and Fitness">
      <a href="sports_fitness.php">Sports & Fitness</a>
    </div>
  </div>
</body>
</html>
