<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>MANAGE FOOD</h1>
    <br />
    <br />

    <?php
    if (isset($_SESSION['add'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['add'];   //Displaying the Session Message if Set
      unset($_SESSION['add']); //Removing the Session Message if Set
    }

    if (isset($_SESSION['remove'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['remove'];   //Displaying the Session Message if Set
      unset($_SESSION['remove']); //Removing the Session Message if Set
    }

    if (isset($_SESSION['delete'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['delete'];   //Displaying the Session Message if Set
      unset($_SESSION['delete']); //Removing the Session Message if Set
    }

    if (isset($_SESSION['upload'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['upload'];   //Displaying the Session Message if Set
      unset($_SESSION['upload']); //Removing the Session Message if Set
    }

    if (isset($_SESSION['update'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['update'];   //Displaying the Session Message if Set
      unset($_SESSION['update']); //Removing the Session Message if Set
    }

    if (isset($_SESSION['failed-remove'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['failed-remove'];   //Displaying the Session Message if Set
      unset($_SESSION['failed-remove']); //Removing the Session Message if Set
    }

    if (isset($_SESSION['no-food-found'])) //Checking whether the Session is Set or Not
    {
      echo $_SESSION['no-food-found'];   //Displaying the Session Message if Set
      unset($_SESSION['no-food-found']); //Removing the Session Message if Set
    }
    ?>

    <!--Button to Add Admin-->
    <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

    <br /> <br /> <br />

    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
      </tr>

      <?php

      //Create a SQL Query to Get all the food
      $sql = "SELECT * FROM tbl_food";

      //Execute the query
      $res = mysqli_query($conn, $sql);

      //Count Rows to check whether we have foods or not
      $count = mysqli_num_rows($res);

      //Create Serial Number variable and Set default value as 1
      $sn = 1;

      if ($count > 0) {

        //We have food in Database
        //Get the foods from Database and Display

        while ($row = mysqli_fetch_assoc($res)) {
          //get the values from individual columns
          $id = $row['id'];
          $title = $row['title'];
          $price = $row['price'];
          $image_name = $row['image_name'];
          $featured = $row['featured'];
          $active = $row['active'];
      ?>

          <tr>
            <td><?php echo $sn++; ?>.</td>
            <td><?php echo $title; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php
                //Check whether image name is available or not
                if ($image_name != "") {
                  //Display the image
                ?>
                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="150px">
              <?php
                } else {
                  //Display the message
                  echo "<div class='error'>Image not added.</div>";
                }
              ?>
            </td>
            <td><?php echo $featured; ?></td>
            <td><?php echo $active; ?></td>
            <td>
              <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Update Food</a>
              <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
            </td>
          </tr>

      <?php

        }
      } else {

        //Food not Added in Database
        echo "<tr><td colspan='7' class='error'> Food not added yet.</td></tr>";
      }

      ?>
    </table>


    <div class="clearfix"></div>
  </div>
</div>
<?php include('partials/footer.php'); ?>