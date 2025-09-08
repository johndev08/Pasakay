<?php
session_start();
include("../connection.php");

$user_id = $_REQUEST["id"]; // Retrieve the user's ID

// Fetch user details
$get_record = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($get_record);

if (!$user) {
    echo "<script>alert('User not found'); window.location.href='./index.php';</script>";
    exit();
}

// Update logic when form is submitted
if (isset($_POST["update-profile"])) {
    $name = $_POST["fname"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $contact = $_POST["contact"];
    $username = $_POST["username"];

    $allowedExtensions = ["jpg", "jpeg", "png"];

    //Improved File handling function with error checking
    function handleFileUpload($file, $currentFile, $targetDir, $allowedExtensions)
    {
        $newFileName = $currentFile; // Default: keep the current file
        if (!empty($file["name"])) {
            $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = uniqid() . "." . $fileExtension;
                $targetFilePath = $targetDir . $newFileName;
                if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                    //Success!
                    return $newFileName;
                } else {
                    error_log("Error uploading file: " . $file["name"] . " to " . $targetFilePath . " - " . error_get_last()['message']);
                    echo "<script>alert('Error uploading " . $file["name"] . "');</script>";
                }
            } else {
                echo "<script>alert('Invalid file format for " . $file["name"] . "');</script>";
            }
        }
        return $newFileName; //Return original filename if no upload or error
    }


    // Handle profile picture, license, permit, tricycle picture, QR1, and QR2
    $profilePath = handleFileUpload($_FILES["profile"], $user["profile"], "../Images/", $allowedExtensions);
    $licensePath = handleFileUpload($_FILES["license"], $user["license"], "../Images/", $allowedExtensions);
    $permitPath = handleFileUpload($_FILES["permit"], $user["address_permit"], "../Images/", $allowedExtensions);
    $tricyclePath = handleFileUpload($_FILES["tricycle_picture"], $user["tricycle_picture"], "../Images/", $allowedExtensions);
    $qr1Path = handleFileUpload($_FILES["qr1"], $user["qr1"], "../Images/", $allowedExtensions);
    $qr2Path = handleFileUpload($_FILES["qr2"], $user["qr2"], "../Images/", $allowedExtensions);

    // Update query
    $update_query = "UPDATE users SET fname=?, age=?, gender=?, contact=?, username=?, profile=?, license=?, address_permit=?, tricycle_picture=?, qr1=?, qr2=? WHERE id=?";
    $stmt = mysqli_prepare($connection, $update_query);
    mysqli_stmt_bind_param(
        $stmt,
        "sisssssssssi",
        $name,
        $age,
        $gender,
        $contact,
        $username,
        $profilePath,
        $licensePath,
        $permitPath,
        $tricyclePath,
        $qr1Path,
        $qr2Path,
        $user_id
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href='./myaccount.php?id=$user_id';
              </script>";
    } else {
        $error = mysqli_stmt_error($stmt);
        error_log("Error updating profile: " . $error);
        echo "<script>alert('Error updating profile: " . $error . "');</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection); //Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/bootstrap.min.css">
    <script src="./javascript/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Style/Style.css">
    <title>Edit Profile</title>
</head>

<body class="content d-flex justify-content-center align-items-center">
    <div class="border rounded p-4 overflow-auto m-3 w-100 shadow" style="height: 95%;">
        <h3 class="text-center mb-4">Edit Profile</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Male" <?php echo $user['gender'] == "Male" ? "selected" : ""; ?>>Male</option>
                    <option value="Female" <?php echo $user['gender'] == "Female" ? "selected" : ""; ?>>Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="profile" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile" name="profile">
                <small>Current: <img src="../Images/<?php echo $user['profile']; ?>" alt="Profile" style="width:50px; height:50px;"></small>
            </div>
            <div class="mb-3">
                <label for="license" class="form-label">License</label>
                <input type="file" class="form-control" id="license" name="license">
                <small>Current: <img src="../Images/<?php echo $user['license']; ?>" alt="License" style="width:50px; height:50px;"></small>
            </div>
            <div class="mb-3">
                <label for="permit" class="form-label">Permit</label>
                <input type="file" class="form-control" id="permit" name="permit">
                <small>Current: <img src="../Images/<?php echo $user['address_permit']; ?>" alt="Permit" style="width:50px; height:50px;"></small>
            </div>
            <div class="mb-3">
                <label for="tricycle_picture" class="form-label">Tricycle Picture</label>
                <input type="file" class="form-control" id="tricycle_picture" name="tricycle_picture">
                <small>Current: <img src="../Images/<?php echo $user['tricycle_picture']; ?>" alt="Tricycle" style="width:50px; height:50px;"></small>
            </div>
            <div class="mb-3">
                <label for="qr1" class="form-label">G Cash Qr</label>
                <input type="file" class="form-control" id="qr1" name="qr1">
                <small>Current: <img src="../Images/<?php echo $user['qr1']; ?>" alt="QR1" style="width:50px; height:50px;"></small>
            </div>
            <div class="mb-3">
                <label for="qr2" class="form-label">Maya Qr</label>
                <input type="file" class="form-control" id="qr2" name="qr2">
                <small>Current: <img src="../Images/<?php echo $user['qr2']; ?>" alt="QR2" style="width:50px; height:50px;"></small>
            </div>
            <button type="submit" name="update-profile" class="btn btn-primary w-100">Update Profile</button>
        </form>
        <a href="./myaccount.php?id=<?php echo $user_id; ?>" class="btn btn-secondary mt-3 w-100">Back to Profile</a>
    </div>
</body>

</html>