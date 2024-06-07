<?php include('partials/menu.php'); ?>

<div class="main-content">
   <div class="wrapper">
      <h1>UPDATE ORDER</h1>
      <br><br>

      <?php

      //Check whether the id is set or not
      if (isset($_GET['id'])) {
         //1. Get the Id of Selected Category
         $id = $_GET['id'];

         //2. Create SQL Query to Get the Details
         $sql = "SELECT * FROM tbl_order WHERE id=$id";

         //Execute the Query
         $res = mysqli_query($conn, $sql);
         //Count the rows to check whether the id is valid or not
         $count = mysqli_num_rows($res);

         //Check whether we have category data or not
         if ($count == 1) {
            //Get the Details
            //echo "Category Available";

            $row = mysqli_fetch_assoc($res);
            $food = $row['food'];
            $price = $row['price'];
            $qty = $row['qty'];
            $total = $row['total'];
            $order_date = $row['order_date'];
            $status = $row['status'];
            $customer_name = $row['customer_name'];
            $customer_contact = $row['customer_contact'];
            $customer_email = $row['customer_email'];
            $customer_address = $row['customer_address'];
         } else {
            $_SESSION['no-order-found'] = "<div class='error'>Order not found!</div>";
            //Redirect Page tO Manage Order
            header("location:" . SITEURL . "admin/manage-order.php");
         }
      } else {
         //Redirect Page tO Manage Order
         header("location:" . SITEURL . "admin/manage-order.php");
      }
      ?>

      <form action="" method="POST" enctype="multipart/form-data">
         <table class="tbl-30">
            <tr>

               <td>Food: </td>
               <td>
                  <b><?php echo $food; ?> </b>
               </td>
            </tr>

            <tr>

               <td>Price: </td>
               <td>
                  <input type="number" name="price" value="<?php echo $price; ?>">
               </td>
            </tr>

            <tr>

               <td>Qty: </td>
               <td>
                  <input type="number" name="qty" value="<?php echo $qty; ?>">
               </td>
            </tr>


            <tr>

               <td>Total: </td>
               <td>
                  <input type="number" name="total" value="<?php echo $total; ?>">
               </td>
            </tr>


            <tr>

               <td>Status: </td>
               <td>
                  <select name="status">
                     <option <?php if ($status == "Ordered") {
                                 echo "selected";
                              } ?> value="Ordered">Ordered</option>
                     <option <?php if ($status == "notReady") {
                                 echo "selected";
                              } ?> value="notReady">Order is not ready</option>
                     <option <?php if ($status == "onDelivery") {
                                 echo "selected";
                              } ?> value="onDelivery">On Delivery</option>
                     <option <?php if ($status == "Delivered") {
                                 echo "selected";
                              } ?> value="Delivered">Delivered</option>
                     <option <?php if ($status == "Cancelled") {
                                 echo "selected";
                              } ?> value="Cancelled">Cancelled</option>

                  </select>
               </td>
            </tr>

            <tr>

               <td>Customer Name: </td>
               <td>
                  <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
               </td>
            </tr>
            <tr>

               <td>Customer Contact: </td>
               <td>
                  <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
               </td>
            </tr>
            <tr>

               <td>Customer Address: </td>
               <td>
                  <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
               </td>
            </tr>

            <tr>
               <input type="hidden" name="id" value="<?php echo $id; ?>">
               <!-- Reason of the hidden class, we need use this variable in sql update query by the submit click -->
               <td colspan="2"><input type="submit" name="submit" value="Update Order" class="btn-secondary"></td>
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
   $price = $_POST['price'];
   $qty = $_POST['qty'];

   $total =  $price * $qty;

   $status = $_POST['status'];
   $customer_name = $_POST['customer_name'];
   $customer_contact = $_POST['customer_contact'];
   $customer_address = $_POST['customer_address'];

   //2. Updating New Image if selected
   //Check whether the image is selected or not

?>

   <?php echo $total; ?>
<?php

   //Create a SQL Query to Update Category
   $sql2 = "UPDATE tbl_order SET
         qty=$qty,
         total=$total,
         status='$status',
         customer_name='$customer_name',
         customer_contact='$customer_contact',
         customer_address='$customer_address'
         WHERE id='$id'";


   //Execute the Query
   $res2 = mysqli_query($conn, $sql2);

   //Check whether the query executed succesfully or not

   if ($res2 == true) {
      //Query Executed Succesfully and Category Updated
      //echo "Category Updated!"
      //Create Session Variable to Display Message
      $_SESSION['update'] = "<div class='success'>Order Updated Succesfully</div>";
      //Redirect to Manage Category Page
      //header("location:".SITEURL."admin/manage-order.php");
   } else {
      // echo "Failed to Update Category!"

      $_SESSION['update'] = "<div class='error'>Failed to Update Order!</div>";
      //Redirect Page tO Manage Category
      // header("location:".SITEURL."admin/manage-order.php");

   }
}
?>

<?php include('partials/footer.php'); ?>