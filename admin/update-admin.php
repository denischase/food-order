<?php include("partials/menu.php");?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br>

        <?php 
            //get id of selected admin
               $id = $_GET['id']; 

            //create sql to get details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //check whether the query is executed or not
            if($res == true)
            {
                //check whether the data is available or not
                $count = mysqli_num_rows($res);
                //check whether we have admin data or not
                if($count == 1)
                {
                    //get details
                    //echo"admin available";
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else
                {
                    //redirect to manage Admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {

            }
        ?>

            <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name;?>">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username;?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary btn-width">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php 
    //check whether the submit Button is clicked or not
    if(isset($_POST['submit']))
    {
       // echo "button clicked";
       // get all the values from form to update
       $id = $_POST['id'];
       $full_name = $_POST['full_name'];
       $username = $_POST['username'];

       //create sql to update admin
       $sql = "UPDATE tbl_admin SET
       full_name =  '$full_name',
       username = '$username' 
       WHERE id = '$id' 
       ";

       //executed the query
       $res = mysqli_query($conn, $sql);

       //check whether query executed
       if($res == true)
       {
            //query executed and admin updated
            $_SESSION['update'] = "<div class='success'>Admin Update Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
       }
       else
       {
            //query not executed
            $_SESSION['update'] = "<div class='error'>Admin Update Unsuccessfull.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
       }
    }
?>

<?php include("../admin/partials/footer.php");?>
