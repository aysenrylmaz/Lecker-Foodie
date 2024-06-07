<?php
//start session
session_start();

//You have to create like this project make database connection easily
//Create Constants to Store Non Repeating Values
define('SITEURL','//localhost/food-order/'); //home page
define('LOCALHOST', 'localhost'); //it makes more prrofessional
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'food-order');

$conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn));  //Database connection real project-- database root-username and password
$db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error($conn)); //Selecting Database


?>