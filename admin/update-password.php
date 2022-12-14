<?php include("partials/menu.php");?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
        if(isset($_GET['id']))
          {
            $id=$_GET['id'];
          }
        ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current Password:</td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>

            <tr>
                <td>New Password:</td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>

            <tr>
                <td>Confirm Password:</td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;  ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary btn-width">
                </td>
            </tr>
        </table>

        </form>
    </div>
</div>

<?php 

          //check whether the submit button is clicked on list
          if(isset($_POST['submit']))
          {
              //echo "Clicked";

              //get data from form
                 $id = $_POST['id'];
                 $current_password = md5($_POST['current_password']);
                 $new_password = md5($_POST['new_password']);
                 $confirm_password =md5($_POST['confirm_password']);


              //check whether user with current id and current password exists or not
                $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

              //excute the query
                $res = mysqli_query($conn, $sql);
                
                if($res == true)
                {
                    //check whether data is available or not
                    $count = mysqli_num_rows($res);

                    if($count == 1)
                    {
                        //user exist
                        //echo "user found";
                        //check whether the  new password and confirm match or not
                        if($new_password == $confirm_password)
                        {
                                //update the password
                                //echo "password match";
                                $sql2 = "UPDATE tbl_admin SET
                                    password = '$new_password'
                                    WHERE id=$id
                                ";

                                //execute query
                                $res2 = mysqli_query($conn, $sql2);

                                //check execution of query
                                if($res2 == true)
                                {
                                    //display success message
                                    //redirect to manage admin page with error
                                    $_SESSION['change-password'] = "<div class='success'>Password updated successfully</div>";
                                    //redirect user
                                    header('location:' . SITEURL . 'admin/manage-admin.php');
                                }
                                else
                                {
                                    //display error message
                                    //redirect to manage admin page with error
                                    $_SESSION['change-password'] = "<div class='error'>Password updated unsuccessfully</div>";
                                    //redirect user
                                    header('location:' . SITEURL . 'admin/manage-admin.php');
                                }
                        }
                        else
                        {
                            //redirect to manage admin page with error
                            $_SESSION['password-not-match'] = "<div class='error'>Password did not match</div>";
                            //redirect user
                            header('location:' . SITEURL . 'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        //user does not exist set message and redirect
                        $_SESSION['user-not-found'] = "<div class='error'>User not found</div>";
                        //redirect user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }

              //check whether the new Password and confirm password match or not
              
              //change pASSWORD if all above is true
          }


?>

<?php include("partials/footer.php");?>