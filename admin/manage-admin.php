<?php include('partials/menu.php'); ?>

        <!--Main content section start-->
        <div class="main-content">
            <div class="wrapper">
                <h1 class="">Manage admin</h1>
                <br />

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];  // displaying session msg
                        unset($_SESSION['add']); // removing session msg
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    if(isset($_SESSION['password-not-match']))
                    {
                        echo $_SESSION['password-not-match'];
                        unset($_SESSION['password-not-match']);
                    }

                    if(isset($_SESSION['change-password']))
                    {
                        echo $_SESSION['change-password'];
                        unset($_SESSION['change-password']);
                    }
                ?>
                 <br /><br /> <br />

                <!--Button to add admin-->
                <a href="add-admin.php" class="btn-primary btn-width">Add Admin</a>

                <br /><br />

            
                 
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //get all admin
                            $sql = "SELECT * FROM tbl_admin";
                        // execute the query
                        $res = mysqli_query($conn, $sql);
                        
                        // check whether query is executed
                        if($res == TRUE)
                        {
                            //count rows to check wheter there is data
                            $count = mysqli_num_rows($res); //function to get all rows

                            $sn = 1; // create a variable and assign the value

                            //check num of rows
                            if($count > 0)
                            {
                                //yes data in base
                                while($rows = mysqli_fetch_assoc($res))
                                {
                                    // get all data 
                                    // will run as long as data is in database

                                    //get individual data
                                    $id = $rows['id'];
                                    $full_name = $rows['full_name'];
                                    $username = $rows['username'];

                                    //display value in tables
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++; ?>.</td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            else
                            {
                                // no data in base
                            }

                        }
                    ?>

                   

                </table>
                
            </div>
        </div>
        <!--Main content section ends-->

 <?php include('partials/footer.php'); ?>