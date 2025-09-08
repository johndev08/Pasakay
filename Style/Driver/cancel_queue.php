<?php
session_start();
include("../connection.php");
$user_id = $_SESSION["id"];
$user_username = $_SESSION['username'];

$get_record = mysqli_query($connection, "SELECT * FROM users WHERE username='$user_username'");
$get_grab = mysqli_query($connection, "SELECT * FROM grab WHERE driver='$user_username'");

if (mysqli_num_rows($get_record) > 0) {
    $row = mysqli_fetch_assoc($get_record);
    $fname = $row["fname"];
    $profile = $row['profile'];
    $username = $row['username'];
    $availability = '';

    if ($_GET["action"] == 'exiteast' || $_GET["action"] == 'exitwest' || $_GET["action"] == 'exitlemery') {
        $update_availability = $connection->prepare('UPDATE users SET availability = ? WHERE username = ?');
        $update_availability->bind_param("ss", $availability, $username);

        if ($update_availability->execute()) {
            $remove_grab = $connection->prepare("DELETE FROM grab WHERE driver = ?");
            $remove_grab->bind_param("s", $user_username);

            if ($remove_grab->execute()) {
                echo "<script>alert('Successfully Canceled!');</script>";
                echo "<script>window.location.href='./queue.php'</script>";
            } else {
                echo "<script>alert('Failed to remove from grab!');</script>";
            }
        } else {
            echo "<script>alert('Cancellation Unsuccessful!');</script>";
        }
    } else {
        echo "<script>alert('Failed to Cancel!');</script>";
        echo "<script>window.location.href='./queue.php'</script>";
    }
}
