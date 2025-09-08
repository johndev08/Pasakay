<?php
session_start();
include("../connection.php");
$user_id = $_SESSION["id"];
$user_username = $_SESSION['username'];

$get_record = mysqli_query($connection, "SELECT * FROM users WHERE username='$user_username'");
$row = mysqli_fetch_assoc($get_record);
$fname = $row["fname"];
$profile = $row['profile'];
$username = $row['username'];
$destination = $_POST['need_ride'];
$quantity = $_POST['quantity'];
$fare = $_POST['fare'];

// Sanitize user input
$action = isset($_GET["action"]) ? $_GET["action"] : "";

if ($action == 'joineast') {
    $availability = 'east-passenger';
} elseif ($action == 'joinwest') {
    $availability = 'west-passenger';
} elseif ($action == 'joinlemery') {
    $availability = 'lemery-passenger';
} else {
    echo "<script>alert ('Invalid action!');</script>";
    echo "<script>window.location.href='./passenger.php'</script>";
    exit; 
}

if (isset($availability)) {
    $query = $connection->prepare('UPDATE users SET availability = ?, destination = ?, quantity = ?, fare = ? WHERE id=?');
    $query->bind_param("sssii", $availability, $destination, $quantity, $fare, $user_id);

    if ($query->execute()) {
        echo "<script>alert ('Successfully Joined!');</script>";
        echo "<script>window.location.href='./passenger.php'</script>";
    } else {
        echo "<script>alert ('Join Failed! Please try again.');</script>";
        echo "<script>window.location.href='./passenger.php'</script>";
    }
}
