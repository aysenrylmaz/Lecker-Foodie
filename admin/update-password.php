<?php include('partials/menu.php'); ?>
<div class="main-content">
<div class="wrapper">
<h1>CHANGE PASSWORD</h1>
<br />
    <br />

    <?php
    if(isset($_GET['id']))
    {
       $id=$_GET['id'];

    }
    ?>



      <form action="" method="POST">
      <table class="tbl-30">
        <tr>
         <td>Current Password:</td>
         <td>
            <input type="password" name="current_password" placeholder="Old Password">
         </td>
         </tr>

         <tr>
         <td>New Password:</td>
         <td>
            <input type="password" name="new_password" placeholder="New Password">
         </td>
        </tr>

        <tr>
         <td>Confirm Password:</td>
         <td>
            <input type="password" name="confirm_password" placeholder="Confirm Password">
         </td>
        </tr>

        <tr>
             <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <input type="submit" name="submit" value="Change Password" class="btn-secondary">
             </td>
          </tr>


      </table>
      </form>

      
</div>
</div>


<?php
//Check whether the submit Button is Clicked or Not

if(isset($_POST['submit']))
{
  //echo "Clicked";
  //1. GetData from form

  $id=$_POST['id'];
  $current_password=md5($_POST['current_password']);
  $new_password=md5($_POST['new_password']);
  $confirm_password=md5($_POST['confirm_password']);

  //2. Check whether the user with current ID and Current Password Exists or not

  $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";   //id is integer value so it doesn't need '' but password is not nmumerical valuable **

  // Execute the Query
  $res=mysqli_query($conn,$sql);


  if($res==true)
  {
      //Check whether the data is available or not
  $count=mysqli_num_rows($res);
  
  if($count==1)
  {
    //User Exists and Password can be changed
      //echo "User found";

  if($current_password!=$new_password)
  {

    //Check whether the new password and confirm password match or not
    if($new_password==$confirm_password)
    {
        //Update the Password
        $sql2="UPDATE tbl_admin SET
        password='$new_password'
        WHERE id=$id";
       
       //Execute the Query
       $res2=mysqli_query($conn,$sql2);

           //Check whether the query executed succesfully or not

      if($res2==true)
       {
         //Query Executed Succesfully

         //Create Session Variable to Display Success Message
         $_SESSION['change-pwd']="<div class='success'>Password Changed Succesfully!</div>";
         //Redirect to Manage Admin Page
         header("location:".SITEURL."admin/manage-admin.php");
       }
      else
        {
        //Create Session Variable to Display Error Message
         $_SESSION['change-pwd']="<div class='error'>Failed to Change Password!</div>";
        //Redirect to Manage Admin Page
        header("location:".SITEURL."admin/manage-admin.php");
        }
    }
    else
    {

      //If passwords are not matched Set Message and Redirect Page tO Manage Admin
     $_SESSION['pwd-not-match']="<div class='error'>Password did not match!</div>";
     header("location:".SITEURL."admin/manage-admin.php");


    }}

   else{

      //If current and new passwords are same Set Message and Redirect Page tO Manage Admin
      $_SESSION['current-and-new-same']="<div class='error'>Current password an new password can't be same!</div>";
      header("location:".SITEURL."admin/manage-admin.php");

    }

  }
  else
  {
     
        //User doesnt exist Set Message and Redirect Page tO Manage Admin
     $_SESSION['user-not-found']="<div class='error'>User not found!</div>";
     header("location:".SITEURL."admin/manage-admin.php");
  
  }

  //3. Check whether the New Password and Confirm Password Match or not

  //4.Change Password if all above is true

}}
?>
<?php include('partials/footer.php'); ?>
