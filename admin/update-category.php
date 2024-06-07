<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>UPDATE CATEGORY </h1> 
     <br><br>

     <?php

     //Check whether the id is set or not
     if(isset($_GET['id']))
     {
        //1. Get the Id of Selected Category
        $id=$_GET['id'];
        
        //2. Create SQL Query to Get the Details
        $sql="SELECT * FROM tbl_category WHERE id=$id";
        
        //Execute the Query
        $res=mysqli_query($conn,$sql);
        //Count the rows to check whether the id is valid or not
        $count=mysqli_num_rows($res);
        
        //Check whether we have category data or not
        if($count==1)
        {
            //Get the Details
            //echo "Category Available";
        
            $row=mysqli_fetch_assoc($res);
            $title=$row['title'];
            $current_image=$row['image_name'];
            $featured=$row['featured'];
            $active=$row['active'];
        }
        else
        {
            $_SESSION['no-category-found']="<div class='error'>Category not found!</div>";
            //Redirect Page tO Manage Category
            header("location:".SITEURL."admin/manage-category.php");
        
        }
        }
        ?>

     <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
        <tr>

           <td>Title: </td>
            <td>
               <input type="text" name="title" value="<?php echo $title;?>">
            </td>
        </tr>


        <tr>
            <td>Current Image: </td>
            <td>
               <?php
                if($current_image !="")
                {
                    ?>

                  <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image; ?>" width="150px">
                    <?php

                  //Display the image

                }
                else{

                    //Display Message
                    echo "<div class='error'> Image Not Added.</div>";
                }
               
               
               ?>
            </td>
        </tr>

        <tr>
            <td>New Image: </td>
            <td>
                <input type="file" name="image">
            </td>
        </tr>

        <tr>
            <td>Featured: </td>
            <td>
                <input  <?php if($featured=="Yes") {echo "checked";}?>  type="radio" name="featured" value="Yes">Yes
                <input   <?php if($featured=="No") {echo "checked";}?>  type="radio" name="featured" value="No">No
            </td>
        </tr>

        <tr>
            <td>Active: </td>
            <td>
                <input <?php if($active=="Yes") {echo "checked";}?>  type="radio" name="active" value="Yes">Yes
                <input <?php if($active=="No") {echo "checked";}?>   type="radio" name="active" value="No">No
            </td>
        </tr>

        <tr>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="hidden" name="image" value="<?php echo $current_image;?>">
             <!-- Reason of the hidden class, we need use this variable in sql update query by the submit click -->
            <td><input type="submit" name="submit" value="Update Category" class="btn-secondary"></td>
        </tr>

        </table>

     </form>
    </div>
</div>

<?php
//Check whhether the Submit Button is Clicked or not
if(isset($_POST['submit']))
{
 //echo "Button Clicked";
//Get all the values from form to update
$id=$_POST['id'];
$title=$_POST['title'];
$image_name=$_POST['image'];
$featured=$_POST['featured'];
$active=$_POST['active'];

//2. Updating New Image if selected
//Check whether the image is selected or not

if(isset($_FILES['image']['name']))
{
    //Get the Image Details
    $image_name=$_FILES['image']['name'];

    //Check whether the image is available or not
    if($image_name !="")
    {
        //Image Available

        //A. Upload the New Image

        //Auto Rename our Image
        //Get the Extension of ouur Image(jpg,png,gif,etc) e.g. "specialfood1.jpg"
        $tmp = explode('.',$image_name);
        $ext=end($tmp);  //it takes image attach    
        
        //Rename the Image
        $image_name="Food_Category_".rand(000,999).'.'.$ext; //e.g. Food_Category_834.jpg

        $source_path=$_FILES['image']['tmp_name'];

        $destination_path="../images/category/".$image_name;   //images will be saved in this folder

        //Finally Upload the Image
        $upload=move_uploaded_file($source_path,$destination_path);

        //Check whether the image is uploaded or not
        //And if the image is not uploaded then we will stop the process and redirect with error message

        if($upload==false)
        {
           //Set Message
           $_SESSION['upload']="<div class='error'>Failed to Upload Image. </div>";
           //Redirect to Add Category Page
           header("location:".SITEURL."admin/manage-category.php");
           //Stop the Process
           die();
        }

         //B: Remove the Current Image if available

         if($current_image!=""){
         $remove_path="../images/category/".$current_image;
         $remove=unlink($remove_path);

         //Check whether the image is removed or not
        //If failed to remove then display message and stop the process

        if($remove==false)
        {
           
           // echo "Failed to Update Category!"

                $_SESSION['failed-remove']="<div class='error'>Failed to Remove Image!</div>";
                //Redirect Page tO Manage Category
                header("location:".SITEURL."admin/manage-category.php");
                die(); //Stop the Process
        }
        }

    }
    else
    {
        $image_name=$current_image;
    }

}
else
{
    $image_name=$current_image;
}

//Create a SQL Query to Update Category
$sql2="UPDATE tbl_category SET
title='$title',
image_name='$image_name',
featured='$featured',
active='$active'
WHERE id='$id'" ;


//Execute the Query
$res2=mysqli_query($conn,$sql2);

//Check whether the query executed succesfully or not

if($res2==true)
{
//Query Executed Succesfully and Category Updated
//echo "Category Updated!"
//Create Session Variable to Display Message
$_SESSION['update']="<div class='success'>Category Updated Succesfully</div>";
//Redirect to Manage Category Page
header("location:".SITEURL."admin/manage-category.php");
}
else
{
   // echo "Failed to Update Category!"

   $_SESSION['update']="<div class='error'>Failed to Update Category!</div>";
   //Redirect Page tO Manage Category
   header("location:".SITEURL."admin/manage-category.php");

}


}
?>

<?php include('partials/footer.php'); ?>