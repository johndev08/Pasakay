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

<body class="position-relative">
    <?php
    session_start();
    include("../connection.php");
    include("../availability.php");
    include("../Passenger/nav.php");
    $user_id = $_SESSION['id'];
    $user_username = $_SESSION['username'];
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }

    $user_in_east_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='east-passenger' AND username='$user_username'");
    $is_user_in_east = mysqli_num_rows($user_in_east_query) > 0;

    $user_in_west_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='west-passenger' AND username='$user_username'");
    $is_user_in_west = mysqli_num_rows($user_in_west_query) > 0;

    $user_in_lemery_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='lemery-passenger' AND username='$user_username'");
    $is_user_in_lemery = mysqli_num_rows($user_in_lemery_query) > 0;

    $fare_query = mysqli_query($connection, "SELECT * FROM fare");
    ?>



    <h1 class="text-center oswald mt-2">Available Passengers</h1>
    <ul class="nav nav-pills nav-justified mb-3 mx-3 p mt-3" id="pills-tab" role="tablist">
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

            <div class="z-1 position-fixed w-100  bottom-0 p-3 d-flex justify-content-end">
                <?php
                if ($is_user_in_east) {
                    echo "<a class='btn bt btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exiteast' onclick='return confirm(`Are you sure you want to cancel ride?`)'>Cancel East Ride</a>";
                } elseif ($is_user_in_west) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exitwest' onclick='return confirm(`Are you sure you want to cancel ride?`)'>Cancel West Ride</a>";
                } elseif ($is_user_in_lemery) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exitlemery' onclick='return confirm(`Are you sure you want to cancel ride?`)'>Cancel Lemery Ride</a>";
                } else {
                    echo "<a class='btn btn-success w-100' href='./join_east.php' >Need Ride</a>";
                }
                ?>
            </div>
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
                                <a class='btn btn-warning' href='Edit.php?id=$user_id'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
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
            <form method="post" class="position-fixed w-100 bottom-0 p-3 d-flex justify-content-end">
                <?php
                if ($is_user_in_east) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exiteast' onclick='return confirm(\"Are you sure you want to cancel your East ride?\")'>Cancel East Ride</a>";
                } elseif ($is_user_in_west) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exitwest' onclick='return confirm(\"Are you sure you want to cancel your West ride?\")'>Cancel West Ride</a>";
                } elseif ($is_user_in_lemery) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exitlemery' onclick='return confirm(\"Are you sure you want to cancel your Lemery ride?\")'>Cancel Lemery Ride</a>";
                } else {
                    echo "<a class='btn btn-success w-100' href='./join_west.php'>Need Ride</a>";
                }
                ?>
            </form>
            <div class="container dashcontent pb-2">
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
                                <a class='btn btn-warning' href='Edit.php?id=$user_id'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
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
        <div class="tab-pane fade" id="pills-Lemery" role="tabpanel" aria-labelledby="pills-Lemery-tab" tabindex="0">
            <form method="post" class="position-fixed w-100 bottom-0 p-3 d-flex justify-content-end">
                <?php
                if ($is_user_in_east) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exiteast' onclick='return confirm(\"Are you sure you want to cancel your East ride?\")' >Cancel East Ride</a>";
                } elseif ($is_user_in_west) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exitwest' onclick='return confirm(\"Are you sure you want to cancel your West ride?\")' >Cancel West Ride</a>";
                } elseif ($is_user_in_lemery) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_ride.php?id=" . $user_username . "&action=exitlemery' onclick='return confirm(\"Are you sure you want to cancel your Lemery ride?\")' >Cancel Lemery Ride</a>";
                } else {
                    echo "<a class='btn btn-success w-100' href='./join_lemery.php'>Need Ride</a>";
                }
                ?>
            </form>
            <div class="container dashcontent pb-2">
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
                                <a class='btn btn-warning' href='Edit.php?id=$user_id'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
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
    </div>
</body>

</html>