<?php
session_start();
// Verificar si el usuario está autenticado y tiene el rol adecuado
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 6) { // 6 es el id_rol para vigilante
    header("Location: login.php?error=Acceso no autorizado");
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso Vehicular-Safe Residence</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!--logo-->
    <header>
        <div class="contenedor_logo_izquierdo">
            <img src="../Imagenes/logo.png" alt="logo">
        </div>
    </header>

    <main>
        <!-- SweetAlert2 scripts -->
        <?php
        // Mostrar mensaje de éxito
        if (isset($_SESSION['success'])) {
            echo " <script>
            Swal.fire({
                icon: 'success',
                title: 'Registro Exitoso',
                text: '{$_SESSION['success']}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>";
            unset($_SESSION['success']); // Limpiar el mensaje después de mostrarlo
        }
        // Mostrar mensaje de error
        if (isset($_SESSION['error'])) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{$_SESSION['error']}'
            });
        </script>";
            unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo
        }
        ?>

        <!--formulario de Ingreso con vehiculos llenado por el vigilante-->
        <div class="contenedor_ingreso_vehicular">

            <form action="process_ingreso.php" class="formulario-ingreso_vehiculos" method="POST">

                <h2>Registro Ingreso Vehicular</h2>
                <input type="text" name="nombres" placeholder="Nombres" required>
                <input type="text" name="apellidos" placeholder="Apellidos" required>
                <input type="number" name="cedula" placeholder="*Cédula" required>
                <input type="text" name="apartamento" placeholder="Apartamento" required>
                <label for="perfil">Tipo de Ingreso:</label>
                <select id="perfil" name="rol" required>
                    <option value="propietario">Propietario</option>
                    <option value="Autorizado">Autorizado</option>
                    <option value="visitante ">Visitante</option>
                </select><br><br>
                <label for="tipo vehiculo">Tipo de Vehiculo</label>
                <select name="vehiculo" id="vehiculo" required>
                    <option value="automovil">Automovil</option>
                    <option value="bicicleta">Bicicleta</option>
                    <option value="camioneta">Camioneta</option>
                </select><br></br>
                <!--observaciones llenado por el vigilante-->
                <label for="observaciones">Observaciones</label>
                <textarea name="observaciones" id="observaciones" rows="4" cols="50"></textarea>
                <!--captura de foto por el vigilante-->
                <div class="foto-container">
                    <div id="vista-previa-foto" class="vista-previa-foto"></div>
                    <input type="file" id="foto" name="foto" onchange="previewFoto(event)">
                </div>

                <!--boton de ingresar-->
                <div class="contenedor_boton">
                    <button type="button" class="boton_Ingresar" onclick="">Capturar Foto</button>
                    <button type="submit" class="boton_Ingresar">Ingresar</button>

                </div>
            </form>
        </div>
        <!--menu lateral derecho vista del vigilante-->
        <div class="contenedor_menu_4">
            <a href="vigilante_dashboard.php">Regresar</a>
            <i class="fa-solid fa-file-circle-plus"></i>

            <a href="registro_ingreso.php">Nuevo Ingreso</a>
            <i class="fa-solid fa-arrow-right-from-bracket"></i>

            <a href="salidas.php">Registrar Salida</a>
            <i class="fa-regular fa-pen-to-square"></i>

            <a href="#">Reportes</a>
            <i class="fa-solid fa-barcode fa-2x"></i>

            <a href="#">Lector Cedula</a>
            <i class="fa-solid fa-house"></i>

            <a href="vigilante_dashboard.php">Inicio</a>


        </div>
        <!--boton de cerrar sesion -->
        <div class="contenedor_cerrar_sesion_consulta">
            <a href="cerrar_session.php" class="boton_cerrar_sesion">Cerrar Sesión</a>
        </div>
    </main>

</body>

</html>