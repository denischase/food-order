<?php include("../config/constant.php");?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body class="login-body">

        <div class="login">
            <h1 class="text-center">Login</h1>
            <br/>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset ($_SESSION['no-login-message']);
                }
            ?>
            <br/><br/>

            <!--login form starts here-->
            <form action="" method="POST" class="text-center">
                Username:<br/>
                <input type="text" name="username" placeholder="Enter Username">
                <br/><br/>
                Password:<br/>
                <input type="password" name="password" placeholder="Enter Password">
                <br/><br/>
                <input type="submit" name="submit" value="Login" class="btn-primary btn-width">
            </form>
            <!--login form ends here-->
            <br/>


            <p class="text-center">Created By - <a href="#">Derflastorm</a></p>
        </div>

    </body>
</html>

<?php 
    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //process for login
        //get data from user login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']);

        $password = mysqli_real_escape_string($conn, $raw_password);

        //sql to check existence of username
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //count rows to check existence of username
        $count = mysqli_num_rows($res);
        
        if($count == 1)
        {
            //user available and login success
            $_SESSION['login'] = "<div class='success text-center'>Login Successful</div>";
            $_SESSION['user'] = $username; //check whether user is logged in and logout wil unset
            //redirect to homepage or dashboard
            header('location:'.SITEURL.'admin/');

        }
        else
        {
            //user not available
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
             //redirect to homepage or dashboard
             header('location:'.SITEURL.'admin/login.php');
        }
    }

?>