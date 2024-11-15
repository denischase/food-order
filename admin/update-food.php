<?php include('partials/menu.php'); ?>

<?php 
 //get id
 if(isset($_GET['id']))
 {
    //get all the details
    $id = $_GET['id'];

    //sql query
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    //execute the query
    $res2 = mysqli_query($conn, $sql2);
    
    $row2 = mysqli_fetch_assoc($res2);

    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
 }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" value=""><?php echo $description; ?></textarea>
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
                    if($current_image == "")
                    {
                        //image not available
                        echo "<div class='error'>Image not available</div>";
                    }
                    else
                    {
                        //image available
                        ?>
                        <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" width="150px">
                        <?php
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
                            //get data from ddatabase
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //xcute query
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if($count > 0)
                            {
                                //cat available
                                while($row=mysqli_fetch_assoc($res)){
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //no cat
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                        ?>

                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>
            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($active == "Yes") {echo "checked";} ?>  type="radio" name="active" value="Yes">Yes
                    <input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>

        <?php 
          if(isset($_POST['submit']))
          {
            //echo "button clicked"

            //1. get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. upload the image if selected

            //check upload button clicked
            if(isset($_FILES['image']['name']))
            {
                //upload btn clicked
                $image_name = $_FILES['image']['name']; //new image name

                //check availability of files
                if($image_name!="")
                {
                    //image available
                    //a.upload new image
                    //rename the image
                    $ext = end(explode('.', $image_name)); // get img ext

                    $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //rename image

                    //get source path and destination path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/food/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //veryfy upload
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }

                    //3. remove the image if new image is uploaded and current image exists
                    //b. remove current image if available
                    if($current_image!="")
                    {
                        //current image is availabe
                        //remove the image
                        $remove_path = "../images/food/".$current_image;
                        $remove = unlink($remove_path);

                        //verify
                        if($remove == false)
                        {
                            ///failed to remove current image
                            $_SESSION['remove-failed'] = "<div class='error'>failed to remove current image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        } 

                    }
                }
                else
                {
                    $image_name = $current_image; //default image when image is not selected
                }
            }
            else
            {
                $image_name = $current_image; //default image when button is clicked
            }

            

            //4. update the food to database
            $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

            // echo $sql4;

            //execute query
            $res3 = mysqli_query($conn, $sql3);

            //check whether the query is executed  
            if($res3 == true)
            {
                $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                $_SESSION['update'] = "<div class='error'>Food Updated Unsuccessfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                
            }

            
          }

        ?>        

    </div>
</div>

<?php include('partials/footer.php'); ?>