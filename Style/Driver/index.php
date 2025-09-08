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
    $user_username = $_SESSION['username'];
    include("../connection.php");
    include("../availability.php");
    include('../Driver/nav.php');

    $view_fare = mysqli_query($connection, "SELECT * FROM  fare");
    ?>
    <div class="container dashcontent pb-2">
        <div class="header border rounded mx-1 my-2 shadow">
            <div class="container mt-3">
                <h1 class="text-center mb-4 oswald">Fare Table</h1>
                <div class="">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>From</th>
                                <th></th>
                                <th>To</th>
                                <th>Fare</th>
                                <th>Special</th>
                            </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_assoc($view_fare)) {
                            $point_a = $row["point_a"];
                            $point_b = $row['point_b'];
                            $afare = $row['fare'];
                            $special = $row['special'];
                        ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $point_a ?></td>
                                    <td>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="blue">
                                            <path d="M280-160 80-360l200-200 56 57-103 103h287v80H233l103 103-56 57Zm400-240-56-57 103-103H440v-80h287L624-743l56-57 200 200-200 200Z" />
                                        </svg>
                                    </td>
                                    <td><?php echo $point_b ?></td>
                                    <td><?php echo "₱" . $afare ?></td>
                                    <td><?php echo "₱" . $special ?></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>