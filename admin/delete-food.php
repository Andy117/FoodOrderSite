<?php 
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != "")
        {
            $path = "../images/food/".$image_name;
            $remove = unlink($path);
            if($remove == false)
            {
                $_SESSION['upload'] = "<div class='error'>Error al intentar eliminar imagen</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }

        $sql = "DELETE FROM tbl_food WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res == true)
        {
           $_SESSION['delete'] = "<div class='success'>Platillo eliminado con éxito!</div>";
           header('location:'.SITEURL.'admin/manage-food.php'); 
        }else
        {
            $_SESSION['delete'] = "<div class='error'>Fallo al eliminar comida...</div>";
           header('location:'.SITEURL.'admin/manage-food.php');
        }
    }else
    {
        $_SESSION['delete'] = "<div class='error'>Acceso no autorizado</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>