<?php 
    //check wheter the user is logged in or not
    if(!isset($_SESSION['user']))
    {
        //user not loged in
        //redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Por favor inicia sesión para acceder al Panel de Control</div>";
        //redirect to login page
        header('location:'.SITEURL.'admin/login.php');
    }
?>