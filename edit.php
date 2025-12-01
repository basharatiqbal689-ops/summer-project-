<?php
$conn = mysqli_connect("localhost", "root", "", "bashistore");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = [
    'id' => '',
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'password' => ''
];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // prevent SQL injection
    $sql = "SELECT * FROM basharat WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* General page styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 28px;
        }

        form {
            width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* -------------------- */
        /* 📱 Responsive Design */
        /* -------------------- */

        /* Tablets */
        @media (max-width: 768px) {
            form {
                width: 90%;
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="text"],
            input[type="email"],
            input[type="submit"] {
                font-size: 13px;
                padding: 10px;
            }
        }

        /* Mobile Phones */
        @media (max-width: 480px) {
            body {
                margin: 5px;
            }

            h2 {
                font-size: 20px;
            }

            form {
                width: 100%;
                padding: 15px;
            }

            input[type="text"],
            input[type="email"],
            input[type="submit"] {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<h2>Edit User</h2>
<form method="post" action="update.php">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

    <label>First Name:</label>
    <input type="text" name="First_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

    <label>Last Name:</label>
    <input type="text" name="Last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

    <label>Password:</label>
    <input type="text" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>

    <input type="submit" value="Update">
</form>

</body>
</html>
