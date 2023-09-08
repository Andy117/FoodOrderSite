<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Actualizar Categoria</h1>

            <br><br>

            <?php 

                //check whether the id is set or not 
                if(isset($_GET['id']))
                {
                    //get the id and all other details
                    $id = $_GET['id'];
                    //create SQL Query to get all other details
                    $sql = "SELECT * FROM tbl_category WHERE id=$id";

                    //execute the query 
                    $res = mysqli_query($conn, $sql);

                    //count the rows to check whether the id valid or not 
                    $count = mysqli_num_rows($res);

                    if($count==1)
                    {
                        //get all the data
                        $row =mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    }
                    else
                    {
                        //redirect to manage category with session message
                        $_SESSION['No se encontro ninguna categoria '] = "<div class='error'>Categoria No Encontrada</div>";
                        header('location: '.SITEURL.'admin/manage-category.php');
                    }
                }
                else
                {
                    header('location: '.SITEURL.'admin/manage-category.php');
                }
            
            
            ?>

            <form action="" method="POST" enctype="multipart/form-data">

                <table>
                    <tr>
                        <td>Titulo: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Imagen Actual: </td>
                        <td>
                            <?php 
                                if($current_image != "")
                                {
                                    //display the image 
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                    <?php
                                }
                                else 
                                {
                                    //display message 
                                    echo "<div class='error'>Imagen No Agregada. </div>";
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Imagen Nueva: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Presentado: </td>
                        <td>
                            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Si
                            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Activo: </td>
                        <td>
                            <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Si
                            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Actualizar Categoria" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>

            <?php 
                if(isset($_POST['submit']))
                {
                    //1. get all the values from our form 
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    //2. updating new image if seleced
                    //check whether the image is selected or not 
                    if(isset($_FILES['image']['name']))
                    {
                        //get the image details
                        $image_name = $_FILES['image']['name'];

                        //check whether the image is available or not 
                        if($image_name != "")
                        {
                            //image available
                            //A. upload the new image
                            $fileNameParts = explode('.', $image_name);
                            $ext = end($fileNameParts);
    
                            //Rename the image
                            $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. Food_Category_834.jpg
    
                            $source_path = $_FILES['image']['tmp_name'];
    
                            $destination_path = "../images/category/".$image_name;
    
                            //finally Upload the image
                            $upload = move_uploaded_file($source_path, $destination_path);
    
                            //check whether the image is upload or not
                            //and if the image is not uploaded then stop the process and redirect with error mesage
                            if($upload==false)
                            {
                                //set message
                                $_SESSION['$upload'] = "<div class='error'>Error al Subir Imagen. </div>";
                                //redirect to add category page
                                header('location: '.SITEURL.'admin/manage-category.php');
                                //stop the process
                                die();
                            }
                            //B. remove the current image if availabe
                            if($current_image != "")
                            {

                                $remove_path = "../images/category/".$current_image;

                                $remove = unlink($remove_path);

                                //check whether the image is removed or not 
                                //if failed to remove then display message and stop the process 
                                if($remove==false)
                                {
                                    //failed to remove image
                                    $_SESSION['failed remove'] = "<div class='error'>Fallo al remover la imagen actual. </div>";
                                    header('location: '.SITEURL.'admin/manage-category.php');
                                    // stop the process
                                    die();
                                }
                            }
                        }
                        else
                        {
                            $image_name = $current_image;
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }


                    //3. update the database
                    $sql2 = "UPDATE tbl_category SET
                        title = '$title',
                        image_name = '$image_name', 
                        featured = '$featured',
                        active = '$active'
                        WHERE id = $id
                    ";

                    //execute the query 
                    $res2 = mysqli_query($conn, $sql2);

                    //4. redirect to manage category with message
                    //check whether executed or not 
                    if($res2==true)
                    {
                        //category updated
                        $_SESSION['update'] = "<div class='success'>Categoria Actualizada Correctamente</div>";
                        header('location: '.SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        //failed to update category
                        $_SESSION['update'] = "<div class='error'>Fallo al Actualizar la Categoria</div>";
                        header('location: '.SITEURL.'admin/manage-category.php');
                    }
                }
            
            ?>


        </div>
    </div>




<?php include('partials/footer.php'); ?>