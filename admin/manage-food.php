<?php include('partials/menu.php');?>
    <main>
        <div class="main-content">
            <div class="wrapper">
                <h1><strong>Manejo de Comida</strong></h1>
                <br><br>

                

                <!-- Button to add an admin-->
                <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Agregar Platillo</a>
                <br><br><br>
                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Nombre del Platillo</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Destacado</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>

                    <?php 
                        $sql = "SELECT * FROM tbl_food";
                        $res = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($res);

                        //serial number variable
                        $sn = 1;

                        if($count > 0)
                        {
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo "$".$price; ?></td>
                                    <td>
                                        <?php
                                            if($image_name =="")
                                            {
                                                echo "<div class='error'>Imagen no agregada</div>";
                                            }else
                                            {
                                                //retrieve the img
                                                ?>
                                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="This is a food picture" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Actualizar Platillo</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Borrar Platillo</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }else
                        {
                            echo "<tr><td colspan='7' class='error'>Aún no hay comida agregada</td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </main>
<?php include('partials/footer.php');?>