<?php
include("../connection.php");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $contact = $_GET['contact'];

    if (isset($_GET['action']) && $_GET['action'] === 'accept') {

        $description = "Good day! PASAKAY and we would like to inform you that your registration request as driver has been approved.";
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'e9944294311f3a56b5078420508c6a63', //Your API KEY
            'number' => '' . $contact . '',
            'message' => $description,
            'sendername' => 'THESIS'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);


        $access = 'driver';
        $update_query = $connection->prepare("UPDATE users SET access = ? WHERE id = ?");
        $update_query->bind_param("si", $access, $user_id);

        if ($update_query->execute()) {
            echo "<script>alert('User successfully accepted as driver!');</script>";
            echo "<script>window.location.href='./manageaccount.php'</script>";
        } else {
            echo "<script>alert('Failed to update user access!');</script>";
        }
        $update_query->close();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'decline') {


        $description = "Good day! PASAKAY and we would like to inform you that your registration request as driver has been declined.";
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'e9944294311f3a56b5078420508c6a63', //Your API KEY
            'number' => '' . $contact . '',
            'message' => $description,
            'sendername' => 'THESIS'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        $delete_query = $connection->prepare("DELETE FROM users WHERE id = ?");
        $delete_query->bind_param("i", $user_id);

        if ($delete_query->execute()) {
            echo "<script>alert('User successfully deleted!');</script>";
            echo "<script>window.location.href='./manageaccount.php'</script>";
        } else {
            echo "<script>alert('Failed to delete user!');</script>";
        }
        $delete_query->close();
    } else {
        echo "<script>alert('Invalid action!');</script>";
    }
}
