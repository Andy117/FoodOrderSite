<?php include('partials/menu.php');?>
<main>
    <div class="main-content">
        <div class="wrapper">
            <h1>Agregar Categoria</h1> <br><br>

            <?php 
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>

            <br><br>

            <!--Inicio de formulario-->
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Nombre de Categoria: </td>
                        <td>
                            <input type="text" name="title" placeholder="Ingrese nombre de Categoria">
                        </td>
                    </tr>
                    <tr>
                        <td>Seleccionar Imagen: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Destacado: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Si
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td>Activo: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Si
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Agregar Categoria" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <!--Fin de formulario-->

            <?php 
                //check if the button is clicked
                if(isset($_POST['submit']))
                {
                    //get value from category form
                    $title = $_POST['title'];

                    //for radio input, we need to check the status
                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        //set default value
                        $featured = "No";
                    }

                    //same for active statues
                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }else
                    {
                        $active = "No";
                    }

                    if(isset($_FILES['image']['name']))
                    {
                        //upload the img
                        //we need the name, source path and destination
                        $image_name = $_FILES['image']['name'];
                        
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
                        }
                    }else
                    {
                        $image_name="";
                    }

                    //now we create the quer for insert into the database
                    $sql = "INSERT INTO tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                    ";

                    //we execute the query and save in database
                    $res = mysqli_query($conn, $sql);

                    //check whether the query was executed or not
                    if($res == TRUE)
                    {
                        $_SESSION['add'] = "<div class='success'>Categoria agregada exitosamente!</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }else
                    {
                        $_SESSION['add'] = "<div class='error'>No se pudo agregar la categoria...</div>";
                        header('location:'.SITEURL.'admin/add-category.php');
                    }
                }
            ?>
        </div>
    </div>
</main>
<?php include('partials/footer.php');?>