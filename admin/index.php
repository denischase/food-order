
<?php include('partials/menu.php');  ?>

        <!--Main content section start-->
        <div class="main-content">
            <div class="wrapper">
                <h1 class="">Dashboard</h1>
                <br/>       

                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>

                <div class="col-4 text-center">
                    <?php 
                      // query
                      $sql =  "SELECT * FROM tbl_category";
                      //execute query
                      $res = mysqli_query($conn, $sql);
                      //count rows
                      $count = mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1>
                    <br />
                    Categories
                </div>

                <div class="col-4 text-center">
                <?php 
                      // query
                      $sql2 =  "SELECT * FROM tbl_food";
                      //execute query
                      $res2 = mysqli_query($conn, $sql2);
                      //count rows
                      $count2 = mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>
                    <br />
                    Foods
                </div>

                <div class="col-4 text-center">
                <?php 
                      // query
                      $sql3 =  "SELECT * FROM tbl_order";
                      //execute query
                      $res3 = mysqli_query($conn, $sql3);
                      //count rows
                      $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1>
                    <br />
                    Total Orders
                </div>

                <div class="col-4 text-center">
                    <?php 
                        //queryto get total revenue generated
                        //aggregate function in sql
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                        //Execute
                        $res4 = mysqli_query($conn, $sql4);
                        
                        //get value
                        $row4 = mysqli_fetch_assoc($res4);

                        //get total revenue
                        $total_revenue = $row4['Total'];
                    ?>
                    <h1>$<?php echo $total_revenue; ?></h1>
                    <br />
                    Revenue Generated
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!--Main content section ends-->

<?php include('partials/footer.php'); ?>       