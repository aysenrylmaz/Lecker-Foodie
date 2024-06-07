<?php include('partials/menu.php'); ?>

<div class="main-content">
<div class="wrapper">
     <h1>MANAGE CATEGORY</h1>
     <br />
      <br />

      <?php
      if(isset($_SESSION['add'])) //Checking whether the Session is Set or Not
      {
        echo $_SESSION['add'];   //Displaying the Session Message if Set
        unset($_SESSION['add']); //Removing the Session Message if Set
      }

      if(isset($_SESSION['remove'])) //Checking whether the Session is Set or Not
      {
        echo $_SESSION['remove'];   //Displaying the Session Message if Set
        unset($_SESSION['remove']); //Removing the Session Message if Set
      }

      if(isset($_SESSION['delete'])) //Checking whether the Session is Set or Not
      {
        echo $_SESSION['delete'];   //Displaying the Session Message if Set
        unset($_SESSION['delete']); //Removing the Session Message if Set
      }

      if(isset($_SESSION['no-category-found'])) //Checking whether the Session is Set or Not
      {
        echo $_SESSION['no-category-found'];   //Displaying the Session Message if Set
        unset($_SESSION['no-category-found']); //Removing the Session Message if Set
      }

      if(isset($_SESSION['update']))
      {

        echo $_SESSION['update'];   //Displaying Update Session Message
        unset($_SESSION['update']);  //Removing Update Session Message
      }

      if(isset($_SESSION['upload']))
      {

        echo $_SESSION['upload'];   //Displaying Update Session Message
        unset($_SESSION['upload']);  //Removing Update Session Message
      }

      if(isset($_SESSION['failed-remove']))
      {

        echo $_SESSION['failed-remove'];   //Displaying Update Session Message
        unset($_SESSION['failed-remove']);  //Removing Update Session Message
      }

      
      
      
      ?>
      <br><br>
    <!--Button to Add Admin-->
     <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-primary">Add Category</a>

     <br /> <br /> <br />

      <table class="tbl-full">
      <tr>
              <th>S.N.</th>
              <th>Title</th>
              <th>Image</th>
              <th>Featured</th>
              <th>Active</th>
              <th>Actions</th>
          </tr>

          <?php

          //Query to Get all Categories from Database
          $sql="SELECT * FROM tbl_category";
          
          //Execute Query
          $res=mysqli_query($conn,$sql);

          //Count Rows
          $count=mysqli_num_rows($res);


          //Create Serial Number Variable and assign value as 1
          $sn=1;
          //Check whether we have data in database or not
          if($count>0)
          {
            //We have data in database
            while($row=mysqli_fetch_assoc($res))
            {
              $id=$row['id'];
              $title=$row['title'];
              $image_name=$row['image_name'];
              $featured=$row['featured'];
              $active=$row['active'];

              ?>

          <tr>
              <td><?php echo $sn++; ?>.</td>
              <td><?php echo $title; ?></td>
              <td>
                
              <?php 
              //Check whether image name is available or not
              if($image_name!="")
              {
                //Display the image
                ?>
              <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="150px">
                <?php
              }
              else{
                 //Display the message
                 echo "<div class='error'>Image not added.</div>";
              }
              
              ?>

                  </td>
                  <td><?php echo $featured; ?></td>
                  <td><?php echo $active; ?></td>

                  <td>
                    <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update Category</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                  </td>
          </tr>



          <?php

}
}
else
 {
    // We do not have data
    //We'll display the message inside table
      
 }?>

     </table>


     <div class="clearfix"></div>
     </div>
</div>


<?php include('partials/footer.php'); ?>