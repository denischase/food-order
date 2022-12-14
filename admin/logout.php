<?php 
    //include constants.php
    include("../config/constant.php");
    
    //destroy session
    session_destroy(); //unset session user

    //redirect to login page
    header('location:'.SITEURL.'admin/login.php');

?>