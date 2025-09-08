<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/bootstrap.min.css">
    <script src="./javascript/bootstrap.min.js"></script>
    <title>Queue</title>
</head>

<body>
    <?php
    session_start();
    $user_id = $_SESSION['id'];
    $user_username = $_SESSION['username'];
    include("../connection.php");
    include("../availability.php");
    include('./nav.php');
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }
    ?>
    <h1 class="text-center oswald mt-2">Available Drivers</h1>
    <ul class="nav nav-pills nav-justified mb-3 mx-3 mt-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-East-tab" data-bs-toggle="pill" data-bs-target="#pills-East" type="button" role="tab" aria-controls="pills-East" aria-selected="true">
                East
                <?php echo $east_driver ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-West-tab" data-bs-toggle="pill" data-bs-target="#pills-West" type="button" role="tab" aria-controls="pills-West" aria-selected="false">
                West
                <?php echo $west_driver ?>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-Lemery-tab" data-bs-toggle="pill" data-bs-target="#pills-Lemery" type="button" role="tab" aria-controls="pills-Lemery" aria-selected="false">
                Lemery
                <?php echo $lemery_driver ?>
            </button>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-East" role="tabpanel" aria-labelledby="pills-East-tab" tabindex="0">
            <form method="post" class="z-1 position-fixed w-100 bottom-0 p-3 d-flex justify-content-end">
                <?php
                $user_grab_query = mysqli_query($connection, "SELECT driver FROM grab WHERE driver='$user_username'");
                $monthlypay_query = mysqli_query($connection, "SELECT monthly FROM users WHERE username='$user_username'");
                $monthlypay_row = mysqli_fetch_assoc($monthlypay_query);
                $monthly_status = $monthlypay_row['monthly'];

                if (mysqli_num_rows($user_grab_query) > 0) {
                    // User is already grabbed, fetch the driver's name
                    $grab_data = mysqli_fetch_assoc($user_grab_query);
                    $driver_name = $grab_data['driver'];

                    echo "<button class='btn btn-secondary w-100' disabled>On the Ride</button>";
                } elseif (empty($monthly_status) || strtolower($monthly_status) == "not paid") {
                    // Monthly subscription is not paid
                    echo "<button type='button' class='btn btn-warning w-100'><a href='./payment.php'  onclick='confirm(\"You haven’t paid the monthly subscription. Please pay to join a queue.\")' class='text-decoration-none text-dark'>Join Queue</a></button>";
                } elseif ($is_user_in_east) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exiteast' onclick='return confirm(\"Are you sure you want to cancel your East queue?\")'>Cancel East Queue</a>";
                } elseif ($is_user_in_west) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exitwest' onclick='return confirm(\"Are you sure you want to cancel your West queue?\")'>Cancel West Queue</a>";
                } elseif ($is_user_in_lemery) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exitlemery' onclick='return confirm(\"Are you sure you want to cancel your Lemery queue?\")'>Cancel Lemery Queue</a>";
                } else {
                    echo "<a class='btn btn-success w-100' href='./join_queue.php?id=" . $user_username . "&action=joineast' onclick='return confirm(\"Are you sure you want to join the East queue?\")'>Join Queue</a>";
                }
                ?>
            </form>

            <div class="container dashcontent pb-5">

                <?php
                $num = 0;
                if (mysqli_num_rows($east_driver_query) > 0) {
                    while ($row = mysqli_fetch_assoc($east_driver_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $username = $row['username'];
                        $num++;
                ?>
                        <div class="d-flex postion-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 25%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 50%;"><?php echo $db_name; ?><br>
                                <sup class=" fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center gap-1 align-items-center" style="width: 25%;">
                                <a class='btn btn-warning' href="./driver_information.php?fname=<?php echo $db_name ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                <?php }
                } else {
                    echo '<h6 class="text-center">No driver available in East</h6>';
                } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-West" role="tabpanel" aria-labelledby="pills-West-tab" tabindex="0">
            <form method="post" class="position-fixed w-100 bottom-0 p-3 d-flex justify-content-end">
                <?php
                $user_grab_query = mysqli_query($connection, "SELECT driver FROM grab WHERE driver='$user_username'");
                $monthlypay_query = mysqli_query($connection, "SELECT monthly FROM users WHERE username='$user_username'");
                $monthlypay_row = mysqli_fetch_assoc($monthlypay_query);
                $monthly_status = $monthlypay_row['monthly'];

                if (mysqli_num_rows($user_grab_query) > 0) {
                    // User is already grabbed, fetch the driver's name
                    $grab_data = mysqli_fetch_assoc($user_grab_query);
                    $driver_name = $grab_data['driver'];

                    echo "<button class='btn btn-secondary w-100' disabled>On the Ride</button>";
                } elseif (empty($monthly_status) || strtolower($monthly_status) == "not paid") {
                    // Monthly subscription is not paid
                    echo "<button type='button' class='btn btn-warning w-100' onclick='alert(\"You haven’t paid the monthly subscription. Please pay to join a queue.\")'>Join Queue</button>";
                } elseif ($is_user_in_east) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exiteast' onclick='return confirm(\"Are you sure you want to cancel your East queue?\")'>Cancel East Queue</a>";
                } elseif ($is_user_in_west) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exitwest' onclick='return confirm(\"Are you sure you want to cancel your West queue?\")'>Cancel West Queue</a>";
                } elseif ($is_user_in_lemery) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exitlemery' onclick='return confirm(\"Are you sure you want to cancel your Lemery queue?\")'>Cancel Lemery Queue</a>";
                } else {
                    echo "<a class='btn btn-success w-100' href='./join_queue.php?id=" . $user_username . "&action=joinwest' onclick='return confirm(\"Are you sure you want to join the West queue?\")'>Join Queue</a>";
                }
                ?>

            </form>
            <div class="container dashcontent pb-2">
                <?php
                $num = 0;
                if (mysqli_num_rows($west_driver_query) > 0) {
                    while ($row = mysqli_fetch_assoc($west_driver_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $username = $row['username'];
                        $num++;
                ?>
                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 25%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 50%;"><?php echo $db_name; ?><br>
                                <sup class=" fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center gap-1 align-items-center" style="width: 25%;">
                                <a class='btn btn-warning' href='./driver_information.php?fname=<?php echo $db_name ?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                <?php }
                } else {
                    echo '<h6 class="text-center">No driver available in West</h6>';
                } ?>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-Lemery" role="tabpanel" aria-labelledby="pills-Lemery-tab" tabindex="0">
            <form method="post" class="position-fixed w-100 bottom-0 p-3 d-flex justify-content-end">
                <?php
                $user_grab_query = mysqli_query($connection, "SELECT driver FROM grab WHERE driver='$user_username'");
                $monthlypay_query = mysqli_query($connection, "SELECT monthly FROM users WHERE username='$user_username'");
                $monthlypay_row = mysqli_fetch_assoc($monthlypay_query);
                $monthly_status = $monthlypay_row['monthly'];

                if (mysqli_num_rows($user_grab_query) > 0) {
                    // User is already grabbed, fetch the driver's name
                    $grab_data = mysqli_fetch_assoc($user_grab_query);
                    $driver_name = $grab_data['driver'];

                    echo "<button class='btn btn-secondary w-100' disabled>On the Ride</button>";
                } elseif (empty($monthly_status) || strtolower($monthly_status) == "not paid") {
                    // Monthly subscription is not paid
                    echo "<button type='button' class='btn btn-warning w-100' onclick='alert(\"You haven’t paid the monthly subscription. Please pay to join a queue.\")'>Join Queue</button>";
                } elseif ($is_user_in_east) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exiteast' onclick='return confirm(\"Are you sure you want to cancel your East queue?\")'>Cancel East Queue</a>";
                } elseif ($is_user_in_west) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exitwest' onclick='return confirm(\"Are you sure you want to cancel your West queue?\")'>Cancel West Queue</a>";
                } elseif ($is_user_in_lemery) {
                    echo "<a class='btn btn-danger w-100' href='./cancel_queue.php?id=" . $user_username . "&action=exitlemery' onclick='return confirm(\"Are you sure you want to cancel your Lemery queue?\")'>Cancel Lemery Queue</a>";
                } else {
                    echo "<a class='btn btn-success w-100' href='./join_queue.php?id=" . $user_username . "&action=joinlemery' onclick='return confirm(\"Are you sure you want to Join the Lemery queue?\")'>Join Queue</a>";
                }
                ?>
            </form>
            <div class="container dashcontent pb-2">
                <?php
                $num = 0;
                if (mysqli_num_rows($lemery_driver_query) > 0) {
                    while ($row = mysqli_fetch_assoc($lemery_driver_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $username = $row['username'];
                        $num++;
                ?>
                        <div class="d-flex position-relative border gap-1 mb-1 fw-bold rounded shadow" style="height:70px;">
                            <p class="position-absolute rounded border bg-light m-auto px-2"><?php echo $num; ?></p>
                            <div class="aspect-ratio1 p-1" style="width: 25%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 50%;"><?php echo $db_name; ?><br>
                                <sup class=" fw-normal">@<?php echo $username; ?></sup>
                            </div>
                            <div class="d-flex justify-content-center gap-1 align-items-center" style="width: 25%;">
                                <a class='btn btn-warning' href='./driver_information.php?fname=<?php echo $db_name ?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                <?php }
                } else {
                    echo '<h6 class="text-center">No driver available in Lemery</h6>';
                } ?>
            </div>
        </div>
    </div>
</body>

</html>