<?php
session_start();

include("conecta.php"); // Conexión a la base de datos

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    try {
        // Preparar la consulta para verificar el usuario
        $stmt = $conn->prepare("
            SELECT u.*, r.rol
            FROM usuarios u
            INNER JOIN roles r ON u.id_rol = r.id_rol
            WHERE u.usuario = :usuario
        ");
        $stmt->bindParam(':usuario', $nombre_usuario);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && password_verify($password, $user['contraseña'])) {
            // Almacenar el id_usuario en la sesión
            $_SESSION['id_usuario'] = $user['id_usuario']; /// se realiza esta modificacion
            $_SESSION['cedula'] = $user['cedula'];
            $_SESSION['nombre_usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['id_rol'];

            switch ($user['id_rol']) {
                case 5:
                    header("Location: admin_dashboard.php");
                    break;
                case 6:
                    header("Location: vigilante_dashboard.php");
                    break;
                case 7:
                    header("Location: residente_dashboard.php");
                    break;
                case 8:
                    header("Location: propietario_dashboard.php");
                    break;
                default:
                    $_SESSION['error'] = "Rol no reconocido";
                    header("Location: login.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Nombre de usuario o contraseña incorrectos";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error en la conexión a la base de datos";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
