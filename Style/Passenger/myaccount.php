<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../Style/bootstrap.min.css">
    <script src="../JavaScript/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Style/Style.css">
    <title>Profile</title>
</head>

<body class="content d-flex justify-content-center align-items-center">
    <?php
    $user_id = $_REQUEST["id"];
    $get_record = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($get_record)) {
        $profile = $row['profile'];
        $user_id = $row['id'];
        $name = $row["fname"];
        $age = $row['age'];
        $gender = $row['gender'];
        $contact = $row['contact'];
        $permit = $row['address_permit'];
        $username = $row["username"];
    }
    ?>
    <div class="border rounded p-5 m-3 w-100 shadow">
        <center>
            <div class="pic border rounded overflow-hidden mb-2" style="width:150px; height:150px;">
                <img src="../Images/<?php echo $profile ?>" alt="" style="width:100%; height:100%;">
            </div>
            <sup>@<?php echo $username; ?></sup>
        </center>
        <label class="form-label w-100">Name: <?php echo $name; ?></label>
        <label class="form-label w-100">Age: <?php echo $age; ?></label>
        <label class="form-label w-100">Genger: <?php echo $gender; ?></label>
        <label class="form-label w-100">Contact: <?php echo $contact; ?></label>
        <label class="form-label w-100">Access: Passenger</label>
        <label class="form-label w-100 mb-3">Permit No: <?php echo $permit; ?></label>
        <center>
            <a href="../logout.php?id=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to log out?')" class="btn btn-danger w-100">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                </svg>
                Logout
            </a>
            <a href="../passenger/index.php" class="btn btn-primary mt-2 w-100">Back</a>
        </center>
    </div>
</body>

</html>