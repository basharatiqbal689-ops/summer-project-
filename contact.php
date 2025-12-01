<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Contact Us - MeraStore.pk</title>
  <style>
    body { font-family: Arial; margin: 0; background: #fff; }
    nav { background: #f2f2f2; padding: 10px; text-align: center; }
    nav a { margin: 0 15px; text-decoration: none; color: #333; font-weight: bold; }
    .content { padding: 20px; max-width: 600px; margin: auto; }

    /* ✅ MEDIA QUERIES */
    /* --- Small Devices (Phones) --- */
    @media (max-width: 600px) {
      nav {
        display: flex;
        flex-direction: column;
        padding: 8px;
      }
      nav a {
        margin: 8px 0;
        font-size: 15px;
      }
      .content {
        padding: 15px;
        width: 90%;
      }
      h2 {
        font-size: 22px;
        text-align: center;
      }
      p {
        font-size: 15px;
        line-height: 1.5;
      }
    }

    /* --- Medium Devices (Tablets) --- */
    @media (min-width: 601px) and (max-width: 900px) {
      nav a {
        margin: 0 10px;
        font-size: 16px;
      }
      .content {
        width: 80%;
      }
    }

    /* --- Large Devices (Desktops) --- */
    @media (min-width: 901px) {
      nav {
        text-align: center;
      }
      nav a {
        font-size: 17px;
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
    <h2>Contact Us</h2>
    <p>Email: basharatiqbal689@gmail.com</p>
    <p>Phone: +92-3200519750</p>
    <p>Address: Gilgit, Pakistan</p>
  </div>
</body>
</html>
