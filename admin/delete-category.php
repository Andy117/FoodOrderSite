<?php 
    //Include constants file
    include('../config/constants.php');
    //echo "Delete Page";
    //check whether id and image name value is set or not 
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete 
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image file is available
        if($image_name != "")
        {
            //image is avialabe, so remove it 
            $path = "../images/category/".$image_name;
            //remove the image
            $remove = unlink($path);

            //if faied to remove image then add an error message and stop the process 
            if($remove==false)
            {
                //set the session message 
                $_SESSION['remove'] = "<div class='error'>Error al Eliminar la Imagen de la Categoria.</div>";
                //redirect to manage category page 
                header('location: '.SITEURL.'admin/manage-category.php');
                //stop th process 
                die();
            }
        }

        //delete data from database 
        //SQL Query to delete data from Database 
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //check wheteher the data is delete drom database or not 
        if($res==true)
        {
            //set success message and redirect 
            $_SESSION['delete'] = "<div class='success'>Categoria Eliminada Correctamente. </div>";
            //redirect to manage category
            header('location: '.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //set fail message and redirect 
            $_SESSION['delete'] = "<div class='error'>Error al Eliminar la Categoria. </div>";
            //redirect to manage category
            header('location: '.SITEURL.'admin/manage-category.php');

        }
    }
    else
    {
        //redirect to manage category page 
        header('location: '.SITEURL.'admin/manage-category.php');
    }

?>
