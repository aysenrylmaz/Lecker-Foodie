<?php include('partials/menu.php'); ?>

<!--Main Content Section Starts-->
<div class="main-content">
   <div class="wrapper">
      <h1>DASHBOARD</h1>
      <br>
      <?php
      if (isset($_SESSION['login'])) {

         echo $_SESSION['login'];   //Displaying Login Session Message
         unset($_SESSION['login']);  //Removing Login Session Message
      }
      ?>
      <br><br>
      <div class="col-4 text-center">
         <?php
         //Sql Query 
         $sql = "SELECT * FROM tbl_category";
         //Execute the Query
         $res = mysqli_query($conn, $sql);
         //Count Rows
         $count = mysqli_num_rows($res);
         ?>
         <h1><?php echo $count; ?></h1>
         Categories
      </div>

      <div class="col-4 text-center">
         <?php
         //Sql Query 
         $sql2 = "SELECT * FROM tbl_food";
         //Execute the Query
         $res2 = mysqli_query($conn, $sql2);
         //Count Rows
         $count2 = mysqli_num_rows($res2);
         ?>

         <h1><?php echo $count2; ?></h1>
         Foods
      </div>

      <div class="col-4 text-center">

         <?php
         //Sql Query 
         $sql3 = "SELECT * FROM tbl_order";
         //Execute the Query
         $res3 = mysqli_query($conn, $sql3);
         //Count Rows
         $count3 = mysqli_num_rows($res3);
         ?>
         <h1><?php echo $count3; ?></h1>
         Total Orders
      </div>

      <div class="col-4 text-center">

         <?php
         // Create SQL Query to Get Total Revenue Generated
         //Aggregaet Function in SQL
         $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
         //Execute the Query
         $res4 = mysqli_query($conn, $sql4);
         //Get the Value
         $row4 = mysqli_fetch_assoc($res4);
         //Get the Total Revenue
         $total_revenue = $row4['Total'];
         ?>
         <h1>$<?php echo $total_revenue; ?></h1>
         Revenue Generated
      </div>

      <div class="clearfix"></div>

   </div>
</div>
<!--Main Content Section Ends-->
<?php include('partials/footer.php'); ?>