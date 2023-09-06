<?php 
    //include constants
    include('../config/constants.php');
    //destroy the session
    session_destroy();
    //redirect to login
    header('location:'.SITEURL.'admin/login.php');
?>