<?php
//Include Constants File
include('../config/constants.php');
//echo "Delete Page";
//Check whether the id and image_name value is set or not

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
//Get the Value and Delete
$id=$_GET['id'];
$image_name=$_GET['image_name'];

//Remove the physical image file is availbale
if($image_name!="")
{
  //Image is Available, so remove it
  $path="../images/food/".$image_name;

  //Remove the Image
  $remove=unlink($path);

  //If failed to remove image then add an error message and stop the process
  if($remove==false)
{
     //Set the Session Message
     $_SESSION['remove']="<div class='error'>Fail to Remove Food Image.</div>";
     //Redirect to Manage Food Page
     header("location:".SITEURL."admin/manage-food.php");
     //Stop the Process
     die();

}
}

//Delete Data from Database

$sql="DELETE FROM tbl_food WHERE id=$id";

//Execute the Query
$res=mysqli_query($conn,$sql);

//Check whether the query executed succesfully or not

if($res==true)
{
//Query Executed Succesfully and Food Deleted
//echo "Food Deleted!"
//Create Session Variable to Display Message
$_SESSION['delete']="<div class='success'>Food Deleted Succesfully</div>";
//Redirect to Manage Food Page
header("location:".SITEURL."admin/manage-food.php");
}
else
{
   // echo "Failed to Delete Food!"

   $_SESSION['delete']="<div class='error'>Failed to Delete Food!</div>";
   //Redirect Page tO Manage Food
   header("location:".SITEURL."admin/manage-food.php");

}
//Redirect to Manage Food Page with Message


}
else{
//Redirect to Manage Food Page

//Redirect Page tO Manage Food
header("location:".SITEURL."admin/manage-food.php");

}
?>