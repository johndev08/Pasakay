<?php
session_start();
include '../connection.php';

$user_username = $_SESSION['username'];

// Get all grab records for the current driver
$grab_query = mysqli_query($connection, "SELECT * FROM grab WHERE driver='$user_username'");


//echo $user_username;
//get all  user
$r = mysqli_query($connection, "SELECT * FROM users WHERE username = '$user_username'");
while ($row = mysqli_fetch_array($r)) {
	$avail = $row['availability'];
	if ($avail == "east-driver") {
		$t = "east-passenger";
	} elseif ($avail == "west-driver") {
		$t = "west-passenger";
	} else {
		$t = "lemery-passenger";
	}
	//echo $t;
}
$r1 = mysqli_query($connection, "SELECT * FROM users WHERE availability = '$t'");
while ($row1 = mysqli_fetch_array($r1)) {

	$contact = $row1['contact'];
	//echo $contact;
	$description = "Good day! PASAKAY would like to inform you that the driver has departed.";

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
}
//end get

// Prepare statements for updating driver and passenger availability
$remove_driver_stmt = $connection->prepare("UPDATE users SET availability = ? WHERE username = ?");
$remove_passenger_stmt = $connection->prepare("UPDATE users SET availability = ? WHERE username = ?");

// Set the availability value
$availability = '';

// Update driver availability
if (!$remove_driver_stmt->execute([$availability, $user_username])) {
    echo "<script>alert('Failed to remove driver from grab!');</script>";
} else {
    // Process each grab record to update passenger availability
    $allPassengersUpdated = true; // Flag to track if all passenger updates are successful
    while ($row = mysqli_fetch_assoc($grab_query)) {
        $name = $row['username'];
        if (!$remove_passenger_stmt->execute([$availability, $name])) {
            $allPassengersUpdated = false; // Set flag to false if any update fails
            echo "<script>alert('Failed to remove passenger from grab!');</script>";
        }
    }

    // Check if all updates succeeded
    if ($allPassengersUpdated) {
        echo "<script>alert('Depart Successfully.');</script>";
        echo "<script>window.location.href = './passenger.php';</script>";
    }
}

// Close statements and connection
$remove_driver_stmt->close();
$remove_passenger_stmt->close();
$connection->close();
