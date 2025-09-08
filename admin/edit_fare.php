<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/Style.css">
    <link rel="stylesheet" href="../Style/bootstrap.min.css">
    <script src="../JavaScript/bootstrap.min.js"></script>
    <title>DashBoard</title>
</head>

<body>
    <?php
    session_start();
    $user_id = $_SESSION['id'];
    $fare_id = $_GET['id'];
    include("../connection.php");
    include ('./nav.php');
    // include("../availability.php");
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }

    $view_fare = mysqli_query($connection, "SELECT * FROM fare WHERE id='$fare_id'");
    while ($edit_row = mysqli_fetch_assoc($view_fare)) {
        $db_from = $edit_row['point_a'];
        $db_to = $edit_row['point_b'];
        $db_fare = $edit_row['fare'];
        $db_special = $edit_row['special'];
    }

    if (isset($_POST['update'])) {
        $fare_id = $_GET['id'];
        $newfrom = $_POST['newfrom'];
        $newto = $_POST['newto'];
        $newfare = $_POST['newfare'];
        $newspecial = $_POST['newspecial'];

        $updatefare = mysqli_query($connection, "UPDATE fare SET point_a='$newfrom', point_b='$newto', fare='$newfare', special='$newspecial' WHERE id='$fare_id'");
        echo "<script>alert('Fare Has been Updated...');</script>";
        echo "<script>window.location.href='./dashboard.php';</script>";
    }
    ?>
    <div class="container dashcontent pb-2">
        <div class="header border rounded mx-1 my-2 shadow ">
            <div class="container my-4">
                <form action="" method="post">
                    <h1 class=" mt-3 oswald text-center">Edit Fare</h1>
                    <h6 class="text-center"><?php echo $db_from . "  to  " . $db_to ?></h6>
                    <div class="row px-4 py-2">
                        <p class="px-2 m-0">From:</p>
                        <input type="text" class="form-control my-1 w-100" name="newfrom" id="newfrom" value="<?php echo $db_from ?>">
                        <p class="px-2 m-0">To:</p>
                        <input type="text" class="form-control my-1 w-100" name="newto" id="newto" value="<?php echo $db_to ?>">
                        <p class="px-2 m-0 w-25">Fare:</p><br>
                        <p class="px-2 m-0 w-50 mx-3">Special:</p><br>
                        <input type="text" class="form-control my-1 w-25 " name="newfare" id="newfare" value="<?php echo $db_fare ?>">
                        <input type="text" class="form-control mx-3 my-1 w-25" name="newspecial" id="newspecial" value="<?php echo $db_special ?>">
                        <div class="d-flex column-gap-2 mt-1">
                            <input type="submit" name="update" value="Update" onclick="return confirm('Are you sure you want to Update?')" class="btn btn-success w-50">
                            <a href="Deletefare.php?id=<?php echo $fare_id ?>" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-danger w-50">Delete</a>
                        </div>
                        <a href="./index.php" class="btn border border-2 mt-2 ">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>