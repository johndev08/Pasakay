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
    include('../Driver/nav.php');
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }
    ?>
    <h1 class="text-center oswald mt-2">Available Passengers</h1>
    <ul class="nav nav-pills nav-justified mb-3 mx-3 mt-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-East-tab" data-bs-toggle="pill" data-bs-target="#pills-East" type="button" role="tab" aria-controls="pills-East" aria-selected="true">
                East
                <?php echo $east_passenger ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-West-tab" data-bs-toggle="pill" data-bs-target="#pills-West" type="button" role="tab" aria-controls="pills-West" aria-selected="false">
                West
                <?php echo $west_passenger ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-Lemery-tab" data-bs-toggle="pill" data-bs-target="#pills-Lemery" type="button" role="tab" aria-controls="pills-Lemery" aria-selected="false">
                Lemery
                <?php echo $lemery_passenger ?>
            </button>
        </li>

    </ul>
    <div class="z-1 position-fixed w-100 w-100 bottom-0 d-flex justify-content-end">
        <div class="border m-2 p-2 w-100 rounded bg-light">
            <div class="d-flex flex-row gap-2">
                <?php
                $view_grab = mysqli_query($connection, "SELECT * FROM grab WHERE driver='$user_username'");
                while ($row = mysqli_fetch_assoc($view_grab)) {
                    $id = $row['id'];
                    $name = $row['username'];
                    $profile = $row['profile'];
                ?>
                    <div class='position-relative '>
                        <img src="../Images/<?php echo $profile ?>" alt="Profile Image" class="rounded" style="width:45px;height:45px;">
                        <a href="./remove_grab.php?id=<?php echo $id ?>" style="position:absolute; top:50%; left: 50%; transform:translate(-50%,-50%)">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="M280-440h400v-80H280v80ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                            </svg>
                        </a>
                    </div>
                <?php } ?>

                <?php
                if ($is_user_in_east || $is_user_in_west || $is_user_in_lemery) {
                    echo "<a href='./depart.php?username=<?php echo $user_username; ?>' onclick='return confirm(\"Are you sure you want to depart?\")' class='btn btn-success w-100'>Depart</a>";
                } else {
                    echo "<a class='btn btn-secondary disabled w-100'>Depart</a>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class=" tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active pb-3" id="pills-East" role="tabpanel" aria-labelledby="pills-East-tab" tabindex="0">
            <div class="container dashcontent pb-5">
                <?php
                $east_driver_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='east-driver' ORDER BY last_updated ASC");
                $first_east_driver_username = null;
                if (mysqli_num_rows($east_driver_query) > 0) {
                    $first_driver = mysqli_fetch_assoc($east_driver_query);
                    $first_east_driver_username = $first_driver['username'];
                }
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
                        $is_first_driver = ($first_east_driver_username === $user_username);
                        $is_grabbed = mysqli_query($connection, "SELECT * FROM grab WHERE username='$username'");
                        if (mysqli_num_rows($is_grabbed) > 0 || !$is_first_driver) {
                            $disabled = "disabled";
                        } else {
                            $disabled = "";
                        }
                ?>

                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 20%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 20%;">
                                <?php echo $db_name; ?><br>
                                <sup class="fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="py-2 px-2 text-nowrap" style="width: 40%;">
                                <?php echo $destination_display; ?><br>
                                <sup class="fw-normal"><?php echo $quantity; ?></sup>
                                <sup class="fw-normal"><?php echo $fare_display; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 20%;">
                                <?php if (mysqli_num_rows($is_grabbed) > 0) { ?>
                                    <a class='btn btn-light <?php echo $disabled; ?>' href='grab.php?id=<?php echo $user_id ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M517-518 347-688l57-56 113 113 227-226 56 56-283 283ZM280-220l278 76 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T578-354l-234-86h-64v220ZM40-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L560-60l-280-78v58H40Zm80-80h80v-280h-80v280Z" />
                                        </svg>
                                    </a>
                                <?php } else { ?>
                                    <a class='btn btn-warning <?php echo $disabled; ?>' href='grab.php?id=<?php echo $user_id ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M398-120q-27 0-51.5-11.5T305-164L46-483l26-25q19-19 45-22t47 12l116 81v-403q0-17 11.5-28.5T320-880q17 0 28.5 11.5T360-840v557l-111-78 118 146q6 7 14 11t17 4h282q33 0 56.5-23.5T760-280v-280q0-17 11.5-28.5T800-600q17 0 28.5 11.5T840-560v280q0 66-47 113t-113 47H398Zm122-240Zm-80-80v-240q0-17 11.5-28.5T480-720q17 0 28.5 11.5T520-680v240h-80Zm160 0v-200q0-17 11.5-28.5T640-680q17 0 28.5 11.5T680-640v200h-80Z" />
                                        </svg>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h6 class="text-center">No passengers available in East</h6>';
                }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-West" role="tabpanel" aria-labelledby="pills-West-tab" tabindex="0">
            <div class="container dashcontent pb-5">
                <?php
                $west_driver_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='west-driver' ORDER BY last_updated ASC");
                $first_west_driver_username = null;
                if (mysqli_num_rows($west_driver_query) > 0) {
                    $first_driver = mysqli_fetch_assoc($west_driver_query);
                    $first_west_driver_username = $first_driver['username'];
                }
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
                        $is_first_driver = ($first_west_driver_username === $user_username);
                        $is_grabbed = mysqli_query($connection, "SELECT * FROM grab WHERE username='$username'");
                        if (mysqli_num_rows($is_grabbed) > 0 || !$is_first_driver) {
                            $disabled = "disabled";
                        } else {
                            $disabled = "";
                        }
                ?>

                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 20%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 20%;">
                                <?php echo $db_name; ?><br>
                                <sup class="fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="py-2 px-2 text-nowrap" style="width: 40%;">
                                <?php echo $destination_display; ?><br>
                                <sup class="fw-normal"><?php echo $quantity; ?></sup>
                                <sup class="fw-normal"><?php echo $fare_display; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 20%;">
                                <?php if (mysqli_num_rows($is_grabbed) > 0) { ?>
                                    <a class='btn btn-light <?php echo $disabled; ?>' href='grab.php?id=<?php echo $user_id ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M517-518 347-688l57-56 113 113 227-226 56 56-283 283ZM280-220l278 76 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T578-354l-234-86h-64v220ZM40-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L560-60l-280-78v58H40Zm80-80h80v-280h-80v280Z" />
                                        </svg>
                                    </a>
                                <?php } else { ?>
                                    <a class='btn btn-warning <?php echo $disabled; ?>' href='grab.php?id=<?php echo $user_id ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M398-120q-27 0-51.5-11.5T305-164L46-483l26-25q19-19 45-22t47 12l116 81v-403q0-17 11.5-28.5T320-880q17 0 28.5 11.5T360-840v557l-111-78 118 146q6 7 14 11t17 4h282q33 0 56.5-23.5T760-280v-280q0-17 11.5-28.5T800-600q17 0 28.5 11.5T840-560v280q0 66-47 113t-113 47H398Zm122-240Zm-80-80v-240q0-17 11.5-28.5T480-720q17 0 28.5 11.5T520-680v240h-80Zm160 0v-200q0-17 11.5-28.5T640-680q17 0 28.5 11.5T680-640v200h-80Z" />
                                        </svg>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h6 class="text-center">No passengers available in West</h6>';
                }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-Lemery" role="tabpanel" aria-labelledby="pills-Lemery-tab" tabindex="0">
        <div class="container dashcontent pb-5">
                <?php
                $lemery_driver_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='lemery-driver' ORDER BY last_updated ASC");
                $first_lemery_driver_username = null;
                if (mysqli_num_rows($lemery_driver_query) > 0) {
                    $first_driver = mysqli_fetch_assoc($lemery_driver_query);
                    $first_lemery_driver_username = $first_driver['username'];
                }
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
                        $is_first_driver = ($first_lemery_driver_username === $user_username);
                        $is_grabbed = mysqli_query($connection, "SELECT * FROM grab WHERE username='$username'");
                        if (mysqli_num_rows($is_grabbed) > 0 || !$is_first_driver) {
                            $disabled = "disabled";
                        } else {
                            $disabled = "";
                        }
                ?>

                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 20%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 20%;">
                                <?php echo $db_name; ?><br>
                                <sup class="fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="py-2 px-2 text-nowrap" style="width: 40%;">
                                <?php echo $destination_display; ?><br>
                                <sup class="fw-normal"><?php echo $quantity; ?></sup>
                                <sup class="fw-normal"><?php echo $fare_display; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 20%;">
                                <?php if (mysqli_num_rows($is_grabbed) > 0) { ?>
                                    <a class='btn btn-light <?php echo $disabled; ?>' href='grab.php?id=<?php echo $user_id ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M517-518 347-688l57-56 113 113 227-226 56 56-283 283ZM280-220l278 76 238-74q-5-9-14.5-15.5T760-240H558q-27 0-43-2t-33-8l-93-31 22-78 81 27q17 5 40 8t68 4q0-11-6.5-21T578-354l-234-86h-64v220ZM40-80v-440h304q7 0 14 1.5t13 3.5l235 87q33 12 53.5 42t20.5 66h80q50 0 85 33t35 87v40L560-60l-280-78v58H40Zm80-80h80v-280h-80v280Z" />
                                        </svg>
                                    </a>
                                <?php } else { ?>
                                    <a class='btn btn-warning <?php echo $disabled; ?>' href='grab.php?id=<?php echo $user_id ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M398-120q-27 0-51.5-11.5T305-164L46-483l26-25q19-19 45-22t47 12l116 81v-403q0-17 11.5-28.5T320-880q17 0 28.5 11.5T360-840v557l-111-78 118 146q6 7 14 11t17 4h282q33 0 56.5-23.5T760-280v-280q0-17 11.5-28.5T800-600q17 0 28.5 11.5T840-560v280q0 66-47 113t-113 47H398Zm122-240Zm-80-80v-240q0-17 11.5-28.5T480-720q17 0 28.5 11.5T520-680v240h-80Zm160 0v-200q0-17 11.5-28.5T640-680q17 0 28.5 11.5T680-640v200h-80Z" />
                                        </svg>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h6 class="text-center">No passengers available in Lemery</h6>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>