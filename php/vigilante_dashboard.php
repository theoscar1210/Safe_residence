<?php
session_start();
// Verificar si el usuario está autenticado y tiene el rol adecuado
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 6) { // 6 es el id_rol para Vigilante
    header("Location: login.php?error=Acceso no autorizado");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio-Porteria-Safe-Residence</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!--logo-->
    <header>
        <div class="contenedor_logo_izquierdo">
            <img src="../imagenes/logo.png" alt="logo">
        </div>
        <main>
            <div class="contenedor_Porteria">
                <h1>¡Bienvenido!, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?><br> Medio de Ingreso</h1>
                <!--botones de Ingreso peatonal y vehicular-->
                <div class="contenedor_botones_ingresos">
                    <a href="monitor_ingresos.php" class="boton_peatonal">
                        <i class="fa-solid fa-person-walking"></i>Monitor de Ingresos
                    </a>

                    <a href="registro_ingreso.php" class="boton_vehicular">
                        <i class="fa-solid fa-car-side"></i>Autos
                    </a>


                </div>
            </div>

            <div class="contenedor_cerrar_sesion_vigilante">
                <a href="cerrar_session.php" class="boton_cerrar_sesion_vigilante">Cerrar Sesión</a>
            </div>

        </main>

</body>

</html>