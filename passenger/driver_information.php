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
    $user_id = $_SESSION['id'];
    $user_username = $_SESSION['username'];
    include("../connection.php");
    include("../availability.php");
    // $view_query = mysqli_query($connection, "SELECT * FROM admin WHERE id='$user_id'");
    // while ($row = mysqli_fetch_assoc($view_query)) {
    //     $user_id = $row["id"];
    // }
    include('./nav.php');
    ?>


    <h1 class="text-center oswald mt-2">User's Information</h1>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-East" role="tabpanel" aria-labelledby="pills-East-tab" tabindex="0">
            <div class="container dashcontent pb-2">
                <?php
                $user = $_GET['fname'];
                $view_user = mysqli_query($connection, "SELECT * FROM users WHERE fname='$user'");
                while ($row = mysqli_fetch_assoc($view_user)) {
                    $driver_id = $row["id"];
                    $db_profile = $row['profile'];
                    $db_name = $row['fname'];
                    $db_age = $row['age'];
                    $db_gender = $row['gender'];
                    $db_contact = $row['contact'];
                    $db_lincese = $row['license'];
                    $db_permit = $row['address_permit'];
                    $db_tricycle = $row['tricycle_picture'];
                    $db_username = $row['username'];
                    $db_password = $row['password'];
                    $unique_id = "credential_" . $driver_id; // Unique ID for each div
                ?>
                    <div class="border rounded p-5 m-3 shadow">
                        <center>
                            <div class="pic border rounded overflow-hidden mb-2" style="width:200px; height:200px;">
                                <img src="../Images/<?php echo $db_profile ?>" alt="" style="width:100%; height:100%;">
                            </div>
                            <?php echo "@" . $db_username; ?>
                        </center>

                        <label class="form-label w-100">Name: <?php echo $db_name; ?></label>
                        <label class="form-label w-100">Age: <?php echo $db_age; ?></label>
                        <label class="form-label w-100">Genger: <?php echo $db_gender; ?></label>
                        <label class="form-label w-100">Contact: <?php echo $db_contact; ?></label>
                        <label class="form-label w-100">Access: Driver</label>
                        <label class="form-label w-100 mb-3">Driver's License:</label>
                        <div class="pic border rounded overflow-hidden mb-2" style="width:250px; height:120px;">
                            <img src="../Images/<?php echo $db_lincese ?>" alt="" style="width:100%; height:100%;" onclick="openFullscreen(this)">
                        </div>
                        <label class="form-label">Tricycle Permit:</label>
                        <div class="pic border rounded overflow-hidden mb-2" style="width:250px; height:120px;">
                            <img src="../Images/<?php echo $db_permit ?>" alt="" style="width:100%; height:100%;" onclick="openFullscreen(this)">
                        </div>
                        <label class="form-label">Tricycle:</label>
                        <div class="pic border rounded overflow-hidden mb-2" style="width:250px; height:120px;">
                            <img src="../Images/<?php echo $db_tricycle ?>" alt="" style="width:100%; height:100%;" onclick="openFullscreen(this)">
                        </div>
                        <a href="./queue.php" class="btn btn-primary mt-2 w-100">Close</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script src="../Javascript/script.js"></script>
        <script>
            function openFullscreen(img) {
                if (img.requestFullscreen) {
                    img.requestFullscreen();
                } else if (img.mozRequestFullScreen) {
                    /* Firefox */
                    img.mozRequestFullScreen();
                } else if (img.webkitRequestFullscreen) {
                    /* Chrome, Safari & Opera */
                    img.webkitRequestFullscreen();
                } else if (img.msRequestFullscreen) {
                    /* IE/Edge */
                    img.msRequestFullscreen();
                }
            }
        </script>
</body>

</html>