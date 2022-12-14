<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        
        <br><br>
        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter fullname">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" >
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>

<?php
     //process the value of form and save to database

     //check whether the submit button is clicked or not

     if(isset($_POST['submit']))
     {
         //button clicked
        //echo "button clicked";

        // 1.get data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encripted with md54

        //2. sql query to save data into database
        $sql = "INSERT INTO tbl_admin SET
               full_name = '$full_name',
               username = '$username',
               password = '$password'
        ";
        
        //executing query and saving data into database
         $res = mysqli_query($conn, $sql) or die(mysqli_error());

         //4.check whether tha data  is inserted or not 
         if($res == True)
         {
                //data inserted
                //echo "Data inserted";
                //create session variables to display message
                $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
                //redirect page
                header("location:".SITEURL.'admin/manage-admin.php');
         }
         else
         {
                //data insert error
               // echo "Failed to insert";
                //create session variables to display message
                $_SESSION['add'] = "<div class='error'>Failed To Add Admin.</div>";
                //redirect page
                header("location:".SITEURL.'admin/add-admin.php');
         }
    }

?>