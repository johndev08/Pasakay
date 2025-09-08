<?php
session_start();
include("../connection.php");
$user_id = $_SESSION["id"];
$user_username = $_SESSION['username'];

$get_record = mysqli_query($connection, "SELECT * FROM users WHERE username='$user_username'");
while ($row = mysqli_fetch_assoc($get_record)) {
    $fname = $row["fname"];
    $profile = $row['profile'];
    $username = $row['username'];

    if (isset($_GET["action"])) {
        if ($_GET["action"] == 'joineast') {
            $availability = 'east-driver';
        } elseif ($_GET["action"] == 'joinwest') {
            $availability = 'west-driver';
        } elseif ($_GET["action"] == 'joinlemery') {
            $availability = 'lemery-driver';
        }

        if (isset($availability)) {
            $update_availability = $connection->prepare("UPDATE users SET availability = ? WHERE username = ?");
            $update_availability->bind_param("ss", $availability, $username);

            if ($update_availability->execute()) {
                echo "<script>alert ('Successfully Joined!');</script>";
                echo "<script>window.location.href='./queue.php'</script>";
            } else {
                echo "<script>alert ('Join Failed!');</script>";
            }
        }
    } else {
        echo "<script>alert ('Invalid action!');</script>";
        echo "<script>window.location.href='./queue.php'</script>";
    }
}
?>
