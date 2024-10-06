<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión Safe Residence</title>
    <link rel="stylesheet" href="../css/estilos.css" />
    <link rel="icon" href="../imagenes/logo.ico" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>



<body>
    <main>
        <header>
            <div class="contenedor_logo_">
                <img src="../imagenes/logo.png" alt="logo" />
                <h1>Bienvenido a nuestro sistema de registro</h1>
        </header>
        </div>


        <div class="contenedor_login">
            <!--mostrar mensaje de error si existe-->
            <?php if (isset($_GET['error'])): ?>
                <p style="color: brown;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
            <!--login-->
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<p style='color: red;'>" . htmlspecialchars($_SESSION['error']) . "</p>";
                unset($_SESSION['error']); // Eliminar el error después de mostrarlo
            }
            ?>

            <form
                action="process_login.php" method="POST" class="formulario_login">
                <h2>Iniciar Sesión</h2>
                <input
                    type="text"
                    name="nombre_usuario"
                    placeholder="Nombre de Usuario"
                    required />
                <input
                    type="password"
                    name="password"
                    placeholder="Contraseña"
                    required />
                <div class="botones_login">
                    <button type="submit" class="btn_iniciar_sesion">Iniciar</button>
                </div>
                <a href="ruta_recuperacion_contraseña.php">¿Olvidaste tu contraseña?</a>
            </form>
        </div>
    </main>
</body>

</html>