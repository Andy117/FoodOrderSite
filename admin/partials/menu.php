<?php 
    include('../config/constants.php');
    include('login-check.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Ordena tu Comida Favorita - Inicio</title>
</head>
<body>
    <header>
        <div class="menu text-center">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="manage-admin.php">Administrar</a></li>
                    <li><a href="manage-category.php">Categorias</a></li>
                    <li><a href="manage-food.php">Comida</a></li>
                    <li><a href="manage-order.php">Ordenar</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </header>