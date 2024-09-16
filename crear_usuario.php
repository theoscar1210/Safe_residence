<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Safe Residence</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
     <!--logo-->
     <header>
        <div class="contenedor_logo_izquierdo">
           <img src="Imagenes/logo.png" alt="logo">
       </div>
           </header>
  <main> 
         <!--formulario  Registro-->
  
     <div class="contenedor_register">
        <form action="crearUsuario.php" class="formulario-register" method="POST">
            <h2>Crear Usuario</h2>
            <input type="text" placeholder="Nombres" required name="nombres">
            <input type="text" placeholder="Apellidos" required name="apellidos">
            <input type="number" placeholder="Cédula" required name="cedula">
            <label class="datos_personales" for="perfil">Perfil:</label>

            <select id="perfil" name="rol" required>
                <?php
                    include("conecta.php");
                    $stmt = $conn ->prepare("select id_rol, rol from roles");
                    $stmt -> execute();
                    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        echo"<option value='".htmlspecialchars( $row["id_rol"] )."'>".htmlspecialchars( $row["rol"] )."</option>";
                    }
                    

                    
                ?>


            </select><br><br>   
            <input type="number" placeholder="Apartamento" name="apartamento">
            <input type="number" placeholder="Telefono" required name="telefono">
            <input type="text" placeholder="Correo electronico" required name="email">
            <input type="text" placeholder="Usuario" required name="usuario">
            <!--Contreseña-->
            <input type="password" placeholder="Contraseña" required minlength="6" maxlength="10" name="password">
            <div>La contraseña debe tener minimo 6 maximo 10 caracteres</div>
            <input type="password" placeholder="Confirmar Contraseña"  required name="c_password">
            <div class="checkbox-container">
                <input type="checkbox" id="checkbox1" name="checkbox1" required>
                <label class="datos_personales" for="checkbox1">Acepto que mis datos personales sean utilizados de acuerdo a la política de privacidad.</label>
            </div>
             
             <!--meu lateral-->
            <div class="contenedor_menu">
                <a href="#">Regresar</a>
                <a href="consulta_ingresos_salidas.html">
                    <i class="fa-regular fa-pen-to-square"></i>
                    <a href="consulta_ingresos_salidas.html">Reportes</a>
                </a>
                <a href="#">
                    <i class="fa-regular fa-file-pdf"></i>
                    <i class="fa-solid fa-print"></i>
                    <a href="#">Imprimir PDF</a>
                </a>
                <a href="#">
                    <i class="fa-regular fa-file-excel"></i>
                    <a href="#">Exportar Xls</a>
                </a>      
                <a href="index.html">
                    <i class="fa-solid fa-house"></i>
                    <a href="index.html">Inicio</a>
                </a>         
            </div>
            <!--boton y crear-->
            <div class="botones">
                <button type="submit" class="boton-pequeño">Crear</button>
                            
            </div>
        </form>
    </div>
    <div class="contenedor_cerrar_sesion_consulta">
        <a href="login.html" class="boton_cerrar_sesion">Cerrar Sesión</a>
    </div>
</main>

</body>
</html>