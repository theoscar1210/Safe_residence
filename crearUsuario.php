<?php

error_reporting(E_ERROR);

session_start(); // Iniciamos sesión para enviar datos a crear_usuario.php

// Incluimos el archivo que conecta a la base de datos
include("conecta.php");

// Verificamos que el método de envío sea igual a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // RECOGEMOS LOS DATOS Y LOS ALMACENAMOS EN VARIABLES INDIVIDUALES
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $cedula = $_POST['cedula'];
    $rol = intval($_POST['rol']);
    $email = $_POST['email'];
    $apartamento = $_POST['apartamento'];
    $telefono = $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];

    $d_insertados = 0; // 0: datos no insertados, 1: datos insertados
    $u_existente = 0; // 0: usuario no existe, 1: usuario existe
    $password_diferente = 0; // 0: contraseñas iguales, 1: contraseñas diferentes

    // Verificamos si el usuario ya existe en la base de datos
    try {
        $stmt = $conn->prepare('SELECT usuario FROM usuarios WHERE usuario = :usuario  and cedula = :cedula');
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $u_existente = 1;
            $_SESSION['u_existente'] = 1;
            header('Location: crear_usuario.php');
            exit();
        }
    } catch (PDOException $e) {
        echo 'Error al verificar si el usuario ya existe: ' . $e->getMessage();
        exit();
    }

    // Verificamos si las contraseñas coinciden
    if ($password != $c_password) {
        $password_diferente = 1;
        $_SESSION['password_diferente'] = 1;
        header('Location: crear_usuario.php');
        exit();
    }

    // Si el usuario no existe y las contraseñas coinciden
    if ($u_existente == 0 && $password_diferente == 0) {

        try {
            // Insertamos el nuevo usuario
            $stmt2 = $conn->prepare('INSERT INTO usuarios (nombres, apellidos, cedula, telefono, usuario, contraseña, email, id_rol)
            VALUES (:nombres, :apellidos, :cedula, :telefono, :usuario, :password, :email, :rol)');
            $stmt2->bindParam(':nombres', $nombres);
            $stmt2->bindParam(':apellidos', $apellidos);
            $stmt2->bindParam(':cedula', $cedula);
            $stmt2->bindParam(':telefono', $telefono);
            $stmt2->bindParam(':usuario', $usuario);
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);//contraseña encriptada
            $stmt2->bindParam(':password', $hashed_password);
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':rol', $rol);
            $stmt2->execute();

            if($rol ===4){

                 // Recuperamos el id_usuario
                $stmt3 = $conn->prepare('SELECT id_usuario FROM usuarios WHERE usuario = :usuario AND cedula = :cedula AND id_rol = 4');
                $stmt3->bindParam(':usuario', $usuario);
                $stmt3->bindParam(':cedula', $cedula);
                $stmt3->execute();
                $id_usuario_row = $stmt3->fetch(PDO::FETCH_ASSOC);
                $id_usuario = intval($id_usuario_row['id_usuario']);

                // Insertamos al usuario en la tabla propietarios
                $stmt4 = $conn->prepare('INSERT INTO propietarios(id_usuario) VALUES(:id_usuario)');
                $stmt4->bindParam(':id_usuario', $id_usuario);
                $stmt4->execute();

                // Recuperamos el id_propietario
                $stmt5 = $conn->prepare('SELECT id_propietario FROM propietarios WHERE id_usuario = :id_usuario');
                $stmt5->bindParam(':id_usuario', $id_usuario);
                $stmt5->execute();
                $id_propietario_row = $stmt5->fetch(PDO::FETCH_ASSOC);
                $id_propietario = intval($id_propietario_row['id_propietario']);

                // Insertamos el apartamento
                $stmt6 = $conn->prepare('INSERT INTO apartamentos(numero, id_propietario) VALUES(:numero, :id_propietario)');
                $stmt6->bindParam(':numero', $apartamento);
                $stmt6->bindParam(':id_propietario', $id_propietario);
                $stmt6->execute();
            }

            $d_insertados = 1; // datos insertados
            $_SESSION['d_insertados'] = 1;
            header('Location: crear_usuario.php');
            exit();

        } catch (PDOException $e) {
            echo 'Error al insertar datos: ' . $e->getMessage();
            exit();
        }
    }
}

