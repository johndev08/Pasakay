<?php
session_start();
include '../connection.php';

$user_username = $_SESSION['username'];

// Get all grab records for the current driver
$grab_query = mysqli_query($connection, "SELECT * FROM grab WHERE driver='$user_username'");

// Prepare statements for updating driver and passenger availability, and deleting grab records
$remove_driver_stmt = $connection->prepare("UPDATE users SET availability = ? WHERE username = ?");
$remove_passenger_stmt = $connection->prepare("UPDATE users SET availability = ? WHERE username = ?");
$delete_grab_stmt = $connection->prepare("DELETE FROM grab WHERE driver = ?");

// Set the availability value
$availability = '';

// Update driver availability
if (!$remove_driver_stmt->execute([$availability, $user_username])) {
    echo "<script>alert('Failed to remove driver from grab!');</script>";
}

// Process each grab record to update passenger availability
while ($row = mysqli_fetch_assoc($grab_query)) {
    $name = $row['username'];
    if (!$remove_passenger_stmt->execute([$availability, $name])) {
        echo "<script>alert('Failed to remove passenger from grab!');</script>";
    }
}

// Delete all grab records for the driver
if (!$delete_grab_stmt->execute([$user_username])) {
    echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
} else {
    echo "<script>alert('Depart Successfully.');</script>";
    echo "<script>window.location.href = './passenger.php';</script>";
}

// Close statements and connection
$remove_driver_stmt->close();
$remove_passenger_stmt->close();
$delete_grab_stmt->close();
$connection->close();
?>
