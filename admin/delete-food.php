<?php 
//include constant page
// include ("../config/constant.php");

// //echo "delete";

// if (isset($_GET['id']) AND isset($_GET['image_name']))
// {
//   //echo "process to delete";

//   //get data
//   $id = $_GET['id'];
//   $image_name = $_GET['image_name'];

//   //remove image if AVailable
//     if ($image_name != "")
//     {
//         $path = "../images/food/".$image_name;

//         //remove image file from folder
//         $remove = unlink($path);

//         //verify image removal
//         if($remove == false)
//         {
//             //failed to remove
//             $_SESSION['upload'] = "<div class='error'>Failed to Remove food Image.</div>";
//             header("location:".SITEURL."admin/manage-food.php");
//             die();
//         }
//     }
//   //delete food from database
//   $sql = "DELETE FROM tbl_food WHERE id=$id";
//   //execute
//   $res = mysqli_query($conn, $sql);
//   //redirect 
//   if($res==true)
//   {
//       //success
//       $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
//             header("location:".SITEURL."admin/manage-food.php");
            
//   }
//   else
//   {
//     //failed
//     $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
//             header("location:".SITEURL."admin/manage-food.php");
//             die();
//   }

  
// }
// else
// {
//     //redirect 
//     //echo "redirect";
//     $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
//     header("location:".SITEURL."admin/manage-food");
// }

?>

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
            $path = "../images/food/".$image_name;
            //remove the image
            $remove = unlink($path);

            //if failed to remove image then add error message
            if($remove == false)
            {
                //set session message 
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove food Image.</div>";
                //redirect to manage category page 
                header("location:".SITEURL."admin/manage-food.php");
                die();
            }
        }

        //Delete data from database
        $sql = "DELETE FROM tbl_food where id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //check whether data is deleted
        if($res==true)
        {
            //set success message and redirect
            $_SESSION['delete'] = "<div class='success'>food Deletion Successful</div>";
            //redirect to manage category
            header("location:".SITEURL."admin/manage-food.php");

        }
        else
        {
            //set failed message and redirect
            $_SESSION['delete'] = "<div class='error'>food Deletion Unsuccessful</div>";
            //redirect to manage category
            header("location:".SITEURL."admin/manage-food.php");
        }

        
    }
    else
    {
        //redirect to manage category page
        header("location:".SITEURL."admin/manage-food.php");
    }
?>