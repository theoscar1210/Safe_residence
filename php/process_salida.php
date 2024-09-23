<?php
session_start(); // Inicia sesión 

include('conecta.php'); // conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['salidas']) && !empty($_POST['salidas'])) {
        $ids_salida = $_POST['salidas'];
        $hora_salida = date('H:i:s'); // Genera la hora de salida

        try {
            // Preparar la consulta para actualizar la hora de salida
            $stmt = $conn->prepare("UPDATE ingresos SET h_salida = :h_salida WHERE id_ingreso = :id_ingreso");

            // Recorre cada ID seleccionado y ejecuta la actualización
            foreach ($ids_salida as $id) {
                $stmt->bindParam(':h_salida', $hora_salida); // Vincula la hora de salida
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
