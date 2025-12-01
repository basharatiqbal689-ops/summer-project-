<?php
$conn = mysqli_connect("localhost", "root", "", "bashistore");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['id'])){
    $id         = $_POST['id'];
    $first_name = $_POST['First_name']; // capitalized input name
    $last_name  = $_POST['Last_name'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    $sql = "UPDATE basharat 
            SET first_name='$first_name', last_name='$last_name', email='$email', password='$password'
            WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        header("Location: display.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
