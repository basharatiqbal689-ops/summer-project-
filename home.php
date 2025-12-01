<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Home - BashiStore.pk</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fff; }
    
    nav {
      background: #f2f2f2;
      padding: 12px;
      text-align: center;
    }
    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }

    .hero {
      background: linear-gradient(to right, #fceabb, #f8b500);
      color: #333;
      padding: 60px 20px;
      text-align: center;
    }
    .hero h1 {
      font-size: 36px;
      margin-bottom: 10px;
    }
    .hero p {
      font-size: 18px;
    }

    .section {
      padding: 40px 20px;
      text-align: center;
    }

    .section h2 {
      font-size: 28px;
      margin-bottom: 20px;
      color: #d35400;
    }

    .features {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .feature {
      width: 250px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
      background-color: #fff8e1;
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .feature:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .feature h3 {
      font-size: 20px;
      margin-bottom: 10px;
      color: #333;
    }

    footer {
      background: #f2f2f2;
      padding: 15px;
      text-align: center;
      font-size: 14px;
      color: #555;
      margin-top: 30px;
    }

    /* -------------------- */
    /* 📱 Responsive Media Queries */
    /* -------------------- */

    /* Tablets */
    @media (max-width: 768px) {
        .hero h1 { font-size: 30px; }
        .hero p { font-size: 16px; }
        .section h2 { font-size: 24px; }
        .features {
            gap: 20px;
        }
        .feature { width: 45%; }
    }

    /* Mobile */
    @media (max-width: 480px) {
        nav a { display: block; margin: 8px 0; }
        .hero h1 { font-size: 24px; }
        .hero p { font-size: 14px; }
        .section h2 { font-size: 20px; }
        .features { flex-direction: column; gap: 15px; }
        .feature { width: 90%; margin: 0 auto; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav>
    <a href="home.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="categories.php">Categories</a>
    <a href="deals.php">Deals</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
  </nav>

  <!-- Hero Section -->
  <div class="hero">
    <h1>Welcome to BashiStore.pk</h1>
    <p>Sab kuch ek jaga – Discover amazing products at unbeatable prices</p>
  </div>

  <!-- Features -->
  <div class="section">
    <h2>Why Shop With Us?</h2>
    <div class="features">
      <div class="feature" onclick="goToShop()">
        <h3>Wide Variety</h3>
        <p>From electronics to clothing, we have everything you need.</p>
      </div>
      <div class="feature" onclick="showDeliveryInfo()">
        <h3>Fast Delivery</h3>
        <p>Nationwide shipping with reliable and quick delivery.</p>
      </div>
      <div class="feature" onclick="showPaymentInfo()">
        <h3>Secure Payments</h3>
        <p>Multiple payment options including Cash on Delivery.</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
   &copy; 2025 BashiStore.pk — All Rights Reserved. Bashi.......
  </footer>

  <!-- JavaScript -->
  <script>
    function goToShop() {
      window.location.href = "shop.php";
    }

    function showDeliveryInfo() {
      alert("🚚 Fast Delivery: We offer quick and reliable nationwide shipping across Pakistan!");
    }

    function showPaymentInfo() {
      alert("💳 Secure Payments: Enjoy safe transactions with Cash on Delivery & online options!");
    }
  </script>

</body>
</html>
