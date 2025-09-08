<?php
include('../connection.php');

if (isset($_GET['action']) && $_GET['action'] == 'remove_east_driver') {
    $user_id = $_GET['id'];
    $availability = '';
    $remove_driver = $connection->prepare("UPDATE users SET availability = ? WHERE id= ?");
    $remove_driver->bind_param("si", $availability, $user_id);
    if ($remove_driver->execute()) {
        echo "<script>alert('Driver has been Removed From Queue...');</script>";
        echo "<script>window.location.href='./Queue.php';</script>";
    } else {
        echo "<script>alert('Failed to remove Driver.');</script>";
        echo "<script>window.location.href='./Queue.php';</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'remove_west_driver') {
    $user_id = $_GET['id'];
    $availability = '';
    $remove_driver = $connection->prepare("UPDATE users SET availability = ? WHERE id= ?");
    $remove_driver->bind_param("si", $availability, $user_id);
    if ($remove_driver->execute()) {
        echo "<script>alert('Driver has been Removed From Queue...');</script>";
        echo "<script>window.location.href='./Queue.php';</script>";
    } else {
        echo "<script>alert('Failed to remove Driver.');</script>";
        echo "<script>window.location.href='./Queue.php';</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'remove_lemery_driver') {
    $user_id = $_GET['id'];
    $availability = '';
    $remove_driver = $connection->prepare("UPDATE users SET availability = ? WHERE id = ?");
    $remove_driver->bind_param("si", $availability, $user_id);
    if ($remove_driver->execute()) {
        echo "<script>alert('Driver has been Removed From Queue...');</script>";
        echo "<script>window.location.href='./Queue.php';</script>";
    } else {
        echo "<script>alert('Failed to remove Driver.');</script>";
        echo "<script>window.location.href='./Queue.php';</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'remove_east_passenger') {
    $user_id = $_GET['id'];
    $availability = '';
    $remove_passenger = $connection->prepare("UPDATE users SET availability = ? WHERE id = ?");
    $remove_passenger->bind_param("si", $availability, $user_id);
    if ($remove_passenger->execute()) {
        echo "<script>alert('Passenger has been Removed From Queue...');</script>";
        echo "<script>window.location.href='./passenger.php';</script>";
    } else {
        echo "<script>alert('Failed to remove Passenger.');</script>";
        echo "<script>window.location.href='./passenger.php';</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'remove_west_passenger') {
    $user_id = $_GET['id'];
    $availability = "";
    $remove_passenger = $connection->prepare("UPDATE users SET availability = ? WHERE id = ?");
    $remove_passenger->bind_param("si", $availability, $user_id);
    if ($remove_passenger->execute()) {
        echo "<script>alert('Passenger has been Removed From Queue...');</script>";
        echo "<script>window.location.href='./passenger.php';</script>";
    } else {
        echo "<script>alert('Failed to remove Passenger.');</script>";
        echo "<script>window.location.href='./passenger.php';</script>";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'remove_lemery_passenger') {
    $user_id = $_GET['id'];
    $availability = "";
    $remove_passenger = $connection->prepare("UPDATE users SET availability = ? WHERE id = ?");
    $remove_passenger->bind_param("si", $availability, $user_id);
    if ($remove_passenger->execute()) {
        echo "<script>alert('Passenger has been Removed From Queue...');</script>";
        echo "<script>window.location.href='./passenger.php';</script>";
    } else {
        echo "<script>alert('Failed to remove Passenger.');</script>";
        echo "<script>window.location.href='./passenger.php';</script>";
    }
} else {
    echo "<script>alert('Invalid action.');</script>";
    echo "<script>window.location.href='./dashboard.php';</script>";
}
