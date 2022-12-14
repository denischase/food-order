<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 

            if(isset($_SESSION['ad']))
            {
                echo $_SESSION['ad'];
                unset($_SESSION['ad']);
            }

            
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <br><br>
        <!--Add Category form starts-->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary btn-width">
                    </td>
                </tr>
            </table>

        </form>
        <!--Add Category form ends-->

        <?php

            //verify submition
            if(isset($_POST['submit']))
            {
                //echo "next level";
                $title = $_POST['title'];

                //for radio input, we need to check which button is select
                if(isset($_POST['featured']))
                {
                    //get value from form
                    $featured = $_POST['featured'];
                    
                }
                else
                {
                    //set default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }
                
                //check whether image is selected or not and set value for image name
               // print_r($_FILES['image']);

                //die();//break code

                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    //to upload image we need image name ,source path and destination path
                    $image_name = $_FILES['image']['name'];
                    //upload image only if image is selected
                    if($image_name != "")
                    {
                        //auto rename our image
                        //get the extension of our image e.g. "specialfood.jpg"
                        $ext = end(explode('.',$image_name));

                        //rename the Image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;//e.g. Food_Category_544.jpg

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
                            header('location'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }

                    }
                }
                else
                {
                    //dont upload image and set imagename value as blank
                    $image_name="";
                }

               // echo $title;
                //echo $featured;
                //echo $active;

                //create sql query to insert category into database
                $sql = "INSERT INTO tbl_category SET
                        title='$title',
                        image_name='$image_name',
                        featured='$featured',
                        active='$active'
                    ";
                    
                 //execute query and save into database
                $res = mysqli_query($conn, $sql); //or die(mysqli_error());

                //check whether the query executed successfully
                if($res==true)
                {
                    // query executed and category added
                   $_SESSION['ad'] = "<div class='success'>Category Added Successfully</div>";
                    //redirect to manage category page
                   header("location:".SITEURL.'admin/manage-category.php');
                   
                }
                else
                {
                    //failed to add category
                    $_SESSION['ad'] = "<div class='error'>Failed to Add Category.</div>";
                    //redirect to manage category page
                    header("location:".SITEURL.'admin/add-category.php');
                }
            }

        ?>
    </div>
</div>

<?php include('partials/footer.php');?>