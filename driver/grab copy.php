<?php
session_start();
include '../connection.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $driver = $_SESSION['username'];

    // Fetch user details
    $user_query = mysqli_query($connection, "SELECT username, profile, quantity FROM users WHERE id = '$user_id'");
    if ($row = mysqli_fetch_assoc($user_query)) {
        $username = $row['username'];
        $profile = $row['profile'];
        $quantity = $row['quantity']; // Original quantity from the user

        // Check if the passenger has already been grabbed
        $check_grab = mysqli_query($connection, "SELECT * FROM grab WHERE username='$username'");
        if (mysqli_num_rows($check_grab) > 0) {
            echo "<script>alert('This passenger has already been grabbed by another driver.');</script>";
            echo "<script>window.location.href = 'passenger.php'</script>";
            exit();
        }

        // Check the number of passengers the driver has grabbed
        $driver_grab_count = mysqli_query($connection, "SELECT COUNT(*) AS total FROM grab WHERE driver='$driver'");
        $count_row = mysqli_fetch_assoc($driver_grab_count);
        $current_grabs = $count_row['total'];

        // Check if the driver has reached the maximum number of grabs
        if ($current_grabs >= 4) {
            echo "<script>alert('You have reached the maximum number of passengers (4).');</script>";
            echo "<script>window.location.href = 'passenger.php'</script>";
            exit();
        }

        // Insert the grab if the limit is not reached
        $insert_query = "INSERT INTO grab (driver, username, profile, quantity) VALUES ('$driver', '$username', '$profile', '$quantity')";
        if (mysqli_query($connection, $insert_query)) {
            // Successfully grabbed the passenger
            echo "<script>alert('Passenger grabbed successfully!');</script>";
            echo "<script>window.location.href = 'passenger.php'</script>";
            exit();
        } else {
            echo "Error inserting data: " . mysqli_error($connection);
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "No user ID provided.";
}

mysqli_close($connection);
