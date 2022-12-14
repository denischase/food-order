<?php 
    //include constant.php file here
    include("../config/constant.php");

    //get id of admin to be delete
    echo $id = $_GET['id'];

    //create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the query executed successfully or not
    if($res == true)
    {
        //query execution no problem
        //echo "Admin Deleted";
        //create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin Delete Successfully.</div>";
        //Redirect to Manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //query execution yes problem
        //echo "Failed To Delete Admin";
        $_SESSION['delete'] = "<div class='error'>Failed To Delete Admin.</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    //redirect to manage admin page with message(success/error)

?>