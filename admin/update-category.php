<?php include('partials/menu.php');?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1>Actualizar Categoria</h1> <br><br>

                <?php 
                    //check whether the id is set or not
                    if(isset($_GET['id']))
                    {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM tbl_category WHERE id=$id";

                        $res = mysqli_query($conn, $sql);

                        $count = mysqli_num_rows($res);

                        if($count == 1)
                        {
                            $row = mysqli_fetch_assoc($res);
                            $title = $row['title'];
                            $current_image = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                        }else
                        {
                            $_SESSION['no-category-found'] = "<div class='error'>Categoria no encontrada..</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }
                    }else
                    {
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <table class="tbl-30">
                        <tr>
                            <td>Nombre de categoria actual: </td>
                            <td>
                                <input type="text" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Imagen actual: </td>
                            <td>
                                <?php
                                    if($current_image != "")
                                    {
                                        ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="This is the current category image" width="150px">
                                        <?php
                                    }else
                                    {
                                        echo "<div class='error'>Imagen no agregada.</div>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nueva Imagen: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>
                        <tr>
                            <td>Destacado: </td>
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
                        //get all the data from our form
                        $id = $_POST['id'];
                        $title = $_POST['title'];
                        $current_image = $_POST['current_image'];
                        $featured = $_POST['featured'];
                        $active = $_POST['active'];

                        //update image
                        if(isset($_FILES['image']['name']))
                        {
                            $image_name = $_FILES['image']['name'];
                            //check if the img is available
                            if($image_name != "")
                            {
                                //autorename our img  with a random naeme
                            $ext = end(explode('.', $image_name));

                            $image_name = "Food_Category_".rand(000,999).'.'.$ext;

                            $source_path = $_FILES['image']['tmp_name'];

                            $destination_path = "../images/category/".$image_name;

                            //finally we upload the img
                            $upload = move_uploaded_file($source_path,$destination_path);

                            //check whether the img is uploaded or not
                            if($upload == false)
                            {
                                $_SESSION['upload'] = "<div class='error'>Fallo al subir imagen, intente de nuevo...</div>";
                                header('location:'.SITEURL.'admin/add-category.php');
                                die();
                            }

                            if($current_image != "")
                            {
                                $remove_path = "../images/category/".$current_image;
                                $remove = unlink($remove_path);

                                //check if the img was removed
                                if($remove == false)
                                {
                                    //failed to remove the img
                                    $_SESSION['failed-remove'] = "<div class='error'>Error al eliminar la imagen actual..</div>";
                                    header('location:'.SITEURL.'admin/manage-category.php');
                                    die();
                                }
                            }

                            }else
                            {
                                $image_name = $current_image;
                            }
                        }else
                        {
                            $image_name = $current_image;
                        }

                        $sql2 = "UPDATE tbl_category SET
                            title = '$title',
                            image_name = '$image_name',
                            featured = '$featured',
                            active = '$active'
                            WHERE id=$id
                        ";

                        $res2 = mysqli_query($conn, $sql2);

                        if($res2 == true)
                        {
                            $_SESSION['update'] = "<div class='success'>Categoria actualizada con éxito!</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }else
                        {
                            $_SESSION['update'] = "<div class='error'>No se pudo actualizar la categoria</div>";
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }
                    }
                ?>
            </div>
        </div>
    </main>
<?php include('partials/footer.php');?>