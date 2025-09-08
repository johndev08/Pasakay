<?php
include("../connection.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    if (isset($_GET['action']) && $_GET['action'] === 'accept') {
        $access = 'passenger';
        $update_query = $connection->prepare("UPDATE users SET access = ? WHERE id = ?");
        $update_query->bind_param("si", $access, $user_id);

        if ($update_query->execute()) {
            echo "<script>alert('User successfully accepted as driver!');</script>";
            echo "<script>window.location.href='../Admin/manageaccount.php'</script>";
        } else {
            echo "<script>alert('Failed to update user access!');</script>";
        }
        $update_query->close();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'decline') {
        $delete_query = $connection->prepare("DELETE FROM users WHERE id = ?");
        $delete_query->bind_param("i", $user_id);

        if ($delete_query->execute()) {
            echo "<script>alert('User successfully deleted!');</script>";
            echo "<script>window.location.href='../Admin/manageaccount.php'</script>";
        } else {
            echo "<script>alert('Failed to delete user!');</script>";
        }
        $delete_query->close();
    } else {
        echo "<script>alert('Invalid action!');</script>";
    }
}
