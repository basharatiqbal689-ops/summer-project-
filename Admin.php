<?php
// 🧠 Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bashistore";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - BashiStore</title>
<style>
/* 🔹 Base */
* { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }
body { background: #f4f7ff; color: #333; }

/* 🔹 Header */
header {
  background: linear-gradient(90deg,#004aad,#007bff);
  color: #fff;
  padding: 15px 40px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  box-shadow:0 2px 6px rgba(0,0,0,0.2);
}
header h1 { font-size:24px; letter-spacing:1px; }
header a.logout {
  background:#ff4444; color:#fff; padding:8px 15px; border-radius:6px;
  text-decoration:none; font-weight:500;
}
header a.logout:hover { background:#cc0000; }

/* 🔹 Sidebar */
.sidebar {
  width: 240px;
  background:#fff;
  height:100vh;
  position:fixed;
  top:0;
  left:0;
  padding-top:80px;
  box-shadow:2px 0 6px rgba(0,0,0,0.1);
}
.sidebar ul { list-style:none; }
.sidebar ul li { margin:12px 0; }
.sidebar ul li a {
  display:block;
  padding:12px 20px;
  text-decoration:none;
  color:#333;
  font-weight:500;
  transition:0.3s;
  border-left:4px solid transparent;
  border-radius: 0 25px 25px 0;
}
.sidebar ul li a:hover,
.sidebar ul li a.active {
  background:#e6f0ff;
  border-left:4px solid #007bff;
  color:#007bff;
}

/* 🔹 Main Content */
.main-content {
  margin-left: 250px;
  padding:30px;
}
.main-content iframe {
  width:100%;
  height:85vh;
  border:none;
  background:#fff;
  border-radius:10px;
  box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

/* 🔹 Footer */
footer {
  text-align:center;
  padding:15px;
  background:#fff;
  position:fixed;
  bottom:0;
  left:250px;
  width:calc(100% - 250px);
  box-shadow:0 -2px 6px rgba(0,0,0,0.1);
  color:#555;
  font-size:14px;
  border-top:1px solid #ddd;
}

/* 🔹 Responsive */
@media (max-width:1024px){
  header h1{font-size:20px;}
  .sidebar{width:200px;}
  .main-content{margin-left:210px;}
  footer{left:210px;width:calc(100% - 210px);}
}
@media (max-width:768px){
  header{flex-direction:column;text-align:center;gap:10px;}
  .sidebar{width:100%;height:auto;position:relative;padding-top:10px;box-shadow:none;}
  .sidebar ul{display:flex;flex-wrap:wrap;justify-content:center;}
  .sidebar ul li a{padding:10px 12px;font-size:14px;}
  .main-content{margin-left:0;padding:15px;}
  footer{left:0;width:100%;position:relative;}
}
@media (max-width:480px){
  header h1{font-size:18px;}
  header a.logout{padding:6px 10px;font-size:12px;}
  .sidebar ul li a{font-size:13px;padding:8px 10px;}
  .main-content iframe{height:65vh;}
  footer{font-size:12px;padding:10px;}
}
</style>

<script>
// 🔄 Highlight Active Menu Item
function setActive(link){
    document.querySelectorAll('.sidebar a').forEach(a=>a.classList.remove('active'));
    link.classList.add('active');
    document.getElementById('content-frame').src = link.getAttribute('data-page');
}
</script>
</head>
<body>

<header>
  <h1>🛠️ Admin Panel - BashiStore</h1>
  <a href="logout.php" class="logout">Logout</a>
</header>

<div class="sidebar">
  <ul>
    <li><a href="#" data-page="dashboard.php" class="active" onclick="setActive(this)">📊 Dashboard</a></li>
    <li><a href="#" data-page="display_users.php" onclick="setActive(this)">👤 Display Users</a></li>
    <li><a href="#" data-page="update_product.php" onclick="setActive(this)">✏️ Update Product</a></li>
    <li><a href="#" data-page="delete_product.php" onclick="setActive(this)">🗑️ Delete Product</a></li>
  </ul>
</div>

<div class="main-content">
  <iframe id="content-frame" src="dashboard.php"></iframe>
</div>

<footer>
  &copy; <?php echo date("Y"); ?> BashiStore Admin Panel | Developed by Basharat 💻
</footer>

</body>
</html>
