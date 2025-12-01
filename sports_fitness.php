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

// Add to cart logic
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

// ✅ Correct category filter
$result = mysqli_query($conn, "SELECT * FROM products WHERE category='Sports and Fitness'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sports and Fitness - BashiStore</title>
<style>
body {
  font-family: 'Segoe UI';
  background: #f0f7ff;
  margin: 0;
}
h2 {
  text-align: center;
  color: #0d47a1;
  margin: 30px 0;
}
.products {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  padding: 30px;
}
.card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  text-align: center;
  padding: 15px;
  transition: 0.3s;
}
.card:hover { transform: scale(1.03); }
.card img {
  width: 100%;
  height: auto;
  max-height: 250px;
  object-fit: contain;
  border-radius: 10px;
  background: #f9f9f9;
  padding: 5px;
}
.card h3 { margin: 10px 0; color: #222; }
.card p { color: #16a085; font-weight: bold; }
button {
  background: #0d47a1;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
}
button:hover { background: #1565c0; }

/* ⭐ Star Rating */
.stars {
  color: #ccc;
  cursor: pointer;
  font-size: 20px;
  margin: 5px 0;
}
.stars .active {
  color: gold;
}

@media (max-width: 600px) {
  .products { padding: 10px; gap: 15px; }
  .card img { height: 180px; }
}
</style>
</head>
<body>

<h2>🏋️ Sports & Fitness</h2>
<div class="products">
<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pid = $row['id'];
        $rating_query = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating FROM product_ratings WHERE product_id='$pid'");
        $rating_data = mysqli_fetch_assoc($rating_query);
        $avg_rating = round($rating_data['avg_rating'],0); // nearest whole number
?>
  <div class="card" data-product-id="<?php echo $pid; ?>">
    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
    <p>Rs <?php echo htmlspecialchars($row['price']); ?></p>

    <!-- ⭐ Star Rating -->
    <div class="stars">
      <?php
      for ($i = 1; $i <= 5; $i++) {
          $class = ($i <= $avg_rating) ? 'active' : '';
          echo "<span class='star $class' data-rating='$i'>&#9733;</span>";
      }
      ?>
    </div>

    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
      <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
      <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>
  </div>
<?php
    }
} else {
    echo "<p style='text-align:center;color:#888;'>No products found in this category.</p>";
}
?>
</div>

<script>
document.querySelectorAll('.card').forEach(card => {
    const stars = card.querySelectorAll('.star');
    const productId = card.getAttribute('data-product-id');

    stars.forEach((star,index)=>{
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');

            fetch('rate_product.php', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: `product_id=${productId}&rating=${rating}`
            })
            .then(response=>response.text())
            .then(data=>{
                if(data.trim()==='success'){
                    stars.forEach((s,idx)=>{
                        if(idx<rating) s.classList.add('active');
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
