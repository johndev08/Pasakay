<?php
session_start();
if (!isset($_SESSION['otp'])) {
    echo "<script>alert('Session expired! Please try again.'); window.location.href='./forgotPassword.php';</script>";
    exit;
}

if (isset($_POST['verify'])) {
    $entered_otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);

    if ($entered_otp == $_SESSION['otp']) {

        echo "<script>alert('OTP verified successfully!'); 
                    window.location.href='./changepassword.php';
                </script>";
    } else {
        echo "<script>alert('Invalid OTP! Please try again.');</script>";
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
    <title>Confirm OTP</title>
    <style>
        .input::-webkit-inner-spin-button{
            display: none;
        }
    </style>
</head>

<body class="content vh-100 d-flex justify-content-center align-items-center">
    <form action="" method="post" class="p-4 rounded w-100 m-4 source-sans shadow">
        <div class="d-grid m-auto w-100 " style="place-items:center">
            <img src="Images/tric.gif" alt="" width="80%">
        </div>
        <h4 class="oswald text-center mb-4">Forgot Password</h4>

        <p class="text-center m-0">Enter OTP</p>

        <input type="number" class=" input form-control shadow mb-2 border text-center" id="password" name="otp" aria-describedby="basic-addon1" required>

        <button type="submit" name="verify" class="btn btn-lg btn-success w-100 mb-2">Verify</button>
        <p class="text-center"><a href="./index.php" class="w-100 text-decoration-none">Back to log in</a></p>
        <br><br><br>
        <p class="text-center m-0"><sub>Do you have an account?</sub></p>
        <a href="./Register.php" class="btn btn-primary w-100">Sign up</a>
    </form>
</body>

</html>