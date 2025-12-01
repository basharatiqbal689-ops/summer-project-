<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ✅ Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Your cart is empty!'); window.location='index.php';</script>";
    exit();
}

// ✅ Get form data
$order_name = mysqli_real_escape_string($conn, $_POST['name']);
$order_email = mysqli_real_escape_string($conn, $_POST['email']);
$order_address = mysqli_real_escape_string($conn, $_POST['address']);
$order_phone = mysqli_real_escape_string($conn, $_POST['phone']);
$order_notes = mysqli_real_escape_string($conn, $_POST['notes'] ?? '');
$order_payment = mysqli_real_escape_string($conn, $_POST['payment']);
$user_id = $_SESSION['user_id'] ?? 0; // if not logged in

// ✅ Calculate total
$grand_total = 0;
foreach ($_SESSION['cart'] as $item) {
    $grand_total += $item['price'] * $item['quantity'];
}

// ✅ Insert order into database
$sql = "INSERT INTO customer_orders (user_id, name, email, address, phone, notes, payment_method, total)
        VALUES ('$user_id', '$order_name', '$order_email', '$order_address', '$order_phone', '$order_notes', '$order_payment', '$grand_total')";
if (mysqli_query($conn, $sql)) {
    $_SESSION['cart'] = []; // Clear cart
} else {
    die("Database Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>Order Success - BashiStore</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #e0f7fa;
      margin: 0;
      padding: 40px;
      text-align: center;
    }
    .success-box {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      display: inline-block;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    h2 { color: #00796b; margin-bottom: 20px; }
    p { font-size: 18px; margin: 10px 0; }
    .btn {
      display: inline-block;
      margin-top: 20px;
      background: #00796b;
      color: #fff;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn:hover { background: #004d40; }

    /* Responsive */
    @media (max-width: 768px) {
      .success-box { width: 90%; padding: 30px; }
      p { font-size: 16px; }
    }
    @media (max-width: 480px) {
      body { padding: 20px 10px; }
      .success-box { width: 100%; padding: 20px; }
      h2 { font-size: 22px; }
      p { font-size: 14px; }
      .btn { padding: 8px 15px; font-size: 14px; }
    }
  </style>
</head>
<body>
  <div class="success-box">
    <h2>✅ Order Placed Successfully!</h2>
    <p>Thank you, <b><?php echo $order_name; ?></b>, for your order.</p>
    <p>Total Amount: <b>Rs <?php echo $grand_total; ?></b></p>
    <p>Payment Method: <b><?php echo $order_payment; ?></b></p>
    <p>We will ship your items to:</p>
    <p><?php echo $order_address; ?></p>
    <p>Order confirmation has been sent to: <b><?php echo $order_email; ?></b></p>
    <?php if(!empty($order_notes)): ?>
      <p><i>Notes:</i> <?php echo $order_notes; ?></p>
    <?php endif; ?>
    <a class="btn" href="index.php">Continue Shopping</a>
  </div>
</body>
</html>
