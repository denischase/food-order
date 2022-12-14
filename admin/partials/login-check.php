<?php 

//authorization - access control
//check whether user is logged in or not
if(!isset($_SESSION['user'])) // user session not set
{
    //user is not logged in
    //redirect to login page
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";
    //redirect to login page
    header('location:'.SITEURL.'admin/login.php');
}

?>