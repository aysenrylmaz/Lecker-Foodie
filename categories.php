<?php include('partials-front/menu.php'); ?>

<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        //Create SQL Query to Display Categories from Database
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";   // It takes maximum 3 category

        $res = mysqli_query($conn, $sql);
        //Count rows to check whether the category is available or not
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            //Categories Available
            while ($row = mysqli_fetch_assoc($res)) {
                //Get the values like id, title
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>


                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id ?>;">
                    <div class="box-3 float-container">
                        <?php

                        //Check whether Image is available or not
                        if ($image_name == "") {
                            echo "<div class='error'> Image not Available! </div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" class="img-responsive img-curve">
                        <?php

                        }


                        ?>

                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>




        <?php

            }
        } else {
            //Categories not Available
            echo "<div class='error'> Category not Found!</div>";
        }

        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>