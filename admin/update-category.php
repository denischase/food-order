<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
            //check for set id
            if(isset($_GET['id']))
            {
                //get id and all other details
                //echo "getting the data";
                $id = $_GET['id'];
                //create sql query to get all details
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                //execute
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                if($count == 1)
                {
                    //get all data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect to ....
                    $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                         if($current_image != "")
                         {
                             //display image
                             ?>
                             <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
                             <?php
                         }
                         else
                         {
                             //dos[lay] message
                             echo "<div class='error'>Image not available</div>";
                         }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes

                        <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes

                        <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                   <td colspan="2">
                       <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                       <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="update category" class="btn-secondary btn-width">
                   </td>
                </tr>
            </table>
        </form>

        <?Php 
         if(isset($_POST['submit']))
         {
                //echo "clicked";
                //1. Get all the values From our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image =$_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Updating new Image if selected
                //check whether the image is selected or not
                if(isset($_FILES['image']['name'])){
                  //get image details  

                  $image_name = $_FILES['image']['name'];
                  //check whether the image is availabe or not
                  if($image_name!= "")
                  {
                    // image available
                    //A.upload the new image

                      //auto rename our image
                        //get the extension of our image e.g. "specialfood.jpg"
                        $ext = end(explode('.',$image_name));

                        //rename the Image
                        $image_name = "Food_Category_".random_int(000, 999).'.'.$ext;//e.g. Food_Category_544.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $detination_path = "../images/category/".$image_name;

                        //upload image
                        $upload = move_uploaded_file($source_path,$detination_path);

                        //check whether the image is uploaded or not
                        //and if the image is not uploaded then we stop and redirect with error message
                        if($upload == false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            //redirect
                            header('location'.SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }

                    //B. remove the current image
                    if($current_image != "")
                    {
                    $remove_path = "../images/category/". $current_image;
                    $remove = unlink($remove_path);

                    //check whether image is removed or not
                    //if failed then display error
                    if($remove == false){
                        $_SESSION['Failed-remove'] = "<div class='error'>Failed to remove current Image.</div>";
                        header('location'.SITEURL.'admin/manage-category.php');
                        die(); //stop process
                    }
                }
                  }
                  else
                  {
                    $image_name = $current_image;
                  }

                }
                else
                {
                    $image_name = $current_image;
                }

                //3. update the database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                
                    active = '$active'
                    where id=$id
                ";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                //4. Redirect to Manage Category with Message
                //check whether executed or not
                if($res2 == true)
                {
                    //Category updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                }
                else
                {
                    //Failed to update category
                    $_SESSION['update'] = "<div class='error'>Category Updated Unsuccessfully.</div>";
                    header("location:".SITEURL."admin/manage-category.php");
                }
                
         }
        ?>

        

    </div>
</div>

<?php include("partials/footer.php"); ?>