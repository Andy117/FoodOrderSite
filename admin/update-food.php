<?php ob_start();  include('partials/menu.php'); ?>

<?php 

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        $res2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($res2);

        //get individual values
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }else
    {
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1>Actualizar Platillo</h1><br><br>
                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td>Nombre actual: </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $title;?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Descripción: </td>
                            <td>
                                <textarea name="description" id="" cols="30" rows="5"><?php echo $description; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Precio:</td>
                            <td>
                                <input type="number" name="price" value="<?php echo $price; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Imagen actual: </td>
                            <td>
                                <?php 
                                    if($current_image == "")
                                    {
                                        //img not available
                                        echo "<div class='error'>Imagen no disponible...</div>";
                                    }else
                                    {
                                        //img available
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="this is a food picture" width="100px">
                                        <?php
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Seleccionar nueva imagen: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>
                        <tr>
                            <td>Categoria: </td>
                            <td>
                                <select name="category" id="">
                                    
                                    <?php 
                                        //query to get active categories
                                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                        $res = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($res);

                                        if($count >0)
                                        {
                                            while($row=mysqli_fetch_assoc($res))
                                            {
                                                $category_title = $row['title'];
                                                $category_id = $row['id'];

                                                //echo"<option value='$category_id'>$category_title</option>";
                                                ?>
                                                    <option <?php if($current_category==$category_id){echo "Selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                                <?php
                                            }
                                        }else
                                        {
                                            echo "<option value='0'>Categoria no disponible.</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Destacado: </td>
                            <td>
                                <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes"> Si
                                <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No"> No
                            </td>
                        </tr>
                        <tr>
                            <td>Activo: </td>
                            <td>
                                <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes"> Si
                                <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No"> No
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                                <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>

                <?php 
                    if(isset($_POST['submit']))
                    {
                        //button clicked
                        $id = $_POST['id'];
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $price = $_POST['price'];
                        $current_image = $_POST['current_image'];
                        $category = $_POST['category'];

                        $featured = $_POST['featured'];
                        $active = $_POST['active'];

                        //upload img if selected
                        if(isset($_FILES['image']['name']))
                        {
                            $image_name = $_FILES['image']['name'];
                            if($image_name!="")
                            {
                                //image is available
                                $ext = end(explode('.', $image_name));
                                $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;

                                $src_path = $_FILES['image']['tmp_name'];
                                $dest_path = "../images/food/".$image_name;

                                $upload = move_uploaded_file($src_path, $dest_path);

                                if($upload ==false)
                                {
                                    $_SESSION['upload'] = "<div class='error'>Fallo al cargar la nueva imagen..</div>";
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    //stop process
                                    die();
                                }
                                //remove current image if available
                                if($current_image !="")
                                {
                                    $remove_path = "../images/food/".$current_image;
                                    $remove = unlink($remove_path);

                                    if($remove==false)
                                    {
                                        //failed to remove
                                        $_SESSION['remove-failed'] = "<div class='error'>Fallo al eliminar la imagen actual</div>";
                                        header('location:'.SITEURL.'admin/manage-food.php');
                                        die();
                                    }
                                }
                            }
                        }else
                        {
                            $image_name = $current_image;
                        }

                        $sql3 = "UPDATE tbl_food SET
                            title = '$title',
                            description = '$description',
                            price = $price,
                            image_name = '$image_name',
                            category_id = '$category',
                            featured = '$featured',
                            active = '$active'
                            WHERE id = $id
                        ";

                        //execute the sql

                        $res3 = mysqli_query($conn, $sql3);

                        //check whether the query is executed or not

                        if($res3 == true)
                        {
                            $_SESSION['update'] = "<div class='success'>Platillo actualizado con éxito!</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }else
                        {
                            $_SESSION['update'] = "<div class='error'>Error al actualizar platillo</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }
                    }
                ?>
            </div>
        </div>
    </main>
<?php include('partials/footer.php'); ob_end_flush();?>