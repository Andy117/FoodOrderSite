<?php include('partials/menu.php');?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1><strong>Manejo de Administración</strong></h1>
                <br><br>

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //displaying session message
                        unset($_SESSION['add']); //removing session message
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete']; //displaying session message
                        unset($_SESSION['delete']); //removing session message
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update']; //displaying session message
                        unset($_SESSION['update']); //removing session message
                    }

                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found']; //displaying session message
                        unset($_SESSION['user-not-found']); //removing session message
                    }

                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match']; //displaying session message
                        unset($_SESSION['pwd-not-match']); //removing session message
                    }

                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd']; //displaying session message
                        unset($_SESSION['change-pwd']); //removing session message
                    }

                    if(isset($_SESSION['change-pwd-error']))
                    {
                        echo $_SESSION['change-pwd-error']; //displaying session message
                        unset($_SESSION['change-pwd-error']); //removing session message
                    }
                ?> <br><br><br>

                <!-- Button to add an admin-->
                <a href="add-admin.php" class="btn-primary">Agregar Administrador</a>
                <br><br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Nombre Completo</th>
                        <th>Nombre de Usuario</th>
                        <th>Acciones</th>
                    </tr>

                    <?php
                        //Query to get all Admins
                        $sql = "SELECT * FROM  tbl_admin";
                        
                        //execute the query
                        $res = mysqli_query($conn, $sql);

                        //check wheteher the query is executed or not

                        if($res == TRUE)
                        {
                            //count rows to check wheter we have data in database or not
                            $count = mysqli_num_rows($res); //function to get all the rows in database
                            $sn = 1;
                            //check the num of rows

                            if($count>0)
                            {
                                //we have date in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //using while loop to get all the data from database
                                    //and hwile loop whill run as long as we have data in database

                                    $id = $rows['id'];
                                    $full_name = $rows['full_name'];
                                    $username = $rows['username'];

                                    //display the values in our table
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++?></td>
                                        <td><?php echo $full_name?></td>
                                        <td><?php echo $username?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Cambiar Contraseña</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Actualizar Administrador</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Borrar Administrador</a>
                                        </td>
                                    </tr>
                                    <?php 
                                    
                                }
                            }else
                            {
                                //we do not have data in database
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
<?php include('partials/footer.php');?>