<?php
include('connection.php');
$user_username = $_SESSION['username'];
$east_driver_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='east-driver' ORDER BY last_updated ASC");
$east_driver_rows = mysqli_num_rows($east_driver_query);

$east_passenger_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='east-passenger' ORDER BY last_updated ASC ");
$east_passenger_rows = mysqli_num_rows($east_passenger_query);


$west_driver_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='west-driver' ORDER BY last_updated ASC");
$west_driver_rows = mysqli_num_rows($west_driver_query);

$west_passenger_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='west-passenger' ORDER BY last_updated ASC");
$west_passenger_rows = mysqli_num_rows($west_passenger_query);


$lemery_driver_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='lemery-driver' ORDER BY last_updated ASC");
$lemery_driver_rows = mysqli_num_rows($lemery_driver_query);

$lemery_passenger_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='lemery-passenger' ORDER BY last_updated ASC");
$lemery_passenger_rows = mysqli_num_rows($lemery_passenger_query);





$user_in_east_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='east-driver' AND username='$user_username'");
$is_user_in_east = mysqli_num_rows($user_in_east_query) > 0;

$user_in_west_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='west-driver' AND username='$user_username'");
$is_user_in_west = mysqli_num_rows($user_in_west_query) > 0;

$user_in_lemery_query = mysqli_query($connection, "SELECT * FROM users WHERE availability='lemery-driver' AND username='$user_username'");
$is_user_in_lemery = mysqli_num_rows($user_in_lemery_query) > 0;



if($east_driver_rows <= 0){
    $east_driver = '';
} else{
    $east_driver = "<span class='position-absolute top-25 start-1 translate-middle badge rounded-pill bg-secondary'>$east_driver_rows</span>";
}

if($east_passenger_rows <= 0){
    $east_passenger = '';
} else{
    $east_passenger = "<span class='position-absolute top-25 start-1 translate-middle badge rounded-pill bg-secondary'>$east_passenger_rows</span>";
}


if($west_driver_rows <= 0){
    $west_driver = '';
} else{
    $west_driver = "<span class='position-absolute top-25 start-1 translate-middle badge rounded-pill bg-secondary'>$west_driver_rows</span>";
}

if($west_passenger_rows <= 0){
    $west_passenger = '';
} else{
    $west_passenger = "<span class='position-absolute top-25 start-1 translate-middle badge rounded-pill bg-secondary'>$west_passenger_rows</span>";
}


if($lemery_driver_rows <= 0){
    $lemery_driver = '';
} else{
    $lemery_driver = "<span class='position-absolute top-25 start-1 translate-middle badge rounded-pill bg-secondary'>$lemery_driver_rows</span>";
}

if($lemery_passenger_rows <= 0){
    $lemery_passenger = '';
} else{
    $lemery_passenger = "<span class='position-absolute top-25 start-1 translate-middle badge rounded-pill bg-secondary'>$lemery_passenger_rows</span>";
}

$sum_drivers = $east_driver_rows + $west_driver_rows + $lemery_driver_rows;
$sum_passengers = $east_passenger_rows + $west_passenger_rows + $lemery_passenger_rows;

if($sum_drivers <= 0){
    $av_driver = '';
} else{
    $av_driver = "<span class='position-absolute bottom-0 start-1 translate-middle badge rounded-pill bg-success'>$sum_drivers</span>";
}

if($sum_passengers <= 0){
    $av_passenger = '';
} else{
    $av_passenger = "<span class='position-absolute bottom-0 start-1 translate-middle badge rounded-pill bg-success'>$sum_passengers</span>";
}


?>