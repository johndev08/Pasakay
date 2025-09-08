<?php
session_start();
include("../connection.php");
include 'nav.php';
$driver_view_query = mysqli_query($connection, "SELECT * FROM users WHERE access='driver'");
$passenger_view_query = mysqli_query($connection, "SELECT * FROM users WHERE access='passenger'");
$pending_passenger_view_query = mysqli_query($connection, "SELECT * FROM users WHERE access='pending-passenger'");
$pending_driver_view_query = mysqli_query($connection, "SELECT * FROM users WHERE access='pending-driver'");
?>

<body>
    <h1 class="text-center oswald mt-2">Manage Accounts</h1>

    <ul class="nav nav-pills nav-justified mx-3 mt-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Passenger</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Driver</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Request</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="grid-container">
                <div class="p-4 ">
                    <?php while ($row = mysqli_fetch_assoc($passenger_view_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $db_age = $row['age'];
                        $db_gender = $row['gender'];
                        $db_contact = $row['contact'];
                        $db_street = $row['address_permit'];
                        $db_username = $row['username'];
                        $db_password = $row['password'];
                    ?>
                        <div class="d-flex border gap-1 mb-2 rounded shadow" style="height:70px;">
                            <div class="aspect-ratio1 p-1" style="width: 25%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 50%;"><?php echo $db_name; ?><br>
                                <sub>@<?php echo $db_username; ?></sub>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 25%;">
                                <a class='btn btn-warning' href='./passenger_information.php?fname=<?php echo $db_name ?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            <div class="grid-container">
                <div class="p-4 stripe ">
                    <?php while ($row = mysqli_fetch_assoc($driver_view_query)) {
                        $user_id = $row["id"];
                        $db_profile = $row['profile'];
                        $db_name = $row['fname'];
                        $db_age = $row['age'];
                        $db_gender = $row['gender'];
                        $db_contact = $row['contact'];
                        $db_permit = $row['address_permit'];
                        $db_username = $row['username'];
                        $db_password = $row['password'];
                    ?>
                        <div class="d-flex border gap-1 mb-2 rounded shadow" style="height:70px;">
                            <div class="aspect-ratio1 p-1" style="width: 25%;">
                                <img src="../Images/<?php echo $db_profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 50%;"><?php echo $db_name; ?><br>
                                <sub>@<?php echo $db_username; ?></sub>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 25%;">
                                <a class='btn btn-warning' href='./driver_information.php?fname=<?php echo $db_name ?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
            <ul class="nav nav-underline nav-justified mx-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-passenger-tab" data-bs-toggle="pill" data-bs-target="#pills-passenger" type="button" role="tab" aria-controls="pills-passenger" aria-selected="true">Pending Passenger</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-driver-tab" data-bs-toggle="pill" data-bs-target="#pills-driver" type="button" role="tab" aria-controls="pills-driver" aria-selected="false">Pending Driver</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-passenger" role="tabpanel" aria-labelledby="pills-passenger-tab" tabindex="0">
                    <div class="grid-container">
                        <div class="p-4 ">
                            <?php
                            if (mysqli_num_rows($pending_passenger_view_query) > 0) {
                                while ($row = mysqli_fetch_assoc($pending_passenger_view_query)) {
                                    $passenger_id = $row["id"];
                                    $db_profile = $row['profile'];
                                    $db_name = $row['fname'];
                                    $db_age = $row['age'];
                                    $db_gender = $row['gender'];
                                    $db_contact = $row['contact'];
                                    $db_street = $row['address_permit'];
                                    $db_username = $row['username'];
                                    $db_password = $row['password'];
                            ?>
                                    <div class="row  rounded p-2 mb-1">
                                        <div class="col-4"><img src="../Images/<?php echo $db_profile ?>" width="100px" height="100px" alt=""></div>
                                        <div class="col-8">
                                            <div class="name">Name: <?php echo $db_name; ?> </div>
                                            <div class="row">
                                                <div class="col-5">Age: <?php echo $db_age; ?> </div>
                                                <div class="col-7">Gender: <?php echo $db_gender; ?></div>
                                            </div>
                                            <div class="col">Contact: <?php echo $db_contact; ?> </div>
                                            <div class="col">Purok no: <?php echo $db_street ?></div>
                                        </div>
                                    </div>
                                    <div class="row  mb-3 gap-2">
                                        <a class='btn btn-success col'
                                            onclick="return confirm('Are you sure you want to Accept <?php echo $db_name; ?>`s request? ')"
                                            href='../Admin/accept_delete_passenger.php?id=<?php echo $passenger_id ?>&action=accept'>Accept</a>
                                        <a class='btn btn-danger col'
                                            onclick="return confirm('Are you sure you want to Decline <?php echo $db_name; ?>`s request?')"
                                            href='../Admin/accept_delete_driver.php?id=<?php echo $passenger_id ?>&action=decline'>Decline</a>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<p class='text-center'>No pending requests for Passengers.</p>";
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-driver" role="tabpanel" aria-labelledby="pills-driver-tab" tabindex="0">
                    <div class="grid-container">
                        <div class="p-4 ">
                            <?php
                            if (mysqli_num_rows($pending_driver_view_query) > 0) {
                                while ($row = mysqli_fetch_assoc($pending_driver_view_query)) {
                                    $driver_id = $row["id"];
                                    $db_profile = $row['profile'];
                                    $db_name = $row['fname'];
                                    $db_age = $row['age'];
                                    $db_gender = $row['gender'];
                                    $db_contact = $row['contact'];
                                    $db_permit = $row['address_permit'];
                                    $db_username = $row['username'];
                                    $db_password = $row['password'];
                            ?>
                                    <div class="row mb-1">
                                        <div class="col-4"><img src="../Images/<?php echo $db_profile ?>" width="100px" height="100px" alt=""></div>
                                        <div class="col-8">
                                            <div class="name">Name: <?php echo $db_name; ?></div>
                                            <div class="row">
                                                <div class="col-5">Age: <?php echo $db_age; ?> </div>
                                                <div class="col-7">Gender: <?php echo $db_gender; ?></div>
                                            </div>
                                            <div class="col">Contact: <?php echo $db_contact; ?></div>
                                            <div class="col">Permit No: <?php echo $db_permit ?></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 gap-2">
                                        <a class='btn btn-success col'
                                            onclick="return confirm('Are you sure you want to Accept <?php echo $db_name; ?>`s request?')"
                                            href='../Admin/accept_delete_driver.php?id=<?php echo $driver_id ?>&action=accept'>Accept</a>
                                        <a class='btn btn-danger col'
                                            onclick="return confirm('Are you sure you want to Decline <?php echo $db_name; ?>`s request?')"
                                            href='../Admin/accept_delete_driver.php?id=<?php echo $driver_id ?>&action=decline'>Decline</a>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<p class='text-center'>No pending requests for Driver.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>