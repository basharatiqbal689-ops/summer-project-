<?php
$conn = mysqli_connect("localhost", "root", "", "bashistore");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM basharat WHERE id=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: display.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
