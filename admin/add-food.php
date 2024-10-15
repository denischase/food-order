<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }      
        ?>
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="title of the food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 
                                //displaying categories from database
                                //1.get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                $res = mysqli_query($conn, $sql);

                                //count rows to check categories
                                $count = mysqli_num_rows($res);

                                //if count is greater than 0
                                if($count>0)
                                {
                                    //yes categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //no categories
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                                
                                //2.display on dropdown
                            ?>

                            
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No  
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No  
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php 
            //check submission
            if(isset($_POST['submit']))
            {
                //add food
               // echo 'submit';

               //1.get data
               $title = $_POST['title'];
               $description = $_POST['description'];
               $price = $_POST['price'];
               $category= $_POST['category'];

               //check the radio buttons
               if(isset($_POST['featured']))
               {
                $featured = $_POST['featured'];
               }
               else
               {
                $featured = "No"; //setting the default value
               }

               if(isset($_POST['active']))
               {
                $active = $_POST['active'];
               }
               else
               {
                $active = "No"; //setting default value
               }
               //2.upload image if selected
               //check for selected image
               if(isset($_FILES['image']['name']))
               {
                //get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //check if image is selected or not
                if($image_name!="")
                {
                    //image selected
                    //a.rename image
                    //get the extension of img
                    $ext = end(explode('.', $image_name));

                    //create new img name
                    $image_name = "Food-Name-".rand(0000, 9999).".".$ext; //new img name

                    //b.upload image
                    //get the src path and destination
                    $src = $_FILES['image']['tmp_name'];

                    //destination path
                    $dst = "../images/food/".$image_name;

                    //finally upload image
                    $upload = move_uploaded_file($src, $dst);

                    //check successful
                    if($upload==false)
                    {
                        //failed to upload image
                        //redirect to add food page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //stop the process
                        die();
                    }
                }
               }
               else
               {
                 $image_name = ""; //set default
               }


               //3.insert data database

               //create sql to insert data
               $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
               ";
                //echo $sql2;
               //execute the query
               $res2 = mysqli_query($conn, $sql2);
               //check another data inserted or not
               //4.redirect manage food page
               if($res2 == true)
               {
                //data inserted
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
               }
               else
               {
                //failed to insert
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
               }

               
            }
        ?>

    </div>
</div>
<?php include('partials/footer.php'); ?>