<?php
session_start();
if (isset($_POST['login'])) {
    include('connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $access = $row['access'];

            if ($access == 'admin') {
                echo '<script>window.location="./admin/index.php"</script>';
            } elseif ($access == 'driver') {
                echo '<script>window.location="./driver/index.php"</script>';
            } elseif ($access == 'passenger') {
                echo '<script>window.location="./passenger/index.php"</script>';
            } else {
                echo '<script>alert("User Does not Exist!");</script>';
            }
        } else {
            echo '<script>alert("Username or password is incorrect...")</script>';
        }
    } else {
        echo '<script>alert("Username or password is incorrect...")</script>';
    }

    $stmt->close();
    $connection->close();
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
    <title>Login</title>
</head>

<body class="content vh-100 d-flex justify-content-center align-items-center">
    <form action="" method="post" class="p-4 rounded w-100 m-4 source-sans shadow">
        <img src="Images/tric.gif" alt="" width="120px" class=" w-100">
        <h1 class="oswald text-center">Login</h1>

        <label for="username">Username</label><br>
        <div class="input-group mb-2">
            <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                </svg>
            </span>
            <input type="text" class="form-control" id="username" name="username" aria-describedby="basic-addon1" required>
        </div>

        <label for="password">Password</label><br>
        <div class="input-group mb-2">
            <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                    <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                </svg>
            </span>
            <input type="password" class="form-control" id="password" name="password" aria-describedby="basic-addon1" required>
        </div>

        <div class="d-flex justify-content-between">
            <div class="w-50">
                <input type="checkbox" name="chk" id="chk">
                <label for="chk">Show password</label>
            </div>
            <a href="./forgot.php" class="w-50 text-end text-decoration-none">Forgot Password?</a><br><br>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">
            <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z" />
            </svg> -->
            Login
        </button><br>
        <center>or<br><a href="./Register.php">Create new Account</a></center>
    </form>
    <script src="Javascript/script.js"></script>
    <script>
        const pwd = document.getElementById("password");
        const chk = document.getElementById("chk");

        chk.onchange = function(e) {
            pwd.type = chk.checked ? "text" : "password";
        };
    </script>
</body>

</html>