<?php
session_start(); // Inicia sesión 

include('conecta.php'); // conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['salidas']) && !empty($_POST['salidas'])) {
        $ids_salida = $_POST['salidas'];
        $hora_salida = date('H:i:s'); // Genera la hora de salida

        // Verificar que el usuario esté autenticado
        if (!isset($_SESSION['id_usuario'])) {
            $_SESSION['error'] = "Error: No estás autenticado.";
            header("Location: salidas.php");
            exit();
        }

        // Obtener el ID del usuario que realiza la salida desde la sesión
        $id_usuario_salida = $_SESSION['id_usuario'];

        //obtener el nombre del usuario que realiza la salida

        $stmt_comp_usuario = $conn->prepare('SELECT usuario FROM usuarios WHERE id_usuario = :id_usuario');
        $stmt_comp_usuario->bindParam(':id_usuario', $id_usuario_salida);
        $stmt_comp_usuario->execute();
        $datos_usuario_salida = $stmt_comp_usuario->fetch(PDO::FETCH_ASSOC);

        if (!$datos_usuario_salida) {
            $_SESSION['error'] = "Error: El id de usuario no existe";
            header("Location: salidas.php");
            exit();
        }

        $nombre_usuario_salida = $datos_usuario_salida['usuario']; // Nombre del usuario que registra la salida

        try {
            // Preparar la consulta para actualizar la hora de salida y el nombre del usuario que la registra
            $stmt = $conn->prepare("UPDATE ingresos SET h_salida = :h_salida, usuario_salida = :usuario_salida WHERE id_ingreso = :id_ingreso");

            // Recorre cada ID seleccionado y ejecuta la actualización
            foreach ($ids_salida as $id) {
                $stmt->bindParam(':h_salida', $hora_salida); // Vincula la hora de salida
                $stmt->bindParam(':usuario_salida', $nombre_usuario_salida); // Vincula el nombre del usuario que realiza la salida
                $stmt->bindParam(':id_ingreso', $id); // Vincula el ID de ingreso
                $stmt->execute(); // Ejecuta la actualización
            }

            // Si se registran las salidas, almacena un mensaje de éxito
            $_SESSION['success'] = "Salidas registradas correctamente.";
            header("Location: salidas.php"); // Redirige a la página después de procesar
            exit();
        } catch (PDOException $e) {
            // En caso de error, almacena un mensaje de error
            $_SESSION['error'] = "Error al registrar salidas: " . $e->getMessage();
            header("Location: salidas.php");
            exit();
        }
    } else {
        // Si no se seleccionó ninguna salida, muestra un mensaje de error
        $_SESSION['error'] = "No se seleccionó ninguna salida.";
        header("Location: salidas.php");
        exit();
    }
} else {
    // Si se accede a la página sin enviar un formulario POST, redirige
    header("Location: salidas.php");
    exit();
}
