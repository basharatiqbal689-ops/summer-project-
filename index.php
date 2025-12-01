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
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MeraStore.pk - Sab Kuch Aik Jaga</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #fdfdfd;
      color: #333;
    }
    .main {
      background-color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      flex-wrap: wrap;
    }
    .left h1 { color: green; }
    .search-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #ffffff;
      padding: 10px 15px;
      border-radius: 50px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 420px;
      transition: all 0.3s ease;
    }
    .search-bar:hover { box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); }
    .search-bar form {
      display: flex;
      align-items: center;
      width: 100%;
    }
    .search-bar input[type="text"] {
      flex: 1;
      border: none;
      outline: none;
      background: #f1f5ff;
      font-size: 16px;
      padding: 10px 15px;
      border-radius: 30px;
      margin-right: 10px;
    }
    .search-bar button {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 30px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .search-bar button:hover { background: #0056b3; }
    .right {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .right a { text-decoration: none; color: #333; font-weight: bold; }
    .nav ul {
      display: flex;
      justify-content: center;
      list-style: none;
      gap: 50px;
      padding: 15px 0;
      background-color: #f4f4f4;
      font-weight: bold;
    }
    .nav ul li a { text-decoration: none; color: #333; }
    .first {
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding: 50px 20px;
      background-color: #fff;
      flex-wrap: wrap;
    }
    .textone h1 { font-size: 36px; color: #222; }
    .btn {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: green;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none;
    }
    .text h1 { text-align: center; margin: 40px 0 20px; color: #d35400; }
    .images {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      padding: 20px;
    }
    .images .pic1, .images .pic2, .images .pic3, .images .pic4 {
      text-align: center;
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 10px;
      background-color: #fff8e1;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .images h3, .images p { margin: 10px 0; }
    .third { background-color: #cfc9c3; text-align: center; padding: 30px 10px; }
    .third h1 { color: #000; }
    .fifth {
      padding: 40px 20px;
      background-color: #fefefe;
      text-align: center;
    }
    .fifth .text1 h1 { margin-bottom: 20px; }
    .footer ul {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 40px;
      list-style: none;
      margin-top: 10px;
    }
    .footer ul li { font-weight: bold; }
    .icon {
      display: flex;
      justify-content: center;
      gap: 30px;
      padding: 20px 0;
      font-size: 20px;
      background-color: #f4f4f4;
    }
    .icon i { color: #333; transition: color 0.3s; }
    .icon i:hover { color: green; }
/* media querries */
@media (max-width: 770px) {
  /* ✅ Header + Search + Right buttons stack vertically */
  .main {
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 10px;
  }

  .left h1 {
    font-size: 28px;
  }

  .search-bar {
    width: 90%;
    margin: 10px auto;
  }

  .search-bar input[type="text"] {
    width: 70%;
    font-size: 14px;
    padding: 8px;
  }

  .search-bar button {
    padding: 8px 14px;
    font-size: 14px;
  }

  .right {
    margin-top: 10px;
  }

  /* ✅ Navbar becomes vertical (dropdown-like) */
  .nav ul {
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 0;
  }

  .nav ul li a {
    font-size: 16px;
    padding: 6px 10px;
  }

  /* ✅ Hero section */
  .first {
    flex-direction: column;
    text-align: center;
    padding: 15px;
  }

  .first img {
    width: 90%;
    max-width: 350px;
    height: auto;
    margin-top: 10px;
  }

  .textone h1 {
    font-size: 26px;
  }

  .textone p {
    font-size: 14px;
  }

  .btn {
    padding: 8px 14px;
    font-size: 14px;
  }

  /* ✅ Product images or categories section */
  .images {
    flex-direction: column;
    align-items: center;
    gap: 20px;
  }

  .images img {
    width: 90%;
    height: auto;
  }

  /* ✅ Footer */
  .footer ul {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }
}





  </style>

</head>
<body>

<div class="main">
    <div class="left">
      <h1> BashiStore.pk</h1>
    </div>
    <div class="search-bar">
       <form method="get" action="search.php">
        <input type="text" name="q" placeholder="Search your product..." required>
        <button type="submit">Search</button>
       </form>
    </div>
    <div class="right">
      <h3><a href="login.php">Login</a> / <a href="register.php">Register</a></h3>
      <i class="fa-solid fa-user"></i>
    </div>
</div>

<div class="nav">
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li><a href="deals.php">Deals</a></li>
      <li><a href="contact.php">Contact Us</a></li>
      <li><a href="login.php">Login</a> / <a href="register.php">Register</a></li>
      <i class="fa-solid fa-user"></i>
    </ul>
</div>

<div class="first">
    <div class="textone">
      <h1>Sab kuch aik jaga_</h1>
      <h1>BashiStore.pk</h1>
      <br>
      <a class="btn" href="shop.php">Shop Now</a>
    </div>
    <div class="picture">
      <img src="bad and shoes.webp" alt="" width="400px" height="500px">
    </div>
</div>

<div class="second">
    <div class="text">
      <h1>Feature Categories</h1>
    </div>
    <div class="images">
      <a href="electronics.php" style="text-decoration: none; color: inherit;">
        <div class="pic1">
          <img src="apple-1282241_1280.jpg" alt="" width="200px" height="200px">
          <h3>Electronics</h3>
        </div>
      </a>
      <a href="clothing.php" style="text-decoration: none; color: inherit;">
        <div class="pic2">
          <img src="mock-up-2710535_1280.jpg" alt="" width="200px" height="200px">
          <h3>Clothing</h3>
        </div>
      </a>
      <a href="beauty.php" style="text-decoration: none; color: inherit;">
        <div class="pic3">
          <img src="lipsticks-5893482_1280.jpg" alt="" width="200px" height="200px">
          <h3>Beauty Products</h3>
        </div>
      </a>
      <a href="accessories.php" style="text-decoration: none; color: inherit;">
        <div class="pic4">
          <img src="package-1052370_1280.jpg" alt="" width="200px" height="200px">
          <h3>Accessories</h3>
        </div>
      </a>
    </div>
</div>

<div class="third">
  <h1>Flat 30% Off on Summer Collection</h1>
</div>

<div class="fourth">
    <div class="text">
      <h1>New Arrivals / Popular Products</h1>
    </div>
    <div class="images">
      <div class="pic1">
        <img src="earphones-5598952_1280.jpg" alt="" width="200px" height="200px">
        <h3>Product Name</h3>
        <p>$10.00</p>
        <a class="btn" href="shop.php">Add to Cart</a>
      </div>
      <div class="pic2">
        <img src="mock-up-2710535_1280.jpg" alt="" width="200px" height="200px">
        <h3>Product Name</h3>
        <p>$20.00</p>
        <a class="btn" href="shop.php">Add to Cart</a>
      </div>
      <div class="pic3">
        <img src="package-1052370_1280.jpg" alt="" width="200px" height="200px">
        <h3>Product Name</h3>
        <p>$25.00</p>
        <a class="btn" href="shop.php">Add to Cart</a>
      </div>
      <div class="pic4">
        <img src="apple-1282241_1280.jpg" alt="" width="200px" height="200px">
        <h3>Product Name</h3>
        <p>$50.00</p>
        <a class="btn" href="shop.php">Add to Cart</a>
      </div>
    </div>
</div>

<div class="fifth">
    <div class="text1">
      <h1>Enter Email to Get Special Discounts</h1>
    </div>
    <div class="footer">
      <ul>
        <a href="about.php"><button class="btn">About</button></a>
        <a href="contact.php"><button class="btn">contact us</button></a>
        <a href="https://www.facebook.com/"><button class="btn">Subscribe</button></a>
      </ul>
    </div>
</div>

<div class="icon">
   <a href="https://www.facebook.com/" target="_blank"> <i class="fa-brands fa-facebook"></i></a>
   <a href="https://www.instagram.com/"> <i class="fa-brands fa-instagram"></i></a>
   <a href="https://www.tiktok.com/@basharatiqbal36"> <i class="fa-brands fa-tiktok"></i></a>
</div>

</body>
</html>
