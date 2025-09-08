<?php
session_start();
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/bootstrap.min.css">
    <script src="../JavaScript/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Style/Style.css">
    <title>Profile</title>
</head>

<body class="vh-100 content d-flex justify-content-center align-items-center">
    <?php
    $user_id = $_REQUEST["id"];
    $get_record = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($get_record)) {
        $profile = $row['profile'];
        $user_id = $row['id'];
        $name = $row["fname"];
        $age = $row['age'];
        $gender = $row['gender'];
        $contact = $row['contact'];
        $license = $row['license'];
        $tricycle_picture = $row['tricycle_picture'];
        $permit = $row['address_permit'];
        $username = $row["username"];
        $password = $row['password'];
    }

    $getdriver = mysqli_query($connection, "SELECT * FROM users WHERE access='driver'");

    $getmonthlyCount = mysqli_query($connection, "SELECT COUNT(*) AS total_paid FROM users WHERE p_method IN ('G cash', 'Maya')");

    if ($getmonthlyCount) {
        $row = mysqli_fetch_assoc($getmonthlyCount);
        $totalPaid = $row['total_paid'];
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    $gettotalSum = mysqli_query($connection, "SELECT SUM(total) AS total_sum FROM users WHERE p_method IN ('G cash', 'Maya')");

    if ($gettotalSum) {
        $row = mysqli_fetch_assoc($gettotalSum);
        $totalSum = $row['total_sum'];
    } else {
        echo "Error: " . mysqli_error($connection);
    }



    ?>

    <div class="border overflow-auto rounded p-4 m-3 w-100 shadow" style="height:90%">
        <center>
            <div class="pic border rounded overflow-hidden mb-2" style="width:150px; height:150px;">
                <img src="../Images/<?php echo $profile ?>" alt="" style="width:100%; height:100%;">
            </div>
            <sup>@<?php echo $username; ?></sup>
        </center>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Commissions</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="px-3 overflow-auto" style="height: 20%;">
                    <label class="form-label w-100">Name: <?php echo $name; ?></label>
                    <label class="form-label w-100">Age: <?php echo $age; ?></label>
                    <label class="form-label w-100">Genger: <?php echo $gender; ?></label>
                    <label class="form-label w-100">Contact: <?php echo $contact; ?></label>
                    <label class="form-label w-100">Access: Administrator</label>
                    <p class="text-center"><a href="./edit.php?id=<?php echo $user_id; ?>">Edit profile</a></p>
                    <center>
                        <a href="../logout.php?id=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to log out?')" class="btn btn-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                            </svg>
                            Logout
                        </a>
                        <a href="./index.php" class="btn btn-primary mt-2 w-100">Back</a>
                    </center>
                </div>
            </div>


            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <h5>Total Commission: (<?php echo $totalPaid ?>) &nbsp;₱<?php echo $totalSum ?> </h5>
                <div class="overflow-auto" style="height: 20%;">
                    <?php
                    while ($row = mysqli_fetch_assoc($getdriver)) {

                        if ($row['p_method'] === 'Cash' || $row['p_method'] === 'not paid'  || $row['p_method'] === '') {
                            continue; // Skip this iteration and move to the next user
                        }
                        $profile = $row['profile'];
                        $user_id = $row['id']; // Unique user ID
                        $name = $row["fname"];
                        $paydate = $row['paydate'];
                        $username = $row["username"];
                        $proof_id = "proof_" . $user_id; // Unique proof ID
                        $proof = $row['proof'];
                        $ref= $row['reference_number'];
                    ?>
                        <div class="d-flex border gap-1 mb-2 rounded shadow border" style="height:70px;">
                            <div class="aspect-ratio1 p-1" style="width: 25%;">
                                <img src="../Images/<?php echo $profile ?>" class="aspect-ratio2 rounded">
                            </div>
                            <div class="py-2 px-2" style="width: 25%;"><?php echo $name; ?><br>
                                <sub>@<?php echo $username; ?></sub>
                            </div>
                            <div style="width: 20%;" class="d-grid m-auto">
                                <?php if ($row['p_method'] === 'Cash') { ?>
                                    <span class="badge text-bg-success text-wrap">
                                        Cash
                                    </span>
                                <?php } elseif (!empty($row['p_method']) && !empty($row['proof'])) { ?>
                                    <a href="../images/<?php echo $row['proof']; ?>" class="badge text-bg-primary text-wrap text-decoration-none">
                                        View payment
                                    </a>
                                <?php } else { ?>
                                    <span class="badge text-bg-secondary text-wrap">
                                        Not paid
                                    </span>
                                <?php } ?>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" style="width: 25%;">
                                <!-- Button targeting the unique proof ID -->
                                <button class='btn btn-warning' popovertarget="<?php echo $proof_id; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Unique proof section -->
                        <div class="position-absolute overflow-auto top-50 p-4 w-75 border shadow rounded start-50 translate-middle" id="<?php echo $proof_id; ?>" popover style="height: 95%;">
                            <p class="m-0"><b>Proof of</b> <b class="text-uppercase"><?php echo $name; ?></b></p>
                            <p class="m-0"><b>Date of payment:</b> <?php echo $paydate; ?></p>
                            <p class="m-0"><b>Ref no.:</b> <?php echo $ref; ?></p>

                            <?php if (empty($proof)) { ?>
                                <p class="text-danger fw-bold">Not paid yet</p>
                            <?php } else { ?>
                                <img src="../images/<?php echo $proof; ?>" alt="Proof Image" width="100%" class="img-fluid rounded">
                            <?php } ?>
                        </div>


                    <?php } ?>
                </div>

            </div>
        </div>
    </div>


    </div>
</body>

</html>