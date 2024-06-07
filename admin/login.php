<?php include('../config/constants.php'); ?>

<html>

<head>
  <title>Login-Food Order System</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
  <div class="login">
    <h1 class="text-center">Login</h1>
    <br><br>
    <?php
    if (isset($_SESSION['login'])) {

      echo $_SESSION['login'];   //Displaying Login Session Message
      unset($_SESSION['login']);  //Removing Login Session Message
    }

    if (isset($_SESSION['no-login-message'])) {

      echo $_SESSION['no-login-message'];   //Displaying no-login-message Session Message
      unset($_SESSION['no-login-message']);  //Removing no-login-message Session Message
    }
    ?>
    <br>
    <!-- Login Form Starts From Here -->
    <form action="" method="POST" class="text-center">
      Username: <br>
      <input type="text" name="username" placeholder="Enter Username"> <br><br>
      Password: <br>
      <input type="password" name="password" placeholder="Enter Password"> <br> <br>
      <input type="submit" name="submit" value="Login" class="btn-primary"> <br><br>
    </form>
    <!-- Login Form Ends From Here -->
    <p class="text-center">Created By- <a href="http://">Aysenur Yilmaz</a></p>

  </div>
</body>

</html>

<?php
//Check whether the Submit Button is Clicked or Not
if (isset($_POST['submit'])) {
  //Process the login
  //1. Get the Data from Login Form

  //$username=$_POST['username'];
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  //$password=md5($_POST['password']); //Password Encryotion with MD5
  $raw_password = md5($_POST['password']);
  $password = mysqli_real_escape_string($conn, $raw_password);

  //2. SQL to check whether the user with username and password exists or not
  $sql = "SELECT * FROM tbl_admin WHERE
          username='$username' AND
          password='$password'
         ";

  //3.Execute the Query
  $res = mysqli_query($conn, $sql);

  //4. Count rows to check whether the user exists or not
  $count = mysqli_num_rows($res);

  //Check whether we have admin data or not
  if ($count == 1) {
    //User Available and Login Success
    $_SESSION['login'] = "<div class='success'>Login is Succesfull</div>";
    $_SESSION['user'] = $username;  //To check whether the user is logged in or not logout willl unset it


    //Redirect to Home Page/Dashboard
    header("location:" . SITEURL . "admin/");
  } else {

    //User not Available and Login Fail
    $_SESSION['login'] = "<div class='error'>Username or Password did not matched!</div>";
  }
}


?>