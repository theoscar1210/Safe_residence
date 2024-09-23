<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión Safe Residence</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="Imagenes/logo.ico">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--Libreria javaScript para crear alertar-->
</head>
<body>

<?php
session_start();

//verificamos si la contraseña es incorrecta y mandamos alerta al usuario del error

if (isset($_SESSION["password_error"]) && $_SESSION["password_error"] ==1){
    echo"<script>
    swal('Ops!', '¡Contraseña incorrecta!', 'error');
    </script>";

    unset($_SESSION["password_error"]);//limpiamos la variable
}

//verificamos si el usuario es incorrecto y mandamos alerta al usuario del error

if (isset($_SESSION["user_error"]) && $_SESSION["user_error"] ==1){
    echo"<script>
    swal('Ops!', '¡Usuario Incorrecto!', 'error');
    </script>";

    unset($_SESSION["user_error"]);//limpiamos la variable
}
?>

 <main>
    <header>
        <div class="contenedor_logo_">       
           <img src="Imagenes/logo.png" alt="logo">
           <h1>Bienvenido a nuestro sistema de registro</h1>
        </div>
    </header>
    
        <div class="contenedor_login">
        <!--login-->     
        <form action="procesar_login.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" requerid>
            <input type="password" name="password" placeholder="Contraseña" requerid>
            <button type="submit" >Iniciar sesión</button>
        </form>
               
           
        </div>
   
</main>
</body>
</html>