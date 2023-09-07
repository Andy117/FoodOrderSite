<?php include('partials/menu.php');?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1><strong>Manejo de Categorias</strong></h1>
                <br><br>

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['remove']))
                    {
                        echo $_SESSION['remove'];
                        unset($_SESSION['remove']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['no-category-found']))
                    {
                        echo $_SESSION['no-category-found'];
                        unset($_SESSION['no-category-found']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['failed-remove']))
                    {
                        echo $_SESSION['failed-remove'];
                        unset($_SESSION['failed-remove']);
                    }
                ?>

                <br><br>

                <!-- Button to add an admin-->
                <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Agregar Categoria</a>
                <br><br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Nombre de Categoria</th>
                        <th>Imagen</th>
                        <th>Destacado</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>

                    <?php 
                        $sql = "SELECT * FROM tbl_category";    
                        $sn = 1;
                        //execute the query 

                        $res = mysqli_query($conn, $sql);

                        //count rows
                        $count = mysqli_num_rows($res);

                        if($count > 0)
                        {
                            while($row = mysqli_fetch_assoc($res))
                            {
                                
                                $id = $row['id'];
                                $title = $row['title'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];

                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td>
                                        <?php
                                            if($image_name!="")
                                            {
                                                //display img
                                                ?>

                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" alt="This is a food category image_name" width="90px">

                                                <?php
                                            }else
                                            {
                                                //display the mssg
                                                echo "<div class='error'>No hay imagen disponible</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Actualizar Categoria</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Borrar Categoria</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }else
                        {
                            //there's no data
                            //displaying an error message inside the table
                            ?>
                            <tr>
                                <td colspan="6"><div class="error">Categoria no agregada</div></td>
                            </tr>
                            <?php
                        }
                    ?>

                    
                </table>
            </div>
        </div>
    </main>
<?php include('partials/footer.php');?>