<?php
session_start();
include("../connection.php");

$user_id = $_SESSION['id'];
$user_username = $_SESSION['username'];

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $availability_map = [
        'TransferEast' => 'east-driver',
        'TransferWest' => 'west-driver',
        'TransferLemery' => 'lemery-driver',
    ];

    if (array_key_exists($action, $availability_map)) {
        $availability = $availability_map[$action];

        $driver_query = mysqli_query($connection, "SELECT fname FROM users WHERE availability='$availability' ORDER BY last_updated ASC");

        if (mysqli_num_rows($driver_query) > 0) {
            $driver_data = mysqli_fetch_assoc($driver_query);
            $first_name = $driver_data['fname'];

            $stmt = $connection->prepare("UPDATE grab SET driver = ? WHERE driver = ?");
            $stmt->bind_param("ss", $first_name, $user_username);

            if ($stmt->execute()) {
                echo "<script>alert('Passenger transferred successfully to $first_name (in $availability)!');</script>";
                echo "<script>window.location.href = './passenger.php';</script>";
            } else {
                echo "Error updating driver: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "<script>alert('No available drivers found for $availability.');</script>";
            echo "<script>window.location.href = './passenger.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid action.');</script>";
        echo "<script>window.location.href = './passenger.php';</script>";
    }
} else {
    echo "<script>alert('No action specified.');</script>";
    echo "<script>window.location.href = './passenger.php';</script>";
}
?>
