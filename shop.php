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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] == "add") {
    $id = $_GET['id'];
    $name = $_GET['name'];
    $price = $_GET['price'];

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
            "id" => $id,
            "name" => $name,
            "price" => $price,
            "quantity" => 1
        ];
    }

    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop - BashiStore.pk</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    nav a { margin: 0 15px; text-decoration: none; color: #333; font-weight: bold; }
    nav { background: #f2f2f2; padding: 10px; text-align: center; }
    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
      justify-content: center;
    }
    .product {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
      width: 180px;
      background: #fff;
      border-radius: 6px;
      position: relative;
    }
    .product img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 4px;
    }
    .product button {
      background: green;
      color: #fff;
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }

    /* ⭐ Star rating */
    .stars {
      color: #ccc;
      cursor: pointer;
      font-size: 20px;
      margin: 5px 0;
    }
    .stars .active {
      color: gold;
    }

    @media (max-width: 768px) {
      .product { width: 45%; }
      .product img { width: 100%; height: 130px; }
      .product button { padding: 4px 8px; font-size: 14px; }
    }
    @media (max-width: 480px) {
      .product { width: 100%; }
      .product img { height: 120px; }
      .product button { width: 100%; padding: 6px 0; font-size: 13px; }
      nav a { display: block; margin: 8px 0; }
    }
  </style>
</head>
<body>
  <nav>
    <a href="index.php">Home</a>
    <a href="shop.php">Shop</a>
    <a href="categories.php">Categories</a>
    <a href="deals.php">Deals</a>
    <a href="contact.php">Contact Us</a>
    <a href="about.php">About Us</a>
    <a href="cart.php">🛒 Cart</a>
  </nav>

  <div class="products">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pid = $row['id'];
            $rating_query = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating FROM product_ratings WHERE product_id='$pid'");
            $rating_data = mysqli_fetch_assoc($rating_query);
            $avg_rating = round($rating_data['avg_rating'], 0);
    ?>
      <div class='product'>
        <img src='image/<?php echo $row['image']; ?>' alt='<?php echo $row['name']; ?>'>
        <p><?php echo $row['name']; ?></p>
        <p>Rs <?php echo $row['price']; ?></p>

        <!-- ⭐ Star Rating -->
        <div class="stars" data-product-id="<?php echo $pid; ?>">
        <?php
        for ($i = 1; $i <= 5; $i++) {
            $class = ($i <= $avg_rating) ? 'active' : '';
            echo "<span class='star $class' data-rating='$i'>&#9733;</span>";
        }
        ?>
        </div>

        <a href='shop.php?action=add&id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['name']); ?>&price=<?php echo $row['price']; ?>'>
          <button>Add to Cart</button>
        </a>
      </div>
    <?php
        }
    } else {
        echo "<p>No products available yet.</p>";
    }
    ?>
  </div>

<script>
document.querySelectorAll('.stars').forEach(starDiv => {
    const stars = starDiv.querySelectorAll('.star');
    const productId = starDiv.getAttribute('data-product-id');

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');

            fetch('rate_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${productId}&rating=${rating}`
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    stars.forEach((s, idx) => {
                        if (idx < rating) s.classList.add('active');
                        else s.classList.remove('active');
                    });
                }
            });
        });
    });
});
</script>

</body>
</html>
