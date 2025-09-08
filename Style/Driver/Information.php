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

<body>
    <?php
    session_start();
    $user_id = $_SESSION['admin_user_id'];
    $user_username = $_SESSION['admin_username'];
    include("../connection.php");
    include("../availability.php");
    $view_query = mysqli_query($connection, "SELECT * FROM admin WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }
    ?>

    <ul class="nav nav-underline nav-justified py-1 px-2 position-sticky top-0 bg-light shadow">
        <li class="nav-item">
            <a class="nav-link border-5" href="../Admin/dashboard.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                    <path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link border-5" href="../Admin/queue.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                    <path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                    <?php echo $av_driver ?>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active border-primary border-5" aria-current="page" >
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                    <path d="M280-600v-80h560v80H280Zm0 160v-80h560v80H280Zm0 160v-80h560v80H280ZM160-600q-17 0-28.5-11.5T120-640q0-17 11.5-28.5T160-680q17 0 28.5 11.5T200-640q0 17-11.5 28.5T160-600Zm0 160q-17 0-28.5-11.5T120-480q0-17 11.5-28.5T160-520q17 0 28.5 11.5T200-480q0 17-11.5 28.5T160-440Zm0 160q-17 0-28.5-11.5T120-320q0-17 11.5-28.5T160-360q17 0 28.5 11.5T200-320q0 17-11.5 28.5T160-280Z" />
                    <?php echo $av_passenger ?>
                </svg>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link border-5 "  href="../Admin/manageaccount.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                    <path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z" />
                </svg>
            </a>
        </li>
    </ul>

    <h1 class="text-center oswald mt-2">Users Information</h1>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-East" role="tabpanel" aria-labelledby="pills-East-tab" tabindex="0">
            <div class="container dashcontent pb-2">
                <?php
                $user = $_GET['fname'];
                $view_user = mysqli_query($connection, "SELECT * FROM passenger WHERE username='$user'");
                while ($row = mysqli_fetch_assoc($view_user)) {
                    $user_id = $row["id"];
                    $db_profile = $row['profile'];
                    $db_name = $row['fname'];
                    $db_age = $row['age'];
                    $db_gender = $row['gender'];
                    $db_contact = $row['contact'];
                    $db_street = $row['street'];
                    $username = $row['username'];
                ?>
                    <div class="border rounded p-5 m-3 shadow">
                        <center>
                            <div class="pic border rounded overflow-hidden mb-2" style="width:200px; height:200px;">
                                <img src="../Images/<?php echo $db_profile ?>" alt="" style="width:100%; height:100%;">
                            </div>
                            <?php echo "@" . $username; ?>
                        </center>

                        <label class="form-label w-100">Name: <?php echo $db_name; ?></label>
                        <label class="form-label w-100">Age: <?php echo $db_age; ?></label>
                        <label class="form-label w-100">Genger: <?php echo $db_gender; ?></label>
                        <label class="form-label w-100">Contact: <?php echo $db_contact; ?></label>
                        <label class="form-label w-100">Access: Passenger</label>
                        <label class="form-label w-100 mb-3">Permit No: <?php echo $db_street; ?></label>
                        <a href="#" onclick="goBack()" class="btn btn-primary mt-2 w-100">Back</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script src="../JavaScript/script.js"></script>

</body>

</html>