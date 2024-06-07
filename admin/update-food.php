<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>UPDATE FOOD </h1>
    <br><br>

    <?php

    //Check whether the id is set or not
    if (isset($_GET['id'])) {
      //1. Get the Id of Selected Food
      $id = $_GET['id'];

      //2. Create SQL Query to Get the Details
      $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

      //Execute the Query
      $res2 = mysqli_query($conn, $sql2);
      //Get the value based on query executed
      $row2 = mysqli_fetch_assoc($res2);

      //Get the Invidual Values of Selected Food
      $title = $row2['title'];
      $description = $row2['description'];
      $price = $row2['price'];
      $current_category = $row2['category_id'];
      $current_image = $row2['image_name'];
      $featured = $row2['featured'];
      $active = $row2['active'];
    } else {
      $_SESSION['no-food-found'] = "<div class='error'>Food not found!</div>";
      //Redirect Page tO Manage Food
      header("location:" . SITEURL . "food/manage-food.php");
    }

    ?>


    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-30">
        <tr>

          <td>Title: </td>
          <td>
            <input type="text" name="title" value="<?php echo $title; ?>">
          </td>
        </tr>

        <tr>

          <td>Description: </td>
          <td>
            <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
          </td>
        </tr>

        <tr>

          <td>Price: </td>
          <td>
            <input type="number" name="price" value="<?php echo $price; ?>">
          </td>
        </tr>


        <tr>
          <td>Current Image: </td>
          <td>
            <?php
            if ($current_image != "") {
            ?>

              <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
            <?php

              //Display the image

            } else {

              //Display Message
              echo "<div class='error'> Image Not Added.</div>";
            }


            ?>
          </td>
        </tr>


        <tr>

          <td>Select New Image: </td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>


        <tr>
          <td>Category: </td>
          <td>
            <select name="category">
              <?php

              //Create a SQL Query to Get all the food
              $sql = "SELECT * FROM tbl_category WHERE active='Yes'";  //It just select which one has active-Yes

              //Execute the query
              $res = mysqli_query($conn, $sql);

              //Count Rows to check whether we have foods or not
              $count = mysqli_num_rows($res);

              //Create Serial Number variable and Set default value as 1

              if ($count > 0) {

                //category available
                //Get the foods from Database and Display

                while ($row = mysqli_fetch_assoc($res)) {
                  //get the values from individual columns
                  $category_title = $row['title'];
                  $category_id = $row['id'];

                  //echo "<option value='$category_id'>$category_title</option>"; 
              ?>
                  <option <?php if ($current_category == $category_id) {
                            echo "Selected";
                          } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
              <?php
                }
              } else {
                //Category not available
                echo "<option valuable='0'> Category not available. </option>";
              }
              ?>

            </select>
          </td>
        </tr>


        <tr>
          <td>Featured: </td>
          <td>
            <input <?php if ($featured == "Yes") {
                      echo "checked";
                    } ?> type="radio" name="featured" value="Yes">Yes
            <input <?php if ($featured == "No") {
                      echo "checked";
                    } ?> type="radio" name="featured" value="No">No
          </td>
        </tr>

        <tr>
          <td>Active: </td>
          <td>
            <input <?php if ($active == "Yes") {
                      echo "checked";
                    } ?> type="radio" name="active" value="Yes">Yes
            <input <?php if ($active == "No") {
                      echo "checked";
                    } ?> type="radio" name="active" value="No">No
          </td>
        </tr>

        <tr>
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <input type="hidden" name="image" value="<?php echo $current_image; ?>">
          <!-- Reason of the hidden class, we need use this variable in sql update query by the submit click -->
          <td><input type="submit" name="submit" value="Update Food" class="btn-secondary"></td>
        </tr>

      </table>

    </form>
  </div>
</div>

<?php
//Check whhether the Submit Button is Clicked or not
if (isset($_POST['submit'])) {
  //echo "Button Clicked";
  //Get all the values from form to update
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $image_name = $_POST['image'];
  $category = $_POST['category'];
  $featured = $_POST['featured'];
  $active = $_POST['active'];

  //2. Updating New Image if selected
  //Check whether the image is selected or not

  if (isset($_FILES['image']['name'])) {
    //Upload button is clicked
    //Get the Image Details
    $image_name = $_FILES['image']['name'];

    //Check whether the image is available or not
    if ($image_name != "") {
      //Image Available

      //A. Upload the New Image

      //Auto Rename our Image
      //Get the Extension of ouur Image(jpg,png,gif,etc) e.g. "specialfood1.jpg"
      $tmp = explode('.', $image_name);
      $ext = end($tmp);  //it takes image attach    


      //Rename the Image
      $image_name = "Food_Name_" . rand(000, 999) . '.' . $ext; //e.g. Food_Name_834.jpg

      $source_path = $_FILES['image']['tmp_name'];

      $destination_path = "../images/food/" . $image_name;   //images will be saved in this folder

      //Finally Upload the Image
      $upload = move_uploaded_file($source_path, $destination_path);

      //Check whether the image is uploaded or not
      //And if the image is not uploaded then we will stop the process and redirect with error message

      if ($upload == false) {
        //Set Message
        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
        //Redirect to Add Food Page
        header("location:" . SITEURL . "admin/manage-food.php");
        //Stop the Process
        die();
      }

      //B: Remove the Current Image if available

      if ($current_image != "") {
        $remove_path = "../images/food/" . $current_image;
        $remove = unlink($remove_path);

        //Check whether the image is removed or not
        //If failed to remove then display message and stop the process

        if ($remove == false) {

          // echo "Failed to Update Food!"

          $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Image!</div>";
          //Redirect Page tO Manage Food
          header("location:" . SITEURL . "admin/manage-food.php");
          die(); //Stop the Process
        }
      }
    } else {
      $image_name = $current_image; //Default Image when Image is not selected
    }
  } else {
    $image_name = $current_image; //Default Image when button is not clicked
  }



  // 4. Update the Food in Database
  $sql3 = "UPDATE tbl_food SET
    title='$title',
    description='$description',
    price=$price,
    image_name='$image_name',
    category_id='$category',
    featured='$featured',
    active='$active'
    WHERE id='$id';

";

  //Execute the Query
  $res3 = mysqli_query($conn, $sql3);

  //Check whether the query executed succesfully or not

  if ($res3 == true) {
    //Query Executed Succesfully and Food Updated
    //echo "Food Updated!"
    //Create Session Variable to Display Message
    $_SESSION['update'] = "<div class='success'>Food Updated Succesfully</div>";
    //Redirect to Manage Food Page
    header("location:" . SITEURL . "admin/manage-food.php");
  } else {
    // echo "Failed to Update Food!"

    $_SESSION['update'] = "<div class='error'>Failed to Update Food!</div>";
    //Redirect Page tO Manage Food
    header("location:" . SITEURL . "admin/manage-food.php");
  }
}
?>


<?php include('partials/footer.php'); ?>