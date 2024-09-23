<?php
session_start();

include('conecta.php');
//iniciar el mensaje de exito


// Verificar si el usuario está autenticado y tiene el rol adecuado
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 6) { // 6 es el id_rol para el Vigilante
    header("Location: login.php?error=Acceso no autorizado");
    exit();
}
// Verificar si hay un mensaje de éxito
if (isset($_SESSION['success'])) {
    echo '<div class="mensaje_exito">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Limpiar el mensaje después de mostrarlo
}

try {
    // Obtener los registros de ingresos que aún no tienen salida registrada
    $stmt = $conn->prepare("SELECT * FROM ingresos WHERE h_salida IS NULL");
    $stmt->execute();
    $ingresos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Error al obtener los ingresos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Salida - Safe Residence</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Logo -->
    <header>
        <div class="contenedor_logo_izquierdo">
            <img src="../Imagenes/logo.png" alt="logo">
        </div>
    </header>

    <main>
        <!-- Tabla con la información del personal ingresado -->
        <div class="contenedor_salida_del_personal">
            <h1>Registrar Salida del Personal</h1>

            <!--mostrar menasaje de exito-->
            <?php if (!empty($mensaje_exito)): ?>
                <div class="mensaje_exito" style="text-align: center; margin: 150px; margin-bottom: 50px; color: hwb(187 2% 74%);"><?= $mensaje_exito; ?></div>

            <?php endif; ?>


            <!-- Filtro de búsqueda -->
            <div class="container_buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="busqueda" placeholder="Buscar..." />
            </div>

            <!-- Formulario para seleccionar salidas -->
            <form method="POST" action="process_salida.php">
                <table>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Fecha Ingreso</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cédula</th>
                        <th>Tipo de Ingreso</th>
                        <th>Apartamento</th>
                        <th>Observaciones</th>
                    </tr>

                    <?php if (!empty($ingresos)): ?>
                        <?php foreach ($ingresos as $ingreso): ?>
                            <tr>
                                <td><input type="checkbox" name="salidas[]" value="<?= $ingreso['id_ingreso']; ?>"></td>
                                <td><?= htmlspecialchars($ingreso['fecha']); ?></td>
                                <td><?= htmlspecialchars($ingreso['nombres']); ?></td>
                                <td><?= htmlspecialchars($ingreso['apellidos']); ?></td>
                                <td><?= htmlspecialchars($ingreso['cedula']); ?></td>
                                <td><?= htmlspecialchars($ingreso['tipo']); ?></td>
                                <td><?= htmlspecialchars($ingreso['apartamento']); ?></td>
                                <td><?= htmlspecialchars($ingreso['observaciones']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No hay ingresos registrados sin salida.</td>
                        </tr>
                    <?php endif; ?>
                </table>

                <!-- Paginación  -->
                <div class="paginacion">
                    <button type="button" onclick="prevPage()">Anterior</button>
                    <span id="pagina_num">Página 1</span>
                    <button type="button" onclick="nextPage()">Siguiente</button>
                </div>
        </div>

        <!-- Menu lateral derecho -->
        <div class="contenedor_menu_4">
            <a href="#">Regresar</a>
            <a href="registro_ingreso_vehicular.html">
                <i class="fa-solid fa-file-circle-plus"></i>
                Nuevo Ingreso
            </a>
            <button type="submit">Registrar Salida</button> <!-- Botón de salida aquí -->
            <a href="#">
                </form>
                <i class="fa-regular fa-pen-to-square"></i>
                Reportes
            </a>
            <a href="#">
                <i class="fa-solid fa-barcode fa-2x"></i>
                Lector Cédula
            </a>
            <a href="inicio_vigilante.html">
                <i class="fa-solid fa-house"></i>
                Inicio
            </a>
        </div>

        <!-- Botón de cerrar sesión -->
        <div class="contenedor_cerrar_sesion_consulta">
            <a href="cerrar_session.php" class="boton_cerrar_sesion">Cerrar Sesión</a>
        </div>

    </main>
</body>

</html>