<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Agregar Categoria</h1>

        <br><br>

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

        <!--- Add Category Form Starts--->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Titulo: </td>
                    <td>
                        <input type="text" name="title" placeholder="Titulo de Categoria">
                    </td>
                </tr>

                <tr>
                    <td>Seleccionar Imagen: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Presentado: </td>
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
        <!--- Add Category Form Ends---> 
        <?php
            //Check whether the Submit Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1. Get the Value from Category Form
                $title = $_POST['title'];

                //For Radio input, we need to check the button is selected or not 
                if(isset($_POST['featured']))
                {
                    //Get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set the default Value
                    $featured = 'No';
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = 'No';
                }

                //ckeck whether the image is selected or not and set the value ofr image  name accoridingly
                //print_r($_FILES['image']):

                //die();//Break the code Here

                if(isset($_FILES['image']['name']))
                {
                    //Upload the image
                    //To upload image we need image_name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //upload the image only if image es selected
                    if($image_name != "")
                    {

                        //Auto rename our iamge
                        //get the extension of our iamge (jpg, png, gif, etc) e.g. "special.food1.png"
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
                            header('location: '.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                    }

                }
                else
                {
                    //Don't Upload Image and set the image_name value as blank
                    $image_name="";
                }

                //2. Create SQL Query Insert Category into Database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //3. Execute the Query and Save in Database
                $res = mysqli_query($conn, $sql);

                //4. Check whether the query executed or not and data added or not 
                if($res==true)
                {
                    //Query Executed and Category Added
                    $_SESSION['add'] = "<div class='success'>Categoria Agregada Correctamente.</div>";
                    //Redirect to Manage-Category.php
                    header('location: '.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to Add Category 
                    $_SESSION['add'] = "<div class='error'>Error al Agregar Categoria.</div>";
                    //Redirect to Add-Category.php
                    header('location: '.SITEURL.'admin/add-category.php');
                }
            }
        
        ?>
    </div>
</div>

<?php include('partials/footer.php') ?>