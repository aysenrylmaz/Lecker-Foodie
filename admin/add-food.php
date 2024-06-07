<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
<br><br>

<?php
      if(isset($_SESSION['add'])) //Checking whether the Session is Set or Not
      {
        echo $_SESSION['add'];   //Displaying the Session Message if Set
        unset($_SESSION['add']); //Removing the Session Message if Set
      }

      if(isset($_SESSION['upload'])) //Checking whether the Session is Set or Not
      {
        echo $_SESSION['upload'];   //Displaying the Session Message if Set
        unset($_SESSION['upload']); //Removing the Session Message if Set
      }
      ?>


        <form action="" method="post" enctype="multipart/form-data">
           
        <table class="tbl-30">
           <tr>
            <td>Title:   </td>
            <td>
                <input type="text" name="title" placeholder="Title of the Food">
            </td>
           </tr>

           <tr>
            <td>Description:   </td>
            <td>
                <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"> </textarea>
            </td>
           </tr>

           <tr>
            <td>Price:   </td>
            <td>
                <input type="number" name="price">
            </td>
           </tr>

           <tr>
            <td>Select Image:   </td>
            <td>
                <input type="file" name="image" >
            </td>
           </tr>


           <tr>
            <td>Category:   </td>
            <td>
                <select name="category">

                <?php
                  //Create PHP Code to display categories from Database
                  //1. Create SQL to get all active categories from database
                  $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                  //Executing query
                  $res=mysqli_query($conn, $sql);

                  //Count Rows to ceck whether we have categories or not
                  $count=mysqli_num_rows($res);

                  //If count is greater thhan zero, we have categories else we do not have categories

                  if($count>0)
                  {
                    //we have categories
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the details of categories
                        $id=$row['id'];
                        $title=$row['title'];

                        ?>
                            <option value="<?php echo $id; ?>"><?php echo $title;  ?></option>

                        <?php

                    }

                  }
                  else
                  {
                       //we do not hhave categories
                       ?>

                       <option value="0">No Category Found</option>

                       <?php

                  }
                  //2. Display on Dropdowm
                
                ?>
                </select>
            </td>
           </tr>


            <tr>
            <td>Featured:</td>
            <td>
                <input type="radio" name="featured" value="Yes"> Yes
                <input type="radio" name="featured" value="No"> No
                     </td>
             </tr>


           <tr>
            <td>Active:</td>
            <td>
               <input type="radio" name="active" value="Yes">Yes
               <input type="radio" name="active" value="No">No
            </td>
           </tr>


           <tr>
             <td colspan="2">
                <input type="submit" name="submit" value="Add Food" class="btn-secondary">
             </td>

           </tr>


        </table>
        </form>

<?php
//Check whether the button is clicked or not
  if(isset($_POST['submit']))
{     //Add the Food in Dtabase
      //   echo "Clicked";
      //1. Get the Data from Form
      $title=$_POST['title'];
      $description=$_POST['description'];
      $price=$_POST['price'];
      $category=$_POST['category'];


      //Check whether radion button for  featured and active are checked or not
      if(isset($_POST['featured']))
      {
           $featured=$_POST['featured'];

      }
      else
      {
        $featured="No";
      }

      if(isset($_POST['active']))
      {
        $active=$_POST['active'];
      }
      else
      {
        $active="No"; //Setting Default Value
      }

      //2. Upload the Image if selected
      //Check whether the select image is clicked or not and upload the image only if the image is selected

      if(isset($_FILES['image']['name']))
      {
        //Get the details of the selected image
        $image_name=$_FILES['image']['name'];

        //Check whether the Image is selected or not and upload image only if selected
         if($image_name !="")
         {
            //Image is Selected
            //A. Rename the Image
            //Get the extension of selected image(jpg,png,gof,etc.)
            $tmp = explode('.',$image_name);
            $ext=end($tmp);  //it takes image attach    
            
            //Create new name for Image
            $image_name="Food_Name_".rand(0000,9999).".".$ext; //New Image Name May be "Food-Name-657.jpg"
            //B. Upload the Image
            //Get the Src Path and Destination path

            //Source path is the current location of the image
            $src=$_FILES['image']['tmp_name'];

            //Destination path for the image to be uploaded
            $dst="../images/food/".$image_name;

            //Finally upload the food image
            $upload=move_uploaded_file($src,$dst);


            //check whether image uploaded of not
            if($upload==false)
            {
                //Failed to Upload the Image
                //Redirect to Add Food Page with Error Message
                $_SESSION['upload']="<div class='error'> Failed to Upload Image.</div>";
                 header("location:".SITEURL."admin/add-food.php");
                //Stop the Process
                die();
            }
        }
      }
      else
      {
        $image_name=""; //Setting Default Value as blank
      }


      //3. Insert Into Database    
      
      //Create a SQL Query to Save or Add food
      //For Numerical we do not need to pass value inside quotes '' But for string value is it compulsory to add quotes ''
      $sql2="INSERT INTO tbl_food SET
      title='$title',
      description='$description',
      price=$price,
      image_name='$image_name',
      featured='$featured',
      active='$active',
      category_id=$category
      ";
      
    //3. Execute the Query and Save in Database
         $res2=mysqli_query($conn,$sql2);

   //4. Check whether the query executed or not and data added or not
   if($res2==true)
   {

    //Query Executed and Food Added

    $_SESSION['add']="<div class='success'>Food Added Succesfully.</div>";
   //Redirect Page tO Manage Food
   header("location:".SITEURL."admin/manage-food.php");


   }
   else
   {
    //Failed to Add Food
    $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
   //Redirect Page tO Manage Food
   header("location:".SITEURL."admin/manage-food.php");
   }
  




}


?>



    </div>
</div>
<?php include('partials/footer.php'); ?>