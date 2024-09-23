<?php
session_start();

include('conecta.php'); // conexion a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //OBETENER DATOS DEL FORMULARIO
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $id_usuario = $_SESSION['id_usuario'];
    $apartamento = $_POST['apartamento'];
    $observaciones = $_POST['observaciones'];


    //verificar si el usuario esta autenticado

    //fecha y hora actualizadas por el sistema 
    $fecha_actual = date('Y-m-d H:i:s');
    $hora_ingreso = date('H:i:s');


    //preparar para la consulta 
    try {

        $stmt = $conn->prepare('INSERT INTO ingresos (fecha, h_ingreso, nombres, apellidos, cedula, id_usuario, observaciones, apartamento) VALUES (:fecha, :h_ingreso, :nombres, :apellidos, :cedula, :id_usuario, :observaciones, :apartamento)');
        $stmt->bindParam(':fecha', $fecha_actual);
        $stmt->bindParam(':h_ingreso', $hora_ingreso);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':apartamento', $apartamento);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':observaciones', $observaciones);

        $stmt->execute();

        $_SESSION['success'] = "Ingreso registrado correctamente.";
        header('Location: registro_ingreso.php');
        exit();
    } catch (PDOException $e) {
        //encaso de eror mostrar mensaje
        $_SESSION['error'] = "Error al registrar el ingreso:" . $e->getMessage();
        exit();
    }
}
