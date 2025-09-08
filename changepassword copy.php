<?php
session_start();
include("./connection.php");  // Make sure you include your database connection file

// Check if OTP has been verified before allowing password change
// if (!isset($_SESSION['mobile_number']) || !isset($_SESSION['otp'])) {
//     echo "<script>alert('Session expired! Please try again.'); 
//                 window.location.href='./forgot.php';
//             </script>";
//     exit;
// }

if (isset($_POST['confirm'])) {
    $new_password = $_POST['newpassword'];
    $confirm_password = $_POST['confirmnewpassword'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Sanitize mobile number (crucial if it comes from user input earlier)
        $mobile_number = mysqli_real_escape_string($connection, $_SESSION['mobile_number']);

        // Hash the password using a strong algorithm (example with bcrypt)
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $connection->prepare("UPDATE users SET password = ? WHERE contact = ?");
        $stmt->bind_param("ss", $hashed_password, $mobile_number);

        if ($stmt->execute()) {
            echo "<script>alert('Changing password successfully!'); 
                        window.location.href='./changepassword.php';
                    </script>";
            unset($_SESSION['otp']);
            unset($_SESSION['mobile_number']);
        } else {
            // Log the error for debugging
            error_log("Error updating password: " . $stmt->error);
            echo "<script>alert('Error updating password. Please try again.');</script>";
        }

        $stmt->close();
        $connection->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/bootstrap.min.css">
    <script src="./JavaScript/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./Style/Style.css">
    <title>Change Password</title>
</head>

<body class="content vh-100 d-flex justify-content-center align-items-center">
    <form action="" method="post" class="p-4 rounded w-100 m-4 source-sans shadow">
        <div class="d-grid m-auto w-100" style="place-items:center">
            <img src="Images/tric.gif" alt="" width="80%">
        </div>
        <h1 class="oswald text-center mb-5">Change Password</h1>

        <label class="form-label m-0">Enter New Password</label>
        <div class="input-group mb-2">
            <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                    <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                </svg>
            </span>
            <input type="password" class="form-control" id="newpassword" name="newpassword" aria-describedby="basic-addon1" required>
        </div>
        <label class="m-0">Confirm Password</label>
        <div class="input-group mb-2">
            <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                    <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                </svg>
            </span>
            <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword" aria-describedby="basic-addon1" required>
        </div>
        <div class="w-100">
            <input type="checkbox" name="chk" id="chk">
            <label for="chk">Show password</label>
        </div>
        <button type="submit" name="confirm" class="btn btn-lg btn-success w-100 mb-2 mt-5">Confirm</button>
        <p class="text-center"><a href="./index.php" class="w-100 text-decoration-none">Cancel</a></p>
    </form>
    <script>
        document.getElementById('chk').addEventListener('change', function() {
            const passwordFields = document.querySelectorAll('input[type="password"]'); // Select all password fields
            passwordFields.forEach(field => {
                field.type = this.checked ? 'text' : 'password';
            });
        });
    </script>
</body>

</html>