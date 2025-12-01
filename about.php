<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>About Us - BashiStore.pk</title>
  <style>
    body { font-family: Arial; margin: 0; padding: 0; }
    nav { background: #f2f2f2; padding: 10px; text-align: center; }
    nav a { margin: 0 15px; text-decoration: none; color: #333; font-weight: bold; }
    .content { padding: 20px; max-width: 800px; margin: auto; line-height: 1.6; }
    h2 { color: #d35400; }

    /* -------------------- 📱 Responsive Media Queries -------------------- */

    /* For tablets (width 992px and below) */
    @media (max-width: 992px) {
      nav a {
        margin: 0 10px;
        font-size: 16px;
      }
      .content {
        padding: 15px;
        max-width: 90%;
      }
    }

    /* For mobile devices (width 768px and below) */
    @media (max-width: 768px) {
      nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 8px;
      }
      nav a {
        display: inline-block;
        margin: 6px 10px;
        font-size: 15px;
      }
      .content {
        padding: 15px;
        font-size: 15px;
      }
      h2 {
        font-size: 22px;
        text-align: center;
      }
    }

    /* For very small screens (width 480px and below) */
    @media (max-width: 480px) {
      nav {
        flex-direction: column;
        align-items: center;
      }
      nav a {
        display: block;
        margin: 5px 0;
        font-size: 14px;
      }
      .content {
        padding: 10px;
        font-size: 14px;
      }
      h2 {
        font-size: 20px;
      }
      ul {
        padding-left: 20px;
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

  <div class="content">
    <h2>About Us</h2>
    <p><strong>BashiStore.pk</strong> is your trusted online shopping destination in Pakistan, offering a wide selection of quality products at unbeatable prices. From cutting-edge electronics and trendy clothing to beauty products, home accessories, and more — we have something for everyone.</p>

    <p>Founded with the vision to simplify shopping, BashiStore.pk brings convenience to your fingertips. Whether you're in a big city or a remote area, our fast delivery network ensures your order reaches you in time.</p>

    <p>What makes us different?</p>
    <ul>
      <li>✔️ Wide variety of products across all major categories</li>
      <li>✔️ 100% genuine and quality-checked items</li>
      <li>✔️ Secure online payment and Cash on Delivery options</li>
      <li>✔️ Easy returns and customer-first policies</li>
      <li>✔️ 24/7 customer support</li>
    </ul>

    <p>At BashiStore.pk, our mission is to empower every Pakistani to shop with confidence. We continuously strive to improve your online shopping experience by offering new deals, better products, and outstanding service.</p>

    <p>Thank you for choosing <strong>BashiStore.pk</strong> — Pakistan’s most reliable online store.</p>
  </div>
</body>
</html>
