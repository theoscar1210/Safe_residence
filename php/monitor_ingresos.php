<?php
session_start();
include('conecta.php');

// Verificar si el usuario está autenticado y tiene el rol adecuado
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 6) { // 6 es el id_rol para el Vigilante
    header("Location: login.php?error=Acceso no autorizado");
    exit();
}

try {
    // Consulta para contar ingresos, salidas y personas dentro por tipo de visitante
    $stmt_resumen = $conn->prepare("
        SELECT rol, 
               COUNT(*) AS total_ingresos, 
               SUM(CASE WHEN h_salida IS NOT NULL THEN 1 ELSE 0 END) AS total_salidas, 
               SUM(CASE WHEN h_salida IS NULL THEN 1 ELSE 0 END) AS total_dentro
        FROM ingresos
        GROUP BY rol
    ");
    $stmt_resumen->execute();
    $resumen = $stmt_resumen->fetchAll(PDO::FETCH_ASSOC);

    if (!is_array($resumen)) {
        $resumen = []; // Asegura que sea un array para evitar errores
    }
} catch (PDOException $e) {
    echo "Error:" . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Ingresos-Safe Residence</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="icon" href="../Imagenes/logo.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <div class="contenedor_logo_izquierdo">
            <img src="../Imagenes/logo.png" alt="logo">
        </div>
    </header>

    <main>
        <div class="contenedor_monitor_ingresos">
            <h1>Monitor de Ingresos Bienvenido <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?><br> </h1>
            <table>
                <tr>
                    <th>Tipo de Visitante</th>
                    <th>Ingresos</th>
                    <th>Salidas</th>
                    <th>En el Edificio</th>
                </tr>
                <?php
                foreach ($resumen as $row) {
                    echo "<tr>
                    <td>{$row['rol']}</td>
                    <td>{$row['total_ingresos']}</td>
                    <td>{$row['total_salidas']}</td>
                    <td>{$row['total_dentro']}</td>
                    </tr>";
                }
                ?>
            </table>
        </div>

        <div class="contenedor_menu_3">
            <a href="vigilante_dashboard.php">Regresar</a>

            <i class="fa-solid fa-file-circle-plus"></i>
            <a href="registro_ingreso.php">Nuevo Ingreso</a>

            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <a href="salidas.php">Registrar Salida</a>

            <i class="fa-regular fa-pen-to-square"></i>
            <a href="#">Reportes</a>

            <i class="fa-regular fa-file-excel"></i>
            <a href="#">Exportar Xls</a>

            <i class="fa-solid fa-house"></i>
            <a href="vigilante_dashboard.php">Inicio</a>
        </div>

        <div class="contenedor_cerrar_sesion_consulta">
            <a href="cerrar_session.php" class="boton_cerrar_sesion">Cerrar Sesión</a>
        </div>
    </main>
</body>

</html>