<?php
session_start();
include('conecta.php'); // conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $apartamento = $_POST['apartamento'];
    $observaciones = $_POST['observaciones'];
    $rol = $_POST['rol']; // tipo de ingreso
    $vehiculo = $_POST['vehiculo']; // medio de ingreso

    // Verificar que el usuario esté autenticado
    if (!isset($_SESSION['id_usuario'])) {
        $_SESSION['error'] = "Error: No estás autenticado.";
        header('Location: registro_ingreso.php');
        exit();
    }

    $id_usuario = $_SESSION['id_usuario']; // id del usuario de la sesión

    // Verificar si el id_usuario existe en la tabla usuarios
    $stmt_verificar_usuario = $conn->prepare('SELECT usuario FROM usuarios WHERE id_usuario = :id_usuario');
    $stmt_verificar_usuario->bindParam(':id_usuario', $id_usuario);
    $stmt_verificar_usuario->execute();

    $user_data = $stmt_verificar_usuario->fetch(PDO::FETCH_ASSOC);

    if (!$user_data) {
        $_SESSION['error'] = "Error: El ID de usuario no existe.";
        header('Location: registro_ingreso.php');
        exit();
    }

    $nombre_usuario_ingreso = $user_data['usuario']; // Obtener el nombre del usuario

    // Fecha y hora actuales
    $fecha_actual = date('Y-m-d H:i:s');
    $hora_ingreso = date('H:i:s');

    // Verificar si ya existe un ingreso activo para la misma cédula
    $stmt_verificar = $conn->prepare('SELECT * FROM ingresos WHERE cedula = :cedula AND h_salida IS NULL');
    $stmt_verificar->bindParam(':cedula', $cedula);
    $stmt_verificar->execute();

    if ($stmt_verificar->rowCount() > 0) {
        $_SESSION['error'] = "Error: La persona ya se encuentra con ingreso activo.";
        header('Location: registro_ingreso.php');
        exit();
    }

    // Registrar el nuevo ingreso
    try {
        $stmt = $conn->prepare('INSERT INTO ingresos (fecha, h_ingreso, nombres, apellidos, cedula, id_usuario, observaciones, apartamento, rol, vehiculo, usuario_ingreso) VALUES (:fecha, :h_ingreso, :nombres, :apellidos, :cedula, :id_usuario, :observaciones, :apartamento, :rol, :vehiculo, :usuario_ingreso)');
        $stmt->bindParam(':fecha', $fecha_actual);
        $stmt->bindParam(':h_ingreso', $hora_ingreso);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':apartamento', $apartamento);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':vehiculo', $vehiculo);
        $stmt->bindParam(':observaciones', $observaciones);
        $stmt->bindParam(':usuario_ingreso', $nombre_usuario_ingreso);

        $stmt->execute();
        $_SESSION['success'] = "Ingreso registrado correctamente.";
        header('Location: registro_ingreso.php');
        exit();
    } catch (PDOException $e) {
        // Establecer el mensaje de error en caso de fallo
        $_SESSION['error'] = "Error al registrar el ingreso: " . $e->getMessage();
        header('Location: registro_ingreso.php');
        exit();
    }
}
