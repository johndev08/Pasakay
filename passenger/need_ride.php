
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/bootstrap.min.css">
    <script src="../JavaScript/bootstrap.min.js"></script>
    <title>Passenger</title>
</head>

<body class="position-relative">
    <?php
    session_start();
    include("../availability.php");
    include("./nav.php");
    $user_id = $_SESSION['id'];
    $user_username = $_SESSION['username'];
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }
    $fare_query = mysqli_query($connection, "SELECT * FROM fare");
    ?>
<?php
include("../connection.php");
$user_id = $_SESSION["id"];
$user_username = $_SESSION['username'];

$get_record = mysqli_query($connection, "SELECT * FROM users WHERE username='$user_username'");
$row = mysqli_fetch_assoc($get_record);
$fname = $row["fname"];
$profile = $row['profile'];
$username = $row['username'];
$destination = $_POST['need_ride'];
$quantity = $_POST['quantity'];
$fare = $_POST['fare'];


$action = isset($_GET["action"]) ? $_GET["action"] : "";


// $paymongo_secret_key = 'sk_test_Lbk9LqZx2dJyqrLjM5bKPHM7';

// function createPaymentLink($amount, $description, $currency = 'PHP') {
//     global $paymongo_secret_key;

//     $url = "https://api.paymongo.com/v1/links";


//     $data = [
//         'data' => [
//             'attributes' => [
//                 'amount' => $amount, 
//                 'description' => $description,
//                 'currency' => $currency,
//             ]
//         ]
//     ];

//     $ch = curl_init($url);


//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Authorization: Basic ' . base64_encode($paymongo_secret_key . ':'),
//         'Content-Type: application/json',
//     ]);
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


//     $response = curl_exec($ch);
//     curl_close($ch);


//     return json_decode($response, true);
// }
// $date = date('Y-m-d');
// if($fare < 1) {
//  $fare = 100;
 
// $description = "Order #".$payment_id." - Payment for Pasakay Fare";
// $response = createPaymentLink(10000, $description);
// } elseif($fare < 100 && $fare > 1)  {
    
// 	$payment_link = '<a href="./index.php"  class="btn btn-primary">Continue</a>';
    
// }

// else {
// //echo $fare;
// 	$am = str_replace(".", "", $fare);
// 	$payment_id = rand(1000000,9999999);
// 	$am = intval($am."");
// $amount = $am; 
// $amount1 == $am.'000';
// $amount = $fare;
// $formattedAmount = explode(".", $amount)[0].'00';

// $s = (int)$formattedAmount; // Output: "100 PHP"
// $description = "Order #".$payment_id." - Payment for Pasakay Fare";
// $response = createPaymentLink($s, $description);
// }
// if (isset($response['data'])) {
//     $paymentLink = $response['data']['attributes']['checkout_url'];
	
// 	$parsedUrl = parse_url($paymentLink, PHP_URL_PATH);
// 	$pathParts = explode('/', $parsedUrl);
// 	$paymentLinkId = end($pathParts);


// 	$payment_link = '<a href="'.$paymentLink.'" target="_blank" class="btn btn-primary">Click here to pay for the fare</a>';
    
// }
		
//end payment

if ($action == 'joineast') {
    $availability = 'east-passenger';
} elseif ($action == 'joinwest') {
    $availability = 'west-passenger';
} elseif ($action == 'joinlemery') {
    $availability = 'lemery-passenger';
} else {
    echo "<script>alert ('Invalid action!');</script>";
    echo "<script>window.location.href='./passenger.php'</script>";
    exit; 
}

if (isset($availability)) {
    $query = $connection->prepare('UPDATE users SET availability = ?, destination = ?, quantity = ?, fare = ? WHERE id=?');
    $query->bind_param("sssii", $availability, $destination, $quantity, $fare, $user_id);

    if ($query->execute()) {
       echo "<script>alert ('Successfully Joined!');</script>";
       echo "<script>window.location.href='./passenger.php'</script>";
    } else {
        echo "<script>alert ('Join Failed! Please try again.');</script>";
        echo "<script>window.location.href='./passenger.php'</script>";
    }
}
?>
    <!-- <h1 class="text-center oswald mt-2">Successfully Joined</h1>
  
   <br>
   <br>
   <br>
   <br>
   <br><center>
   <?PHP
   echo $payment_link
   ?> -->
    <script src="../Javascript/script.js"></script>
</body>

</html>