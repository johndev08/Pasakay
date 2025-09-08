<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    include('nav.php');
    include("../connection.php");
    include('../availability.php');
    $user_id = $_SESSION['id'];
    $user_username = $_SESSION['username'];
    // $view_query = mysqli_query($connection, "SELECT * FROM admin WHERE id='$user_id'");
    // while ($row = mysqli_fetch_assoc($view_query)) {
    //     $user_id = $row["id"];
    // }
    ?>
    <h1 class="text-center oswald mt-2">Available Passengers</h1>
    <ul class="nav nav-pills nav-justified mb-3 mx-3 mt-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link position-relative active" id="pills-East-tab" data-bs-toggle="pill" data-bs-target="#pills-East" type="button" role="tab" aria-controls="pills-East" aria-selected="true">
                East
                <?php echo $east_passenger ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link position-relative" id="pills-West-tab" data-bs-toggle="pill" data-bs-target="#pills-West" type="button" role="tab" aria-controls="pills-West" aria-selected="false">
                West
                <?php echo $west_passenger ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link position-relative" id="pills-Lemery-tab" data-bs-toggle="pill" data-bs-target="#pills-Lemery" type="button" role="tab" aria-controls="pills-Lemery" aria-selected="false">
                Lemery
                <?php echo $lemery_passenger ?>
            </button>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-East" role="tabpanel" aria-labelledby="pills-East-tab" tabindex="0">
            <div class="container dashcontent pb-5">
                <?php
                $num = 0;
                if (mysqli_num_rows($east_passenger_query) > 0) {
                    while ($row = mysqli_fetch_assoc($east_passenger_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $username = $row['username'];
                        $destination = $row['destination'];
                        $quantity = $row['quantity'];
                        $fare_id = $row['fare'];
                        $num++;
                        $destination_display = empty($destination) ? "Unknown" : $destination;
                        $fare_display = empty($fare_id) || $fare_id == 0 ? "₱???" : "₱" . $fare_id;
                ?>
                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 20%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 20%;">
                                <?php echo $db_name; ?><br>
                                <sup class=" fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="py-2 px-2 text-nowrap" style="width: 40%;">
                                <?php echo $destination_display; ?><br>
                                <sup class=" fw-normal"><?php echo $quantity; ?></sup>
                                <sup class=" fw-normal"><?php echo $fare_display; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 20%;">
                                <a href="removeuser.php?id=<?php echo $user_id ?>&action=remove_east_passenger" onclick="return confirm('Are you sure you want to Remove this passenger from East?')" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h6 class="text-center">No passenger available in East</h6>';
                } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-West" role="tabpanel" aria-labelledby="pills-West-tab" tabindex="0">
        <div class="container dashcontent pb-5">
                <?php
                $num = 0;
                if (mysqli_num_rows($west_passenger_query) > 0) {
                    while ($row = mysqli_fetch_assoc($west_passenger_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $username = $row['username'];
                        $destination = $row['destination'];
                        $quantity = $row['quantity'];
                        $fare_id = $row['fare'];
                        $num++;
                        $destination_display = empty($destination) ? "Unknown" : $destination;
                        $fare_display = empty($fare_id) || $fare_id == 0 ? "₱???" : "₱" . $fare_id;
                ?>
                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 20%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 20%;">
                                <?php echo $db_name; ?><br>
                                <sup class=" fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="py-2 px-2 text-nowrap" style="width: 40%;">
                                <?php echo $destination_display; ?><br>
                                <sup class=" fw-normal"><?php echo $quantity; ?></sup>
                                <sup class=" fw-normal"><?php echo $fare_display; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 20%;">
                                <a href="removeuser.php?id=<?php echo $user_id ?>&action=remove_east_passenger" onclick="return confirm('Are you sure you want to Remove this passenger from East?')" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h6 class="text-center">No passenger available in West</h6>';
                } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-Lemery" role="tabpanel" aria-labelledby="pills-Lemery-tab" tabindex="0">
        <div class="container dashcontent pb-5">
                <?php
                $num = 0;
                if (mysqli_num_rows($lemery_passenger_query) > 0) {
                    while ($row = mysqli_fetch_assoc($lemery_passenger_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $username = $row['username'];
                        $destination = $row['destination'];
                        $quantity = $row['quantity'];
                        $fare_id = $row['fare'];
                        $num++;
                        $destination_display = empty($destination) ? "Unknown" : $destination;
                        $fare_display = empty($fare_id) || $fare_id == 0 ? "₱???" : "₱" . $fare_id;
                ?>
                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 20%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 20%;">
                                <?php echo $db_name; ?><br>
                                <sup class=" fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="py-2 px-2 text-nowrap" style="width: 40%;">
                                <?php echo $destination_display; ?><br>
                                <sup class=" fw-normal"><?php echo $quantity; ?></sup>
                                <sup class=" fw-normal"><?php echo $fare_display; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 20%;">
                                <a href="removeuser.php?id=<?php echo $user_id ?>&action=remove_east_passenger" onclick="return confirm('Are you sure you want to Remove this passenger from East?')" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h6 class="text-center">No passenger available in Lemery</h6>';
                } ?>
            </div>
        </div>
    </div>
</body>

</html>