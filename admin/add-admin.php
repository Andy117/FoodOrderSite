<?php include('partials/menu.php');?>


    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1>Agregar Administrador</h1><br><br>

                <?php
                    if(isset($_SESSION['add'])) //checking wheter the session is set of  not
                    {
                        echo $_SESSION['add']; //displaying addmessage
                        unset($_SESSION['add']); //removing add message
                    }
                ?>

                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Nombre Completo: </td>
                            <td>
                                <input type="text" name="full_name" placeholder="Ingrese Nombre Completo" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Nombre de Usuario: </td>
                            <td>
                                <input type="text" name="username" placeholder="Ingrese Nombre de Usuario" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Contraseña: </td>
                            <td>
                                <input type="password" name="password" placeholder="Ingrese Contraseña" required>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Agregar Administrador" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>

<?php include('partials/footer.php');?>

<?php 
    //Procesar el valor del formulario y guardarlo en la base de datos
    //verificar si el botón de Submit es presionado o no

    if(isset($_POST['submit']))
    {
        //button clicked
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //SQL query to save the data into the database
        $sql = "INSERT INTO tbl_admin set
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        //Executing the QUERY and saving the data into database
        $res = mysqli_query($conn,$sql) or die('Problemas al ejecutar la consulta...'.mysqli_error($conn));

        //Check whether the Query is executed or not
        if($res == TRUE)
        {
            //echo "Datos Insertados con éxito!!!";
            //Create a Session variable to display Message
            $_SESSION['add'] = "Administrador agregado exitosamente!!";
            //redirect page to MAIN
            header("location:".SITEURL.'admin/manage-admin.php');
        }else
        {
            //echo "Fallo al insertar los datos";
            //Create a Session variable to display Message
            $_SESSION['add'] = "Error al agregar administrador...";
            //redirect page to MAIN
            header("location:".SITEURL.'admin/manage-admin.php');
        }

    }
?>