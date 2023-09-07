<?php 
    include('../config/constants.php');

    //check the id and also the img value set
    if(isset($_GET['id']) and isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical img if available
        if($image_name != "")
        {
            //image is ok
            $path = "../images/category/".$image_name;
            //remove the img
            $remove = unlink($path);

            //if failed to remove, add and error and stop the process
            if($remove == false)
            {
                $_SESSION['remove'] = "<div class='error'>Fallo al remover la imagen de la categoria...</div>";
                header('location:'.SITEURL.'admin/manage-category.php');

                die();
            }
        }

        //delete from database

        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the data is delete from database or not
        if($res == true)
        {
            $_SESSION['delete'] = "<div class='success'>Categoria borrada con éxito!</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }else
        {
            $_SESSION['delete'] = "<div class='error'>No se pudo eliminar la categoria :/</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }else
    {
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>