<?php
$conn = mysqli_connect("localhost", "root", "", "bashistore");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM basharat";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
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

        /* Table styling */
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #3498db;
            color: white;
            padding: 12px 15px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 14px;
        }

        td {
            background-color: #ffffff;
            padding: 12px 15px;
            text-align: center;
            font-size: 14px;
            border-bottom: 1px solid #e1e1e1;
        }

        tr:nth-child(even) td {
            background-color: #f2f6fc;
        }

        tr:hover td {
            background-color: #d6eaf8;
            transition: 0.3s;
        }

        a {
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
            color: #e74c3c;
        }

        /* -------------------- */
        /* 📱 Responsive Design */
        /* -------------------- */

        /* For tablets (max-width 768px) */
        @media (max-width: 768px) {
            body {
                margin: 10px;
            }

            h2 {
                font-size: 22px;
            }

            th, td {
                padding: 10px;
                font-size: 13px;
            }

            table {
                width: 100%;
            }
        }

        /* For mobile phones (max-width 480px) */
        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            table {
                display: block;
                width: 100%;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                padding: 8px;
                font-size: 12px;
            }

            a {
                font-size: 12px;
            }

            body {
                margin: 5px;
            }
        }
    </style>
</head>
<body>

<h2>All Users</h2>
<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Password</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['first_name']; ?></td>
    <td><?php echo $row['last_name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['password']; ?></td>
    <td>
        <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
