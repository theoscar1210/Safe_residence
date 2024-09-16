<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <header>
        <h1>
            Safe Residence
        </h1>
    </header>

    <img src="" alt="">

    <div>

        <?php

        include("crearUsuario.php");

        if($d_insertados ==1){
            echo '<img src="imagenes/marca-de-verificacion.png">';
            echo'Usuario Creado ¡Exitosamente!';
        }else if($u_existente == 1){
            echo '<h1>Usuario existente</h1>';
        }else if($password_diferente == 1){
            echo '<h2>Las contraseñas no coinciden</h2>';
        }
        ?>
    </div>
    
</body>
</html>