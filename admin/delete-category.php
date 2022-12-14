<?php 
    //include constant file
    include("../config/constant.php");
    //echo "delete btn !"
    //check whether the id and image value is set
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "get val and img";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image file if available
        if($image_name != "")
        {
            //image available
            $path = "../images/category/".$image_name;
            //remove the image
            $remove = unlink($path);

            //if failed to remove image then add error message
            if($remove == false)
            {
                //set session message 
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove category Image.</div>";
                //redirect to manage category page 
                header("location:".SITEURL."admin/manage-category.php");
                die();
            }
        }

        //Delete data from database
        $sql = "DELETE FROM tbl_category where id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //check whether data is deleted
        if($res==true)
        {
            //set success message and redirect
            $_SESSION['delete'] = "<div class='success'>Category Deletion Successful</div>";
            //redirect to manage category
            header("location:".SITEURL."admin/manage-category.php");

        }
        else
        {
            //set failed message and redirect
            $_SESSION['delete'] = "<div class='error'>Category Deletion Unsuccessful</div>";
            //redirect to manage category
            header("location:".SITEURL."admin/manage-category.php");
        }

        
    }
    else
    {
        //redirect to manage category page
        header("location:".SITEURL."admin/manage-category.php");
    }
?>