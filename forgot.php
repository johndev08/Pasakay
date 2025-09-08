<?php
if (isset($_POST['send'])) {
    session_start();
    include('./connection.php');

    $mobile_number = $_POST['otp'];

    // Validate mobile number format
    if (!preg_match('/^[0-9]{10,15}$/', $mobile_number)) {
        echo "<script>alert('Invalid mobile number!');</script>";
        exit;
    }

    // Check if mobile number exists in the database
    $checkNumberQuery = "SELECT * FROM users WHERE contact = ?";
    $stmt = mysqli_prepare($connection, $checkNumberQuery);
    mysqli_stmt_bind_param($stmt, "s", $mobile_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        echo "<script>alert('Mobile number not found!');</script>";
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    // Generate and send OTP
    $api_key = "485800cffee50c349559ffdde669afb1";
    // $api_key = "e9944294311f3a56b5078420508c6a63";
    $otp = rand(100000, 999999);
    $message = "Your OTP is: $otp";
    $url = "https://api.semaphore.co/api/v4/messages";

    $data = [
        'apikey' => $api_key,
        'number' => $mobile_number,
        'message' => $message,
        // 'sendername' => 'THESIS',
        'sendername' => 'DULANGAN',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'cURL Error: ' . curl_error($ch);
        curl_close($ch);
        exit;
    }
    curl_close($ch);

    $result = json_decode($response, true);
    echo "<pre>";
    print_r($result); // Log the result
    echo "</pre>";

    if (isset($result[0]['status']) && $result[0]['status'] === 'Pending') {
        $_SESSION['otp'] = $otp;
        $_SESSION['mobile_number'] = $mobile_number;
        header("Location: ./confirmOTP.php");
        exit;
    } else {
        echo "<script>alert('Failed to send OTP: " . htmlspecialchars($result[0]['message'] ?? 'Unknown error') . "');</script>";
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
    <title>Forgot Password</title>
    <style>
        .input::-webkit-inner-spin-button {
            display: none;
        }
    </style>
</head>

<body class="content vh-100 d-flex justify-content-center align-items-center">
    <form action="" method="post" class="p-4 rounded w-100 m-4 source-sans shadow">
        <div class="d-grid m-auto w-100 " style="place-items:center">
            <img src="Images/tric.gif" alt="" width="80%">
        </div>
        <h1 class="oswald text-center mb-5">Forgot Password</h1>

        <p class="text-center m-0">Enter mobile number</p>
        <div class="input-group mb-2">
            <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#000000">
                    <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                </svg>
            </span>
            <input type="number" class=" input form-control" id="password" name="otp" aria-describedby="basic-addon1" required>
        </div>
        <button type="submit" name="send" class="btn btn-lg btn-success w-100 mb-2">Send OTP</button>
        <p class="text-center"><a href="./index.php" class="w-100 text-decoration-none">Back to log in</a></p>
        <br><br><br>
        <p class="text-center"><sub>Do you have an account?</sub></p>
        <a href="./Register.php" class="btn btn-primary w-100">Sign up</a>
    </form>
</body>

</html>