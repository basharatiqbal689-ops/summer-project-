<?php
session_start();

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// User login check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - MeraStore.pk</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f9f9f9; }
    h2 { text-align: center; }
    table { width: 80%; margin: auto; border-collapse: collapse; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #eee; }
    .btn { background: green; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
    .btn:hover { background: darkgreen; }
    .form-container { width: 60%; margin: auto; margin-top: 20px; background: #fff; padding: 20px; border-radius: 8px; }
    input, textarea, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; }

    /* Responsive */
    @media (max-width: 768px) {
      table { width: 100%; font-size: 14px; }
      .form-container { width: 90%; padding: 15px; }
      input, textarea, select { font-size: 14px; }
      .btn { width: 100%; font-size: 15px; padding: 10px; }
    }
  </style>
</head>
<body>
  <h2>🛒 Checkout</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Total</th>
    </tr>
    <?php
    $grand_total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total = $item['price'] * $item['quantity'];
            $grand_total += $total;
            echo "<tr>
                    <td>{$item['id']}</td>
                    <td>{$item['name']}</td>
                    <td>Rs {$item['price']}</td>
                    <td>{$item['quantity']}</td>
                    <td>Rs {$total}</td>
                  </tr>";
        }
        echo "<tr>
                <td colspan='4'><b>Grand Total</b></td>
                <td><b>Rs {$grand_total}</b></td>
              </tr>";
    } else {
        echo "<tr><td colspan='5'>Your cart is empty. <a href='shop.php'>Go back to shop</a></td></tr>";
    }
    ?>
  </table>

  <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
  <div class="form-container">
    <h3>📦 Shipping Details</h3>
    <form action="order_success.php" method="post">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="address" placeholder="Full Address" required>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <textarea name="notes" placeholder="Order Notes (Optional)"></textarea>

      <!-- ✅ Payment Method Added -->
      <label for="payment_method"><b>💳 Payment Method</b></label>
      <select name="payment_method" id="payment_method" required>
        <option value="" disabled selected>Select Payment Method</option>
        <option value="Cash on Delivery">Cash on Delivery</option>
        <option value="Credit/Debit Card">Credit/Debit Card</option>
        <option value="Easypaisa/JazzCash">Easypaisa / JazzCash</option>
      </select>

      <button type="submit" class="btn">Place Order</button>
    </form>
  </div>
  <?php endif; ?>
</body>
</html>
