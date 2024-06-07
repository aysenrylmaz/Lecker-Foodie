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
  $path="../images/category/".$image_name;

  //Remove the Image
  $remove=unlink($path);

  //If failed to remove image then add an error message and stop the process
  if($remove==false)
{
     //Set the Session Message
     $_SESSION['remove']="<div class='error'>Fail to Remove Category Image.</div>";
     //Redirect to Manage Category Page
     header("location:".SITEURL."admin/manage-category.php");
     //Stop the Process
     die();

}
}

//Delete Data from Database

$sql="DELETE FROM tbl_category WHERE id=$id";

//Execute the Query
$res=mysqli_query($conn,$sql);

//Check whether the query executed succesfully or not

if($res==true)
{
//Query Executed Succesfully and Category Deleted
//echo "Category Deleted!"
//Create Session Variable to Display Message
$_SESSION['delete']="<div class='success'>Category Deleted Succesfully</div>";
//Redirect to Manage Category Page
header("location:".SITEURL."admin/manage-category.php");
}
else
{
   // echo "Failed to Delete Category!"

   $_SESSION['delete']="<div class='error'>Failed to Delete Category!</div>";
   //Redirect Page tO Manage Category
   header("location:".SITEURL."admin/manage-category.php");

}
//Redirect to Manage Category Page with Message


}
else{
//Redirect to Manage Category Page

//Redirect Page tO Manage Category
header("location:".SITEURL."admin/manage-category.php");

}
?>