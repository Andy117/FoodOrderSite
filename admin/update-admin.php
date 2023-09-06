<?php include('partials/menu.php');?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1>Actualizar Información de Administrador</h1>
                <br><br>

                <?php 
                    //get the ID  of selected Admin
                    $id = $_GET['id'];
                    //Create SQL query to get the details
                    $sql = "SELECT * FROM tbl_admin WHERE id= $id";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    //chedk wheter the query is executed or not
                    if($res == true)
                    {
                        //check wheter the data is available or not
                        $count = mysqli_num_rows($res);
                        //check wheter we have admin data or not
                        if($count==1)
                        {
                            //get the data
                            $row = mysqli_fetch_assoc($res);

                            $full_name = $row['full_name'];
                            $username = $row['username'];
                        }else
                        {
                            //redirect to manage admin page
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                ?>

                <form action="" method="POST">
                    <table class="tbl-30">
                        <tr>
                            <td>Nombre Completo:</td>
                            <td>
                                <input type="text" name="full_name" value="<?php echo $full_name;?>">
                            </td>
                        </tr>
                        <tr>
                            <td>Nombre de Usuario</td>
                            <td>
                                <input type="text" name="username" value="<?php echo $username;?>">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </main>

    <?php 
        //check wheter the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //button clicked
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];

            //create the sql query
            $sql = "UPDATE tbl_admin SET
                full_name = '$full_name',
                username = '$username'
                WHERE id = '$id'
            ";

            //execute the query
            $res = mysqli_query($conn,$sql);

            if($res ==true)
            {
                //admin updated successfully
                $_SESSION['update'] = "<div class='success'>Datos actualizados exitosamente!!</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }else
            {
                $_SESSION['update'] = "<div class='error'>Fallo al actualizar datos...</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
    ?>
<?php include('partials/footer.php');?>