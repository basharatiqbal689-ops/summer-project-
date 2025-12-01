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

if (isset($_POST['add_to_cart'])) {
    $_SESSION['cart'][] = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'quantity' => 1
    ];
    header("Location: cart.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM products WHERE category='Accessories'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>Accessories - BashiStore.pk</title>
<style>
body { font-family: Arial; background: #f9f9f9; margin: 0; }
nav { background: #333; padding: 15px; color: white; text-align: center; }
nav a { color: white; margin: 0 12px; text-decoration: none; font-weight: bold; }
h2 { text-align: center; color: #333; margin: 20px 0; }
.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 0 40px 40px; }
.product { background: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: relative; }
.product img { width: 100%; height: 200px; object-fit: contain; border-radius: 8px; }
.product h4 { margin: 10px 0 5px; }
.product p { color: green; font-weight: bold; }
.button { background: green; color: #fff; padding: 6px 12px; border: none; cursor: pointer; border-radius: 4px; }
.button:hover { background: darkgreen; }

.stars { color: #ccc; cursor: pointer; font-size: 22px; }
.stars .active { color: gold; }
.rating-text { display: block; margin-top: 5px; font-weight: bold; }
</style>
</head>
<body>
<nav>
  <a href="categories.php">Categories</a>
  <a href="cart.php">🛒 Cart</a>
</nav>

<h2>Accessories Collection</h2>

<div class="grid">
<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['id'];
        $rating_query = mysqli_query($conn, "SELECT COUNT(*) AS count_rating, SUM(rating) AS sum_rating FROM product_ratings WHERE product_id='$pid'");
        $rating_data = mysqli_fetch_assoc($rating_query);
        $count = $rating_data['count_rating'];
        $sum = $rating_data['sum_rating'];
        $avg_rating = $count ? intval(round($sum / $count)) : 0;
?>
<div class="product" data-product-id="<?php echo $pid; ?>">
  <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
  <h4><?php echo htmlspecialchars($row['name']); ?></h4>
  <p>Rs <?php echo htmlspecialchars($row['price']); ?></p>

  <div class="stars">
    <?php
    for ($i = 1; $i <= 5; $i++) {
        $class = ($i <= $avg_rating) ? 'active' : '';
        echo "<span class='star $class' data-rating='$i'>&#9733;</span>";
    }
    ?>
  </div>
  <span class="rating-text"><?php echo $count ? "($avg_rating / 5)" : "No rating yet"; ?></span>

  <form method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
    <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
    <button type="submit" name="add_to_cart" class="button">Add to Cart</button>
  </form>
</div>
<?php
    }
} else {
    echo "<p style='text-align:center;color:#777;'>No accessories available.</p>";
}
?>
</div>

<script>
document.querySelectorAll('.product').forEach(product => {
  const stars = product.querySelectorAll('.star');
  const ratingText = product.querySelector('.rating-text');
  stars.forEach(star => {
    star.addEventListener('click', function() {
      const rating = this.getAttribute('data-rating');
      const productId = product.getAttribute('data-product-id');

      fetch('rate_product.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `product_id=${productId}&rating=${rating}`
      })
      .then(res => res.text())
      .then(data => {
        if(data.trim() === 'success'){
          // update stars locally without reload
          stars.forEach((s, index) => {
            if(index < rating) s.classList.add('active');
            else s.classList.remove('active');
          });
          ratingText.textContent = `(${rating} / 5)`;
        }
      });
    });
  });
});
</script>

</body>
</html>
