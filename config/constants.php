<?php

//Start Session
session_start();

//Create Constants to store non repeating values
define('SITEURL', 'http://localhost/kristy/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '1234');
define('DB_NAME', 'food_order');

//Execute Query and save data in database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //Database Connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); //Selecting Database

?>