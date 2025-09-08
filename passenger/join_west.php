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
    include("./nav.php");
    $user_id = $_SESSION['id'];
    $user_username = $_SESSION['username'];
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }
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
            <button class="nav-link position-relative active" id="pills-Lemery-tab" data-bs-toggle="pill" data-bs-target="#pills-Lemery" type="button" role="tab" aria-controls="pills-Lemery" aria-selected="false">
                Lemery
                <?php echo $lemery_passenger ?>
            </button>
        </li>
    </ul>
    <div id="ride_option" class="z-1 position-absolute w-100  px-3" style="transform: translate(-50%, -50%); top: 50%; left:50%;">
        <div class="mx-3 p-4 py-5 border bg-light shadow rounded">
            <form action="./need_ride.php?id=<?php echo $user_username ?>&action=joinwest" method="POST">
            <h1 class="text-center oswald mt-2">West Ride</h1>
                <label for="need_ride" class="fw-bold">Destination</label>
                <select name="need_ride" id="need_ride" class="form-select" aria-label="select example" onchange="updateFare() " required>
                    <option value="" selected disabled>Select Here</option>
                    <?php
                    while ($fare_row = mysqli_fetch_assoc($fare_query)) {
                        $point_a = $fare_row["point_a"];
                        $point_b = $fare_row['point_b'];
                        $afare = $fare_row['fare'];
                        $special = $fare_row['special'];
                    ?>
                        <option value="<?php echo $point_a . '-' . $point_b ?>" data-fare="<?php echo $afare; ?>" data-special-fare="<?php echo $special; ?>">
                            <?php echo $point_a . '-' . $point_b  ?>
                        </option>
                    <?php } ?>
                    <option value="" data-fare="???" data-special-fare="???">Unknown ₱???</option>
                </select>

                <label for="east_quantity" class="fw-bold">No. of passenger(s)</label>
                <select name="quantity" id="east_quantity" class="form-select mb-2" aria-label="select example" onchange="updateFare()">
                    <option value="x1">x1</option>
                    <option value="x2">x2</option>
                    <option value="x3">x3</option>
                    <option value="x4">x4</option>
                    <option value="Special">Special</option>
                </select>

                <label for="fare" class="fw-bold">Fare: ₱</label>
                <input type="text" id="fare_display" name="fare" class="border-0 mb-2" value="0.00" readonly />

                <input type="submit" value="Need Ride" onclick='return confirm("Are you sure you want a ride?")'  class='btn btn-success w-100 mb-2'>
                <a href="./passenger.php" class="btn btn-danger w-100">Close</a>
            </form>
        </div>

    </div>
    <script src="../Javascript/script.js"></script>
</body>

</html>