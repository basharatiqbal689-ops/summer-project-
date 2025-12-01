<?php
session_start();

// --- Database connection ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bashistore";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// --- Require login ---
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// --- Helper functions ---
function safe_count($conn, array $tables) {
    foreach ($tables as $tbl) {
        $sql = "SELECT COUNT(*) AS total FROM `$tbl`";
        $res = @mysqli_query($conn, $sql);
        if ($res) {
            $row = mysqli_fetch_assoc($res);
            if ($row && isset($row['total'])) return (int)$row['total'];
        }
    }
    return 0;
}

function safe_sum_total($conn, $table = 'customer_orders', $col = 'total') {
    $sql = "SELECT SUM(`$col`) AS total_sales FROM `$table`";
    $res = @mysqli_query($conn, $sql);
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        if ($row && $row['total_sales'] !== null) return (float)$row['total_sales'];
    }
    return 0;
}

function get_customer_name($conn, $user_id) {
    if (empty($user_id)) return 'Guest';
    $candidates = ['basharat', 'users'];
    foreach ($candidates as $tbl) {
        $sql = "SELECT `name` FROM `$tbl` WHERE `id` = " . intval($user_id) . " LIMIT 1";
        $res = @mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
            $r = mysqli_fetch_assoc($res);
            if (!empty($r['name'])) return $r['name'];
        }
    }
    return "User #".intval($user_id);
}

