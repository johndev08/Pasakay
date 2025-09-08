<?php
session_start();
include("../connection.php");
include("./nav.php");

$user_id = $_SESSION['id'];
$user_username = $_SESSION['username'];

// Fetch the driver associated with the current user
$grab_query = mysqli_query($connection, "SELECT * FROM grab WHERE username='$user_username'");
$row = mysqli_fetch_assoc($grab_query);
$dname = $row['driver'];

// Fetch the QR code image name for the driver
$user_query = mysqli_query($connection, "SELECT * FROM users WHERE username='$dname'");
$row2 = mysqli_fetch_assoc($user_query);
$qr1 = $row2['qr1'];
$qr2 = $row2['qr2'];

// Handle GCash Proof Upload
if (isset($_POST['sendgcash'])) {
    $uploadDir = '../images/';
    $fileName = basename($_FILES['gcashproof']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['gcashproof']['tmp_name'], $uploadFilePath)) {
        $query = "UPDATE grab SET proof='$fileName', p_method='G Cash' WHERE username='$user_username'";
        if (mysqli_query($connection, $query)) {
            echo "<script>alert('Payment proof uploaded successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update payment in the database.');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload the GCash proof.');</script>";
    }
}

// Handle Maya Proof Upload
if (isset($_POST['sendmaya'])) {
    $uploadDir = '../images/';
    $fileName = basename($_FILES['mayaproof']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['mayaproof']['tmp_name'], $uploadFilePath)) {
        $query = "UPDATE grab SET proof='$fileName', p_method='Maya' WHERE username='$user_username'";
        if (mysqli_query($connection, $query)) {
            echo "<script>alert('Payment proof uploaded successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update payment in the database.');</script>";
        }
    } else {
        echo "<script>alert('Failed to upload the Maya proof.');</script>";
    }
}

if (isset($_POST['set_cash'])) {
    // Update the database to set p_method to "Cash" and proof to "N/A"
    $update_query = "UPDATE grab SET p_method='Cash', proof='N/A' WHERE username='$user_username'";
    if (mysqli_query($connection, $update_query)) {
        echo "<script>alert('Payment method set to Cash successfully.');</script>";
    } else {
        echo "<script>alert('Failed to update payment method. Please try again.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver QR Code</title>
</head>

<body>
    <h1 class="text-center oswald mt-2">Select Payment</h1>
    <div class="m-4">
        <form method="POST" action="">
            <!-- <button type="submit" class="mb-3 btn btn-lg btn-primary w-100" name="set_cash" onclick='return confirm(`Are you sure you want to pay cash?`)'>Cash</button> -->
             <input type="submit" value="Cash" class="mb-3 btn btn-lg btn-primary w-100" name="set_cash" onclick='return confirm(`Are you sure you want to pay cash?`)'>
        </form>
        <button class="mb-3 btn btn-lg btn-success w-100" popovertarget="gcash">G Cash</button>
        <button class="mb-3 btn btn-lg btn-primary w-100" popovertarget="maya">Maya</button>
        <a href="./passenger.php" class="btn  btn-warning w-100 text-decoration-none mt-4 ">Cancel</a>

    </div>
    <form method="POST" enctype="multipart/form-data" action="" id="gcash" class="position-absolute top-50 start-50 translate-middle p-3 border shadow rounded" popover style="width: 90%;">
        <h3>Scan <?php echo $dname ?>'s G Cash</h3>
        <img src="../images/<?php echo htmlspecialchars($qr1); ?>" alt="Driver QR Code" width="100%">
        <label for="gcashproof">Proof:</label>
        <input type="file" name="gcashproof" id="gcashproof">
        <input type="submit" value="Send proof" class="btn btn-success w-100 mt-3" name="sendgcash">
    </form>
    <form method="POST" enctype="multipart/form-data" action="" id="maya" class="position-absolute top-50 start-50 translate-middle p-3 border shadow rounded" popover style="width: 90%;">
        <h3>Scan <?php echo $dname ?>'s Maya</h3>
        <img src="../images/<?php echo htmlspecialchars($qr2); ?>" alt="Driver QR Code" width="100%">
        <label for="mayaproof">Proof:</label>
        <input type="file" name="mayaproof" id="mayaproof">
        <input type="submit" value="Send proof" class="btn btn-success w-100 mt-3" name="sendmaya">
    </form>

</body>

</html>