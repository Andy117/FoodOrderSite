<?php include('partials/menu.php');?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1>Cambiar Contraseña</h1>
                <br><br>

                <?php 
                    if(isset($_GET['id']))
                    {
                        $id = $_GET['id'];
                    }
                ?>

                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Contraseña actual:</td>
                            <td>
                                <input type="password" name="current_password" placeholder="Contraseña actual">
                            </td>
                        </tr>
                        <tr>
                            <td>Contraseña nueva:</td>
                            <td>
                                <input type="password" name="new_password" placeholder="Contraseña nueva">
                            </td>
                        </tr>
                        <tr>
                            <td>Confirma la nueva contraseña: </td>
                            <td>
                                <input type="password" name="confirm_password" placeholder="Confirmar nueva contraseña">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <input type="submit" name="submit" value="Cambiar contraseña" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>

    <?php 
        //verificar si el botón está presionado o no
        if(isset($_POST['submit']))
        {
            //está clickeado
            //get data from form
            $id = $_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confim_password = md5($_POST['confirm_password']);

            //check wheter the user with current ID  and current password exist or not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password = '$current_password'";

            //execute the query
            $res = mysqli_query($conn, $sql);

            if($res == TRUE)
            {
                //check wheter data is available or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //user exists
                    if($new_password == $confim_password)
                    {
                        //update password
                        $sql2 = "UPDATE tbl_admin SET
                            password = '$new_password'
                            WHERE id = $id
                        ";

                        //execute query
                        $res2 = mysqli_query($conn, $sql2);

                        //check if excecuted or not
                        if($res2 == true)
                        {
                            $_SESSION['change-pwd'] = "<div class='success'>Cambio de contraseña realizado exitosamente!!!</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }else
                        {
                            $_SESSION['change-pwd-error'] = "<div class='error'>Ocurrió un error en el cambio de contraseña...</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }else
                    {
                        //redirect to namage admin page with error message
                        $_SESSION['pwd-not-match'] = "<div class='error'>Las contraseñas no coinciden...</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }

                }else
                {
                    //user does not exist
                    $_SESSION['user-not-found'] = "<div class='error'>Usuario no encontrado...</div>";
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

            //check wheter the new password and confirm password match or not

            //change password if all above is true
        }
    ?>
<?php include('partials/footer.php');?>