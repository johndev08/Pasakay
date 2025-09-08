<?php
session_start();
include("../connection.php");

if ($_GET['id']) {
    $id = $_GET['id'];

    $delete_grab = $connection->prepare("DELETE FROM grab WHERE id = ?");
    $delete_grab->bind_param("i", $id);

   $delete_grab->execute();
 

    echo "<script>window.location.href='./passenger.php'</script>";
}
?>
