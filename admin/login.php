<?php include('../config/constants.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Login - Ordena tu Comida favorita</title>
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1><br>
        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['login-error']))
            {
                echo $_SESSION['login-error'];
                unset($_SESSION['login-error']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br><br>
            <!--Login starts here-->
            <form action="" method="POST" class="text-center">
                <label for="username">Nombre de Usuario:</label><br>
                <input type="text" name="username" placeholder="Ingrese su nombre de usuario registrado" id="username"><br><br>

                <label for="password">Contraseña:</label><br>
                <input type="password" name="password" placeholder="Ingrese su Contraseña" id="password" required><br><br>

                <input type="submit" name="submit" value="Ingresar" class="btn-primary"><br><br>
            </form>
            <!--Login ends here-->
        <p class="text-center">Creado por - <a href="#">Grupo 2</a></p>
    </div>
    
</body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        //button clicked
        //get the data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //sql to check whether the user with password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

        //execute query
        $res = mysqli_query($conn,$sql);

        //count rows to check wheter the user exists or not

        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //user available and login success
            $_SESSION['login'] = "<div class='success'>Inicio de sesión exitoso!</div>";
            $_SESSION['user'] = $username;

            //redirect to homepage
            header('location:'.SITEURL.'admin/');
        }else
        {
             //user is not available and login failed
             $_SESSION['login-error'] = "<div class='error text-center'>Inicio de sesión fallido... nombre de usuario o contraseña invalidos...</div>";
             //redirect to homepage
             header('location:'.SITEURL.'admin/login.php');
        }
    }
?>