<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/bootstrap.min.css">
    <script src="./JavaScript/bootstrap.min.js"></script>
    <title>Register</title>
</head>

<body>
    <?php
    include("./connection.php");
    $errd = $errp = '';
    if (isset($_POST["register-passenger"])) {
        if (
            empty($_FILES['passenger_image']['name']) || empty($_POST["passenger_fname"]) ||
            empty($_POST["passenger_age"]) || empty($_POST["passenger_gender"]) ||
            empty($_POST["passenger_contact"]) || empty($_POST["passenger_street"]) ||
            empty($_POST["passenger_username"]) || empty($_POST["passenger_password"])
        ) {
            echo "<script>
                alert('Please fill in all required fields');
            </script>";
        } else {
            $fileName = $_FILES['passenger_image']['name'];
            $fileSize = $_FILES['passenger_image']['size'];
            $tmpName = $_FILES['passenger_image']['tmp_name'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($imageExtension, ['jpg', 'jpeg', 'png'])) {
                echo "<script>
                    alert('Invalid image extension!');
                </script>";
            } else {
                $username = $_POST["passenger_username"];
                $contact = $_POST["passenger_contact"];
                $password = $_POST["passenger_password"];
                $access = 'passenger'; // Set as 'passenger' directly
                $newImageName = uniqid() . '.' . $imageExtension;

                // Check for existing username
                $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
                $stmt = mysqli_prepare($connection, $checkUsernameQuery);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    echo "<script>
                        alert('Username already in use!');
                    </script>";
                    mysqli_stmt_close($stmt);
                } else {
                    mysqli_stmt_close($stmt);

                    // Check for existing contact number
                    $checkContactQuery = "SELECT * FROM users WHERE contact = ?";
                    $stmt = mysqli_prepare($connection, $checkContactQuery);
                    mysqli_stmt_bind_param($stmt, "s", $contact);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        echo "<script>
                            alert('Contact number already in use!');
                        </script>";
                        mysqli_stmt_close($stmt);
                    } else {
                        mysqli_stmt_close($stmt);

                        // Hash the password before storing it in the database
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        if (move_uploaded_file($tmpName, './Images/' . $newImageName)) {
                            $stmt = mysqli_prepare($connection, "INSERT INTO users(fname, age, gender, contact, address_permit, username, password, profile, access) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            mysqli_stmt_bind_param($stmt, "sisssssss", $_POST["passenger_fname"], $_POST["passenger_age"], $_POST["passenger_gender"], $contact, $_POST["passenger_street"], $username, $hashedPassword, $newImageName, $access);

                            if (mysqli_stmt_execute($stmt)) {
                                echo "<script>
                                    alert('Successfully Registered! You can now log in as a passenger.'); 
                                    window.location.href='./index.php';
                                </script>";
                            } else {
                                echo "<script>alert('Error registering passenger: " . mysqli_error($connection) . "');</script>";
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "<script>alert('Failed to upload image');</script>";
                        }
                    }
                }
            }
        }
    }


    if (isset($_POST["register-driver"])) {
        // Validate required fields
        if (
            empty($_FILES['driver_image']['name']) ||
            empty($_POST["driver_fname"]) ||
            empty($_POST["driver_age"]) ||
            empty($_POST["driver_gender"]) ||
            empty($_POST["driver_contact"]) ||
            empty($_FILES['driver_license']['name']) ||
            empty($_FILES['driver_permit']['name']) ||
            empty($_FILES['driver_tricycle']['name']) ||
            empty($_POST["driver_username"]) ||
            empty($_POST["driver_password"])
        ) {
            echo "<script>
                    alert('Please fill in all required fields');
                </script>";
        } else {
            // Common file validation logic
            function validateAndMoveFile($file, $allowedExtensions, $targetDirectory)
            {
                $fileName = $file['name'];
                $fileSize = $file['size'];
                $tmpName = $file['tmp_name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($fileExtension, $allowedExtensions)) {
                    return ['error' => "Invalid file extension for $fileName!"];
                }

                $newFileName = uniqid() . '.' . $fileExtension;
                if (move_uploaded_file($tmpName, $targetDirectory . $newFileName)) {
                    return ['success' => $newFileName];
                } else {
                    return ['error' => "Failed to upload $fileName"];
                }
            }

            $allowedExtensions = ['jpg', 'jpeg', 'png'];

            // Validate and move each file
            $driverImage = validateAndMoveFile($_FILES['driver_image'], $allowedExtensions, './Images/');
            $driverLicense = validateAndMoveFile($_FILES['driver_license'], $allowedExtensions, './Images/');
            $driverPermit = validateAndMoveFile($_FILES['driver_permit'], $allowedExtensions, './Images/');
            $driverTricycle = validateAndMoveFile($_FILES['driver_tricycle'], $allowedExtensions, './Images/');

            if (isset($driverImage['error']) || isset($driverLicense['error']) || isset($driverPermit['error']) || isset($driverTricycle['error'])) {
                // Handle any file upload errors
                $errors = array_filter([$driverImage['error'], $driverLicense['error'], $driverPermit['error'], $driverTricycle['error']]);
                echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
            } else {
                // Check username availability
                $username = $_POST["driver_username"];
                $contact = $_POST["driver_contact"];
                $password = password_hash($_POST["driver_password"], PASSWORD_BCRYPT);
                $access = "pending-driver";

                // Check if username already exists
                $checkUsernameQuery = "SELECT * FROM users WHERE username = ?";
                $stmt = mysqli_prepare($connection, $checkUsernameQuery);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    echo "<script>alert('Username already in use!');</script>";
                    mysqli_stmt_close($stmt);
                } else {
                    mysqli_stmt_close($stmt);

                    // Check if contact number already exists
                    $checkContactQuery = "SELECT * FROM users WHERE contact = ?";
                    $stmt = mysqli_prepare($connection, $checkContactQuery);
                    mysqli_stmt_bind_param($stmt, "s", $contact);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        echo "<script>alert('Contact number already in use!');</script>";
                        mysqli_stmt_close($stmt);
                    } else {
                        mysqli_stmt_close($stmt);

                        // Insert into database
                        $stmt = mysqli_prepare($connection, "INSERT INTO users(fname, age, gender, contact, address_permit, license, tricycle_picture, username, password, profile, access) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        mysqli_stmt_bind_param(
                            $stmt,
                            "sisssssssss",
                            $_POST["driver_fname"],
                            $_POST["driver_age"],
                            $_POST["driver_gender"],
                            $contact,
                            $driverPermit['success'],
                            $driverLicense['success'],
                            $driverTricycle['success'],
                            $username,
                            $password,
                            $driverImage['success'],
                            $access
                        );

                        if (mysqli_stmt_execute($stmt)) {
                            echo "<script> 
                                    alert('Successfully Registered, Please wait for the confirmation message. Thank you!'); 
                                    window.location.href='./index.php';
                                </script>";
                        } else {
                            // More informative error message
                            $error_message = "Error registering driver: " . mysqli_error($connection);
                            error_log("Driver registration error: " . $error_message); // Log the error for debugging
                            echo "<script>alert('Error registering driver: $error_message');</script>";
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
            }
        }
    }


    ?>
    <ul class="nav nav-pills position-sticky z-1 top-0 bg-light p-2 gap-2 nav-justified mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-Passenger-tab" data-bs-toggle="pill" data-bs-target="#pills-Passenger" type="button" role="tab" aria-controls="pills-Passenger" aria-selected="true">Passenger</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-Driver-tab" data-bs-toggle="pill" data-bs-target="#pills-Driver" type="button" role="tab" aria-controls="pills-Driver" aria-selected="false">Driver</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-Passenger" role="tabpanel" aria-labelledby="pills-Passenger-tab" tabindex="0">
            <div class="content d-flex justify-content-center align-items-center">
                <div class="p-4">
                    <div>
                        <form method="POST" action="" enctype="multipart/form-data" class="p-4 rounded w-100 source-sans shadow">

                            <h1 class="oswald text-center">Registration Form</h1>
                            <div class=" w-100 d-flex justify-content-center align-items-center mb-2">
                                <label for="passenger_image" id="image_label" class="border position-relative shadow" style="cursor: pointer;height:150px; width:150px;">
                                    <center>
                                        <img src="" id="passenger_preview" class="border" alt="Profile" style="display: none; height:150px; width:150px; max-width: 150px; max-height: 150px; cursor:pointer;">
                                        <p class="mt-5" id="lbl1">Upload your picture here</p>
                                    </center>
                                </label>
                                <input type="file" name="passenger_image" id="passenger_image" accept=".jpg, .jpeg, .png" class="position-absolute form-control z-1" style="opacity: 0;" required>
                            </div>


                            <label for="passenger_fname">Name</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="passenger_fname" name="passenger_fname" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="passenger_age">Age</label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group mb-2 w-50">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="passenger_age" name="passenger_age" aria-describedby="basic-addon1" required>
                                </div>
                                <label for="passenger_male" class="">
                                    Male
                                    <input type="radio" class="form-check-input" name="passenger_gender" id="passenger_male" value="Male" required>
                                </label>
                                <label for="passenger_female" class="">
                                    Female
                                    <input type="radio" class="form-check-input" name="passenger_gender" id="passenger_female" value="Female">
                                </label><br>
                            </div>

                            <label for="passenger_contact">Contact</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="passenger_contact" name="passenger_contact" aria-describedby="basic-addon1" required>
                            </div>
                            <label for="passenger_street" class="street">Purok no.</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M440-80v-160H240L120-360l120-120h200v-80H160v-240h280v-80h80v80h200l120 120-120 120H520v80h280v240H520v160h-80ZM240-640h447l40-40-40-40H240v80Zm33 320h447v-80H273l-40 40 40 40Zm-33-320v-80 80Zm480 320v-80 80Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="passenger_street" name="passenger_street" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="passenger_username">Username</label><br>
                            <span class="text-danger fw-bold"><?php echo $errp ?></span>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="passenger_username" name="passenger_username" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="passenger_password">Password</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="passenger_password" name="passenger_password" aria-describedby="basic-addon1" required>
                            </div>

                            <button type=" submit" name="register-passenger" class="btn btn-success w-100">Register</button>
                            <a href="index.php" class="btn btn-danger w-100 mt-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-Driver" role="tabpanel" aria-labelledby="pills-Driver-tab" tabindex="0">
            <div class="content d-flex justify-content-center align-items-center">
                <div class="p-4">
                    <div>
                        <form method="POST" action="" enctype="multipart/form-data" class="p-4 rounded w-100 source-sans shadow">
                            <h1 class="oswald text-center">Registration Form</h1>
                            <div class=" w-100 d-flex justify-content-center align-items-center mb-2">
                                <label for="driver_image" id="image_label" class="border position-relative shadow" style="cursor: pointer;height:150px; width:150px;">
                                    <center>
                                        <img src="" id="driver_preview" class="border" alt="Profile" style="display: none; height:150px; width:150px; max-width: 150px; max-height: 150px; cursor:pointer;">
                                        <p class="mt-5" id="lbl2">Upload your picture here</p>
                                    </center>
                                </label>
                                <input type="file" name="driver_image" id="driver_image" accept=".jpg, .jpeg, .png" class="position-absolute form-control z-1 w-50" style="opacity: 0;" required>
                            </div>


                            <label for="driver_fname">Name</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="driver_fname" name="driver_fname" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="driver_age">Age</label><br>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group mb-2 w-50">
                                    <span class="input-group-text" id="basic-addon1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                            <path d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z" />
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" id="driver_age" name="driver_age" aria-describedby="basic-addon1" required>

                                </div>
                                <label for="driver_male" class="">
                                    Male
                                    <input type="radio" class="form-check-input" name="driver_gender" id="driver_male" value="Male" required>
                                </label>
                                <label for="driver_female" class="">
                                    Female
                                    <input type="radio" class="form-check-input" name="driver_gender" id="driver_female" value="Female">
                                </label><br>
                            </div>

                            <label for="driver_contact">Contact</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="driver_contact" name="driver_contact" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="driver_license" class="license">Driver's License</label><br>
                            <div class="input-group mb-2">
                                <input type="file" class="form-control" id="driver_license" name="driver_license" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="driver_permit" class="permit">Driver's Permit</label><br>
                            <div class="input-group mb-2">
                                <input type="file" class="form-control" id="driver_permit" name="driver_permit" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="driver_tricycle" class="tricycle">Tricycle Picture</label><br>
                            <div class="input-group mb-2">
                                <input type="file" class="form-control" id="driver_tricycle" name="driver_tricycle" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="driver_username">Username</label><br>
                            <span class="text-danger fw-bold"><?php echo $errd ?></span>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="driver_username" name="driver_username" aria-describedby="basic-addon1" required>
                            </div>

                            <label for="driver_password">Password</label><br>
                            <div class="input-group mb-2">
                                <span class="input-group-text" id="basic-addon1">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                        <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z" />
                                    </svg>
                                </span>
                                <input type="text" class="form-control" id="driver_password" name="driver_password" aria-describedby="basic-addon1" required>
                            </div>

                            <button type=" submit" name="register-driver" class="btn btn-success w-100">Register</button>
                            <a href="./index.php" class="btn btn-danger w-100 mt-2">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('#driver_image, #passenger_image').forEach(input => {
            input.addEventListener('change', function(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var preview = event.target.id === 'driver_image' ? document.getElementById('driver_preview') : document.getElementById('passenger_preview');
                    var label1 = document.getElementById('lbl1');
                    var label2 = document.getElementById('lbl2');
                    preview.src = reader.result;
                    preview.style.display = 'block';
                    label1.style.display = 'none';
                    label2.style.display = 'none';
                }
                reader.readAsDataURL(event.target.files[0]);
            });
        });
    </script>
</body>

</html>