<?php
    //Start session
    session_start();

    //Create constants to store non repeating values
    define('SITEURL', 'http://localhost/FoodOrderSite/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die('Error: No se puede conectar...'.mysqli_connect_error()); //Database connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die('Error: Base de Datos no encontrada...'.mysqli_connect_error()); //selection database
?>