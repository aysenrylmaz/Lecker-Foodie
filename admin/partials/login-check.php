<?php
//Autherization-Acces Control
//Check whether the user is logged in or not
if (!isset($_SESSION['user']))  //If user session is not set
{
  //User is noot logged in
  //Redirect to login page with message

  $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to acces Admin Panel.</div>";
  //Redirect to Login Page

  header('location:' . SITEURL . 'admin/login.php');
}
//We didn't create constant.php in here because this file will take from menu.php
