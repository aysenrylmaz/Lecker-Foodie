<?php include('partials/menu.php'); ?>

<!--Main Content Section Starts-->
<div class="main-content">
     <div class="wrapper">
     <h1>MANAGE ADMIN</h1>
     <br />
      <br />

      <?php 
      if(isset($_SESSION['add']))
      {

        echo $_SESSION['add'];   //Displaying Add Session Message
        unset($_SESSION['add']);  //Removing Add Session Message
      }

      if(isset($_SESSION['delete']))
      {

        echo $_SESSION['delete'];   //Displaying Delete Session Message
        unset($_SESSION['delete']);  //Removing Delete Session Message
      }


      if(isset($_SESSION['update']))
      {

        echo $_SESSION['update'];   //Displaying Update Session Message
        unset($_SESSION['update']);  //Removing Update Session Message
      }

      if(isset($_SESSION['user-not-found']))
      {

        echo $_SESSION['user-not-found'];   //Displaying Password not found Session Message
        unset($_SESSION['user-not-found']);  //Removing Password not found Session Message
      }

      if(isset($_SESSION['pwd-not-match']))
      {

        echo $_SESSION['pwd-not-match'];   //Displaying Password dont match Session Message
        unset($_SESSION['pwd-not-match']);  //Removing Password dont match  Session Message
      }


      if(isset($_SESSION['change-pwd']))
      {

        echo $_SESSION['change-pwd'];   //Displaying Password Change Session Message
        unset($_SESSION['change-pwd']);  //Removing Password Change Session Message
      }


      if(isset($_SESSION['current-and-new-same']))
      {

        echo $_SESSION['current-and-new-same'];   //Displaying Password current-and-new-same Session Message
        unset($_SESSION['current-and-new-same']);  //Removing Password current-and-new-same Session Message
      }
      
      
      ?>
<br />  <br />
     
    <!--Button to Add Admin-->
     <a href="<?php echo SITEURL;?>admin/add-admin.php" class="btn-primary">Add Admin</a>

     <br /> <br /> <br />

      <table class="tbl-full">
      <tr>
              <th>S.N.</th>
              <th>Full Name</th>
              <th>Username</th>
              <th>Actions</th>
          </tr>

          <?php
          //Query to Get All Admin
          $sql="SELECT * FROM tbl_admin";
          //Execute the Query
          $res=mysqli_query($conn,$sql);
          //Check whether the Query is Executed of Not

          if($res==TRUE)
          {
            //Count Rows to Check whether we have data in database or not
             $count=mysqli_num_rows($res);  //Function to get all the rows in database
             $sn=1;//Create a Variable and Assign the value
           //cHECK THE NUM OF ROWS
           if($count>0)
            {
              //We have data in database
              while($rows=mysqli_fetch_assoc($res))
              {
                //Using While Loop to get all the data from database
                //And while loop will run as long as we have data in database
                //Get Individual Data

                $id=$rows['id'];
                $full_name=$rows['full_name'];
                $username=$rows['username'];

                ?>

             <tr>
              <td><?php echo $sn++; ?>.</td>
              <td><?php echo $full_name; ?></td>
              <td><?php echo $username; ?></td>
              <td>
                <a href="<?php echo SITEURL?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Update Password</a>
                <a href="<?php echo SITEURL?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                <a href="<?php echo SITEURL?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
              </td>
            </tr>


<?php
                //Display the values in our Table
                //
              }
           }
            else{
              //We do not have data in database
            }
          }

          
          ?>
          
     </table>

     </div>
</div>
<!--Main Content Section Ends-->

<?php include('partials/footer.php'); ?>
