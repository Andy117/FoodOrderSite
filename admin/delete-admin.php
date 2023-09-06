<?php 
    //include constants.php file here
    include('../config/constants.php');
    //get the id of admin to be deleted
    $id = $_GET['id'];

    //create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check wheter the query is executed or not
    if($res == true)
    {
        //query executed successfully and admin deleted
        //create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Administrador eliminado exitosamente!!</div>";
        //redirect to manage Admin Page
        header("location:".SITEURL.'admin/manage-admin.php');
    }else
    {
        //failed to delete admin
        $_SESSION['delete'] = "<div class='error'>'Fallo al eliminar Administrador'</div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }
?>