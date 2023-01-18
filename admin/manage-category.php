<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br /><br />

        <?php

        if (isset($_SESSION['ad'])) {
            echo $_SESSION['ad'];
            unset($_SESSION['ad']);
        }

        if(isset($_SESSION['remove']))
        {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['no-category-found']))
        {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }

        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['Failed-remove'])){
            echo $_SESSION['Failed-remove'];
            unset($_SESSION['Failed-remove']);
        }
        ?>

        <br /><br />

        <!--Button to add admin-->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary btn-width">Add Category</a>

        <br /><br /><br />

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
            //queryto get all categories from database
            $sql = "SELECT * FROM tbl_category";

            //execute query
            $res = mysqli_query($conn, $sql);

            //count rows
            $count = mysqli_num_rows($res);

            //create a serial number varialble
            $sn = 1;

            //check whether we have data in database or not
            if ($count > 0) {
                //we have data
                //get data and display
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title']; 
                    $image_name = $row['image_name'];
                    $Featured = $row['featured'];
                    $active = $row['active'];

                ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>

                        <td>
                            <?php //echo $image_name; 
                                //check availabilty of image
                                if($image_name != "")
                                {
                                    //display the image
                                    ?>

                                    <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name; ?>" width="100px">
                                    
                                    <?php
                                }
                                else
                                {
                                    //display the message
                                    echo "<div class='error'>Image Not Available.</div>";
                                }

                            ?>
                        </td>

                        <td><?php echo $Featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
                        </td>
                    </tr>

                <?php
                }
            } else {
                //we do not have data
                //display message in table
                ?>

                <tr>
                    <td colspan="6">
                        <div class="error">No Category Added.</div>
                    </td>
                </tr>

            <?php
            }

            ?>




        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>