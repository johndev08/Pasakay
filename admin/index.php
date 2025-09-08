<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/bootstrap.min.css">
    <script src="./JavaScript/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
<?php
    session_start();
    $user_id = $_SESSION['id'];
    include("../connection.php");
    include('./nav.php');
    // include("../availability.php");
    $view_query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
    $view_fare = mysqli_query($connection, "SELECT * FROM  fare");
    while ($row = mysqli_fetch_assoc($view_query)) {
        $user_id = $row["id"];
    }

    if (isset($_POST['addfare'])) {
        if (empty($_POST['newfrom']) && empty($_POST['newto']) && empty($_POST['newfare']) && empty($_POST['newspecial'])) {
            echo "<script>alert('invalid input');</script>";
        } else {
            $newfrom = $_POST['newfrom'];
            $newto = $_POST['newto'];
            $newfare = $_POST['newfare'];
            $newspecial = $_POST['newspecial'];
            $addfare = mysqli_query($connection, "INSERT INTO fare(point_a, point_b, fare, special) VALUE ('$newfrom','$newto','$newfare','$newspecial')");
            echo "<script>alert('Successfully added to the fare.');</script>";
            echo "<script>window.location.href='./index.php'</script>";
        }
    }
    ?>
    <div class="container dashcontent pb-2">
        <div class="header border rounded my-2 shadow ">
            <form action="" method="post" class="py-3 m-3 bg-light rounded">
                <h2 class="text-center oswald">Add Fare</h2>
                <div class="row mx-1 px-3 ">
                    <div class="w-50">
                        <label for="newfrom">From:</label>
                        <input type="text" name="newfrom" id="newfrom" class="form-control" placeholder="Point A" required>
                    </div>
                    <div class="w-50">
                        <label for="newto">To:</label>
                        <input type="text" name="newto" id="newto" class="form-control" placeholder="Point B" required>
                    </div>
                </div>
                <div class="row  mx-1 px-3 ">
                    <div class=" row w-75">
                        <div class="w-50"><label for="newfare">Fare</label>
                            <input type="text" name="newfare" id="newfare" class="form-control" placeholder="₱ 00" required>
                        </div>
                        <div class="w-50"><label for="newspecial">Special</label>
                            <input type="text" name="newspecial" id="newspecial" class="form-control" placeholder="₱ 00" required>
                        </div>
                    </div>
                    <div class="col w-25">
                        <button type="submit" name="addfare" class="btn btn-primary w-100 mt-4" onclick="return confirm('Are you sure you want to Add this to Fare?')">Add</button>
                    </div>
                </div>
            </form>
            <div class="container mt-3">
                <form method="post" action="">
                    <h1 class="text-center mb-3 oswald">Fare Table</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr class=" border table-dark text-center">
                                <th>From</th>
                                <th></th>
                                <th>To</th>
                                <th>Fare</th>
                                <th>Special</th>
                                <th>Option</th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($view_fare)) {
                                $fare_id = $row['id'];
                                $point_a = $row["point_a"];
                                $point_b = $row['point_b'];
                                $afare = $row['fare'];
                                $special = $row['special'];
                            ?>
                                <tr>
                                    <td><?php echo $point_a; ?></td>
                                    <td>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="blue">
                                            <path d="M280-160 80-360l200-200 56 57-103 103h287v80H233l103 103-56 57Zm400-240-56-57 103-103H440v-80h287L624-743l56-57 200 200-200 200Z" />
                                        </svg>
                                    </td>
                                    <td><?php echo $point_b; ?></td>
                                    <td><?php echo "₱" . $afare; ?></td>
                                    <td><?php echo "₱" . $special; ?></td>
                                    <td><a href="./edit_fare.php?id=<?php echo $fare_id; ?>" class="btn btn-warning text-light">Edit</a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>