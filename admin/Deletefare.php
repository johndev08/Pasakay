<?php
include("../connection.php");

if (isset($_GET['id'])) {
    $fare_id = $_GET['id'];
    $deletefare = mysqli_query($connection, "DELETE FROM fare WHERE id='$fare_id'");

    if ($deletefare) {
        echo "<script>alert('Fare Has been Deleted...');</script>";
    } else {
        echo "<script>alert('Failed to delete fare.');</script>";
    }
    echo "<script>window.location.href='./dashboard.php';</script>";
} else {
    echo "<script>alert('Invalid request.');</script>";
    echo "<script>window.location.href='./dashboard.php';</script>";
}
