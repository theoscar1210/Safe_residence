<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Residence</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="icon" href="Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <main>
        <div class="contenedor_logo">
            <header>
                <img src="Imagenes/logo.png" alt="logo">
                <h1>Bienvenido a nuestro sistema de registro</h1>
            </header>
        </div>
        <!--botones de consultar ingresos, usuarios y crear perfil -->
        <div class="contenedor_pantalla_admin">
            <div class="botones_inicio">
                <a href="consulta_ingresos_salidas.html" class="boton_admon">Consulta Ingresos y Salidas del Edificio</a>
                <a href="consulta_usuarios.php" class="boton_admon">Consulta de Usuarios de Safe Residence</a>
            </div>
            <div>
                <a href="crear_usuario.php" class="boton_admon1">Crear Nuevo Perfil de Usuario</a>
            </div>


        </div>
        <!--botones de menu -->
        <div class="contenedor_menu">
            <a href="#">Regresar</a>
            <a href="#">
                <i class="fa-regular fa-pen-to-square"></i>
                <a href="#">Reportes</a>
            </a>
            <a href="#">
                <i class="fa-solid fa-house"></i>
                <a href="#">Inicio</a>
            </a>

        </div>
        <div class="contenedor_cerrar_sesion_consulta">
            <a href="index.php" class="boton_cerrar_sesion">Cerrar Sesión</a>
        </div>
    </main>

</body>

</html>