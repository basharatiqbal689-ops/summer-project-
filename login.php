<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "bashistore");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = ""; // Error message

if (isset($_POST['login'])) {
    // Trim inputs for safety
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // ✅ Prevent SQL Injection with prepared statement
    $stmt = $conn->prepare("SELECT * FROM basharat WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) === 1) {
        $user = $result->fetch_assoc();

        // ✅ Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Save session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['First_name']; // use exact column name
            $_SESSION['role'] = $user['role']; // ✅ role session

            // ✅ Redirect according to role
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");
            } elseif ($user['role'] === 'customer') {
                header("Location: index.php");
            } else {
                header("Location: index.php"); // fallback for any other role
            }
            exit;
        } else {
            $error = "❌ Password incorrect!";
        }
    } else {
        $error = "❌ Email not found!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #2980b9, #6dd5fa);
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
    .container h2 { text-align: center; color: #333; }
    input[type="email"], input[type="password"] {
      width: 100%; padding: 12px; margin-top: 12px;
      border: 1px solid #ccc; border-radius: 8px; font-size: 16px;
    }
    button {
      width: 100%; padding: 12px; margin-top: 18px;
      background-color: #2980b9; color: white; border: none;
      border-radius: 8px; font-size: 16px; cursor: pointer;
      transition: 0.3s ease;
    }
    button:hover { background-color: #2573a6; }
    .switch { text-align:center; margin-top:1rem; }
    .switch a { color:#2980b9; text-decoration:none; }
    .switch a:hover { text-decoration: underline; }
    .error { color:red; text-align:center; margin-top:10px; font-weight:bold; }

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
      input[type="email"], input[type="password"], button {
        font-size: 14px;
        padding: 10px;
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 15px;
        display: block;
      }
      .container {
        width: 100%;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      input[type="email"], input[type="password"], button {
        font-size: 13px;
        padding: 8px;
      }
      h2 {
        font-size: 20px;
      }
      .switch {
        font-size: 14px;
      }
    }

  </style>
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form action="" method="post">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
    </form>
    <?php if($error != "") { echo "<div class='error'>$error</div>"; } ?>
    <div class="switch">
      Don't have an account? <a href="register.php">Register</a>
    </div>
  </div>
</body>
</html>
