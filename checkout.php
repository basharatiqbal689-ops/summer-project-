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
  <title>Checkout - BashiStore.pk</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f4f4f9; }
    h2 { text-align: center; }
    table { width: 80%; margin: 20px auto; border-collapse: collapse; background: white; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background-color: #f0f0f0; }
    .form-container { width: 60%; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    input, textarea, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; }
    button { background: green; color: white; border: none; padding: 10px 15px; cursor: pointer; border-radius: 4px; }
    button:hover { background: darkgreen; }

    .hidden { display: none; }

    @media (max-width: 768px) {
      table { width: 100%; font-size: 14px; }
      .form-container { width: 90%; }
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
    <h3>📦 Shipping & Payment Details</h3>
    <form action="order_success.php" method="post">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="address" placeholder="Full Address" required>
      <input type="text" name="phone" placeholder="Phone Number" required>
      <textarea name="notes" placeholder="Order Notes (Optional)"></textarea>

      <label for="payment_method">Select Payment Method:</label>
      <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
        <option value="">-- Select Payment Method --</option>
        <option value="Cash on Delivery">Cash on Delivery</option>
        <option value="Easypaisa">Easypaisa</option>
        <option value="JazzCash">JazzCash</option>
        <option value="Bank Transfer">Bank Transfer</option>
      </select>

      <div id="transaction_field" class="hidden">
        <label>Transaction ID:</label>
        <input type="text" name="transaction_id" placeholder="Enter Transaction ID">
      </div>

      <button type="submit">Place Order</button>
    </form>
  </div>

  <script>
    function togglePaymentFields() {
      const method = document.getElementById('payment_method').value;
      const transactionField = document.getElementById('transaction_field');
      
      if (method === 'Cash on Delivery' || method === '') {
        transactionField.classList.add('hidden');
      } else {
        transactionField.classList.remove('hidden');
      }
    }
  </script>

  <?php endif; ?>
</body>
</html>
