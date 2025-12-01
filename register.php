<?php
// Database connection
$host = "localhost";
$user = "root";      // default XAMPP user
$pass = "";          // default password empty
$db   = "bashistore"; 

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['signup'])) {
    // Get form values (make sure input names match these keys)
    $first_name = $_POST['First_name'];  
    $last_name = $_POST['Last_name'];   
    $email = $_POST['email'];       
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $role = $_POST['role'];  // 👈 role bhi form se milega

    // Insert query (role column add kiya)
    $sql = "INSERT INTO `basharat` (`id`, `First_name`, `Last_name`, `email`, `password`, `role`) 
            VALUES (NULL, '$first_name', '$last_name', '$email', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Data inserted successfully!";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #8e44ad, #c084fc);
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 400px;
    }
    .container h2 {
      text-align: center;
      color: #333;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 12px;
      margin-top: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }
    button {
      width: 100%;
      padding: 12px;
      margin-top: 18px;
      background-color: #8e44ad;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s ease;
    }
    button:hover {
      background-color: #7d3c98;
    }
    .switch {
      text-align: center;
      margin-top: 1rem;
    }
    .switch a {
      color: #8e44ad;
      text-decoration: none;
    }
    .switch a:hover {
      text-decoration: underline;
    }

    /* ===== Media Queries for Responsiveness ===== */
    @media (max-width: 768px) {
      body {
        height: auto;
        padding: 20px;
      }
      .container {
        width: 90%;
        padding: 1.5rem;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"],
      select,
      button {
        font-size: 14px;
        padding: 10px;
      }
    }

    @media (max-width: 480px) {
      body {
        display: block;
        padding: 15px 10px;
      }
      .container {
        width: 100%;
        padding: 15px;
        border-radius: 10px;
      }
      h2 {
        font-size: 20px;
      }
      input[type="text"],
      input[type="email"],
      input[type="password"],
      select,
      button {
        font-size: 13px;
        padding: 8px;
      }
      .switch {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Register</h2>
    <form action="#" method="post">
      <input type="text" placeholder="First name" name="First_name" required />
      <input type="text" placeholder="Last name" name="Last_name" required />
      <input type="email" placeholder="Email" name="email" required />
      <input type="password" placeholder="Password" name="password" required />

      <!-- 👇 Role select dropdown -->
      <select name="role" required>
        <option value="customer">Customer</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit" name="signup">Sign Up</button>
    </form>
    <div class="switch">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>
