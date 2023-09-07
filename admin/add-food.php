<?php include('partials/menu.php'); ?>

<main>
    <div class="main-content">
        <div class="wrapper">
            <h1>Agregar Platillo</h1> <br><br>
            <?php 
                if(isset($_POST['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Nombre: </td>
                        <td>
                            <input type="text" name="title" placeholder="Nombre del platillo">
                        </td>
                    </tr>
                    <tr>
                        <td>Descripción: </td>
                        <td>
                            <textarea name="description" id="" cols="30" rows="5" placeholder="Descripción del platillo"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Precio: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>
                    <tr>
                        <td>Seleccionar imagen: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Categoria: </td>
                        <td>
                            <select name="category">
                                <?php 
                                    //get all the active categories from the database
                                    $sql = "SELECT * FROM  tbl_category WHERE active = 'Yes'";
                                    //executing query
                                    $res = mysqli_query($conn, $sql);
                                    //count rows to check whether we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //if count is > 0, we have categories
                                    if($count > 0)
                                    {
                                        //we have categories
                                        while($row = mysqli_fetch_assoc($res))
                                        {
                                            //get details of categories
                                            $id = $row['id'];
                                            $title = $row['title'];

                                            ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            <?php
                                        }
                                    }else
                                    {
                                        //no categories found
                                        ?>
                                            <option value="0">Sin Categorias</option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Destacado: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td>Activo: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Agregar Platillo" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    //add foot in the database

                    //get the data from form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    
                    //check the radio button for featured and active are checked or not

                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }else
                    {
                        $featured = "No";
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }else
                    {
                        $active = "No";
                    }

                    //uploade the image if selected
                    //check if there's an img selected
                    if(isset($_FILES['image']['name']))
                    {
                        //get the details of the img
                        $image_name = $_FILES['image']['name'];

                        //check whether the img is selected or not
                        if($image_name != "")
                        {
                            //get the extension o f the img
                            $ext = end(explode('.', $image_name));
                            //create new name for image

                            $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                            //source path
                            $src = $_FILES['image']['tmp_name'];

                            //destionation path
                            $dst = "../images/food/".$image_name;

                            $upload = move_uploaded_file($src, $dst);

                            //check if uploaded
                            if($upload==false)
                            {
                                $_SESSION['upload'] = "<div class='error'>Fallo al guardar imagen...</div>";
                                header('location:'.SITEURL.'admin/add-food.php');
                                die();
                            }
                        }
                    }else
                    {
                        $image_name =""; //default value of the img
                    }

                    //insert into database
                    //create a sql query to save or add food
                    //for numerical values we dont need ' '
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check if data was inserted
                    if($res2 == true)
                    {
                        $_SESSION['add'] = "<div class='success'>Se agregó la comida exitosamente!</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }else
                    {
                        $_SESSION['add'] = "<div class='error'>Error al agregar comida...</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }

                    //redirect with message to manage food page
                }
            ?>
        </div>
    </div>
</main>

<?php include('partials/footer.php'); ?>