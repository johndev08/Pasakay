<?php
session_start();
include '../connection.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $driver = $_SESSION['username'];

    $user_query = mysqli_query($connection, "SELECT username, profile, quantity FROM users WHERE id = '$user_id'");
    if ($row = mysqli_fetch_assoc($user_query)) {
        $username = $row['username'];
        $profile = $row['profile'];
        $quantity = $row['quantity'];
        
        switch ($quantity) {
            case 'x1':
                $quantity_value = 1;
                break;
            case 'x2':
                $quantity_value = 2;
                break;
            case 'x3':
                $quantity_value = 3;
                break;
            case 'x4':
            case 'Special':
                $quantity_value = 4;
                break;
            default:
                $quantity_value = 5;
                break;
        }

        $check_grab = mysqli_query($connection, "SELECT * FROM grab WHERE username='$username'");
        if (mysqli_num_rows($check_grab) > 0) {
            echo "<script>alert('This passenger has already been grabbed by another driver or canceled the ride.');</script>";
            echo "<script>window.location.href = 'passenger.php'</script>";
            exit();
        }

        $driver_grab_count = mysqli_query($connection, "SELECT SUM(quantity) AS count FROM grab WHERE driver='$driver'");
        $count_row = mysqli_fetch_assoc($driver_grab_count);
        $grab_count = $count_row['count'];

        if ($grab_count >= 4) {
            echo "<script>alert('You have reached the maximum number of Passengers (4).');</script>";
            echo "<script>window.location.href = 'passenger.php'</script>";
            exit();
        } else {
            $insert_query = "INSERT INTO grab (driver, username, profile, quantity) VALUES ('$driver', '$username', '$profile', '$quantity_value')";
            if (mysqli_query($connection, $insert_query)) {
                echo "<script>window.location.href = 'passenger.php'</script>";
                exit();
            } else {
                echo "Error inserting data: " . mysqli_error($connection);
            }
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "No user ID provided.";
}
mysqli_close($connection);