// --- Fetch counts ---
$product_count  = safe_count($conn, ['products']);
$customer_count = safe_count($conn, ['users', 'basharat']);
$order_count    = safe_count($conn, ['customer_orders']);
$total_sales    = safe_sum_total($conn, 'customer_orders', 'total');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>BashiStore Dashboard</title>
  <style>
    * {margin:0;padding:0;box-sizing:border-box;}
    body {font-family: Arial, sans-serif; display:flex; min-height:100vh; background:#f4f6f8;}
    .sidebar {width: 220px; background:#2c3e50; color:#fff; padding:20px 0;}
    .sidebar h2 {text-align:center; margin-bottom:20px;}
    .sidebar ul {list-style:none; padding:0;}
    .sidebar ul li {padding:15px 20px; cursor:pointer; transition:0.3s;}
    .sidebar ul li:hover, .sidebar ul li.active {background:#34495e;}
    .content {flex:1; padding:30px; overflow-y:auto;}
    .section {display:none;}
    .section.active {display:block;}
    .cards {display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:30px;}
    .card {background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); text-align:center;}
    .card h3 {margin-bottom:10px; color:#2980b9;}
    table {width:100%; border-collapse:collapse; margin-top:20px; background:#fff;}
    table th, table td {border:1px solid #ddd; padding:10px; text-align:center; word-break:break-word;}
    table th {background:#2980b9; color:white;}
    .status-completed {color:green;font-weight:bold;}
    .status-pending {color:orange;font-weight:bold;}
    .status-shipped {color:blue;font-weight:bold;}
    .logout {display:block; text-align:center; margin-top:20px; background:#e74c3c; color:white; padding:10px; border-radius:6px; text-decoration:none;}
    .logout:hover {background:#c0392b;}
    h1, h2 {color:#2c3e50; margin-bottom:15px;}

    /* ✅ MEDIA QUERIES */
    /* --- Small Devices (Phones) --- */
    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        text-align: center;
      }
      .sidebar ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
      }
      .sidebar ul li {
        padding: 10px;
        font-size: 14px;
      }
      .content {
        padding: 15px;
      }
      .cards {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      table th, table td {
        padding: 6px;
        font-size: 13px;
      }
      h1 {
        font-size: 20px;
        text-align: center;
      }
      h2 {
        font-size: 18px;
      }
      .logout {
        width: 90%;
        margin: 15px auto;
      }
    }

    /* --- Tablets (Medium Screens) --- */
    @media (min-width: 769px) and (max-width: 1024px) {
      .sidebar {
        width: 180px;
      }
      .sidebar ul li {
        font-size: 15px;
      }
      .cards {
        grid-template-columns: repeat(2, 1fr);
      }
      table th, table td {
        font-size: 14px;
      }
    }

    /* --- Large Screens --- */
    @media (min-width: 1025px) {
      .cards {
        grid-template-columns: repeat(4, 1fr);
      }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>BashiStore</h2>
    <ul>
      <li class="active" onclick="showSection('dashboard', this)">Dashboard</li>
      <li onclick="showSection('products', this)">Products</li>
      <li onclick="showSection('customers', this)">Customers</li>
      <li onclick="showSection('orders', this)">Orders</li>
      <li onclick="showSection('settings', this)">Settings</li>
    </ul>
    <a href="logout.php" class="logout">Logout</a>
  </div>

  <div class="content">
    <!-- =================== DASHBOARD =================== -->
    <div id="dashboard" class="section active">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?> 👋</h1>
      <div class="cards">
        <div class="card"><h3><?php echo intval($product_count); ?></h3><p>Products</p></div>
        <div class="card"><h3><?php echo intval($customer_count); ?></h3><p>Customers</p></div>
        <div class="card"><h3><?php echo intval($order_count); ?></h3><p>Orders</p></div>
        <div class="card"><h3>Rs. <?php echo number_format((float)$total_sales, 2); ?></h3><p>Total Sales</p></div>
      </div>

      <h2>Recent Orders</h2>
      <table>
        <tr><th>Order ID</th><th>Customer</th><th>Product</th><th>Status</th></tr>
        <?php
        $orders_sql = "SELECT * FROM `customer_orders` ORDER BY order_id DESC LIMIT 10";
        $res = @mysqli_query($conn, $orders_sql);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $order_id = $row['order_id'] ?? 'N/A';
                $customer_display = !empty($row['user_id']) ? htmlspecialchars(get_customer_name($conn, $row['user_id'])) : 'Guest';
                $product_display = htmlspecialchars($row['product_name'] ?? '—');
                $status_raw = $row['status'] ?? 'Pending';
                $status_clean = strtolower(preg_replace('/[^a-z0-9_-]/', '', $status_raw));
                echo "<tr>
                        <td>#".htmlspecialchars($order_id)."</td>
                        <td>".$customer_display."</td>
                        <td>".$product_display."</td>
                        <td class='status-".htmlspecialchars($status_clean)."'>".ucfirst($status_raw)."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No recent orders.</td></tr>";
        }
        ?>
      </table>
    </div>

    <!-- =================== PRODUCTS =================== -->
    <div id="products" class="section">
      <h1>All Products</h1>
      <table>
        <tr><th>ID</th><th>Name</th><th>Price</th><th>Category</th></tr>
        <?php
        $sql = "SELECT * FROM products LIMIT 20";
        $result = @mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>".htmlspecialchars($row['name'] ?? '')."</td>
                    <td>Rs. ".number_format($row['price'] ?? 0, 2)."</td>
                    <td>".htmlspecialchars($row['category'] ?? 'N/A')."</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No products found.</td></tr>";
        }
        ?>
      </table>
    </div>

    <!-- =================== CUSTOMERS =================== -->
    <div id="customers" class="section">
      <h1>Registered Customers</h1>
      <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>
        <?php
        $sql = "SELECT id, name, email, role FROM users";
        $res = @mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>".htmlspecialchars($row['name'] ?? '')."</td>
                    <td>".htmlspecialchars($row['email'] ?? '')."</td>
                    <td>".htmlspecialchars($row['role'] ?? 'User')."</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='4'>No customers found.</td></tr>";
        }
        ?>
      </table>
    </div>

    <!-- =================== ORDERS =================== -->
    <div id="orders" class="section">
      <h1>All Orders</h1>
      <table>
        <tr><th>Order ID</th><th>Customer</th><th>Product</th><th>Total</th><th>Status</th><th>Date</th></tr>
        <?php
        $sql = "SELECT * FROM customer_orders ORDER BY order_id DESC";
        $res = @mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>#{$row['order_id']}</td>
                    <td>".htmlspecialchars(get_customer_name($conn, $row['user_id'] ?? 0))."</td>
                    <td>".htmlspecialchars($row['product_name'] ?? 'N/A')."</td>
                    <td>Rs. ".number_format($row['total'] ?? 0, 2)."</td>
                    <td>".htmlspecialchars($row['status'] ?? 'Pending')."</td>
                    <td>".htmlspecialchars($row['order_date'] ?? '—')."</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='6'>No orders found.</td></tr>";
        }
        ?>
      </table>
    </div>

    <!-- =================== SETTINGS =================== -->
    <div id="settings" class="section">
      <h1>Account Settings</h1>
      <p><b>Name:</b> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></p>
      <p><b>Email:</b> <?php echo htmlspecialchars($_SESSION['user_email'] ?? 'Not Set'); ?></p>
      <p><b>User ID:</b> <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </div>

  <script>
    function showSection(id, el) {
      document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
      document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
      const section = document.getElementById(id);
      if (section) section.classList.add('active');
      if (el) el.classList.add('active');
    }
  </script>
</body>
</html>
