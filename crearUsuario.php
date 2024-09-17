<?php

session_start();//iniciamos sesion para enviar datos de variables a crear_usuario.php


//incluimos el archivo que conecta a la base de datos
include("conecta.php");

//verificamos que el metodo de envio sea igual a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    //RECOJEMOS LOS DATOS Y LOS ALAMACENAMOS EN VARIABLES INDIVIDUALES
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

    $d_insertados = 0; //variable 0 datos no insertados, 1 datos insertados
    $u_existente = 0; //variable 0 usuario no existe, 1 usuario existe en la base de datos
    $password_diferente = 0; // variable 0 contraseñas iguales, 1 contraseñas diferentes
    

    // Verificamos si el usuario ya existe en la base de datos
    $stmt = $conn->prepare('SELECT usuario FROM usuarios WHERE usuario = :usuario  and cedula = :cedula ' );
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->execute();

    
    
    if ($stmt->rowCount() > 0) {
        $u_existente =1;
        $_SESSION['u_existente'] = 1;
        header('Location:crear_usuario.php');
        exit();
    }
    if ($password != $c_password) {
        $password_diferente = 1;
        $_SESSION['password_diferente'] = 1;
        header('Location:crear_usuario.php');
        exit();
    }
    
    if($u_existente ==0 and $password_diferente ==0){
        
        
        // Insertamos el nuevo usuario
        $stmt2 = $conn->prepare('INSERT INTO usuarios (nombres, apellidos, cedula, telefono, usuario, contraseña, email, id_rol)
        VALUES (:nombres, :apellidos, :cedula, :telefono, :usuario, :password, :email, :rol)');
        

        $stmt2->bindParam(':nombres', $nombres);
        $stmt2->bindParam(':apellidos', $apellidos);
        $stmt2->bindParam(':cedula', $cedula);
        $stmt2->bindParam(':telefono', $telefono);
        $stmt2->bindParam(':usuario', $usuario);
        $stmt2->bindParam(':password', $password); 
        $stmt2->bindParam(':email', $email);
        $stmt2->bindParam(':rol', $rol);

        $stmt2->execute();

        $stmt3 = $conn->prepare('SELECT id_usuario from usuarios where usuario = :usuario and cedula = :cedula and id_rol = 4');
        $stmt3->bindParam(':cedula', $cedula);
        $stmt3->bindParam(':usuario', $usuario);
        $stmt3->execute();

        // Accedemos al id_usuario
        $id_usuario_row = $stmt3->fetch(PDO::FETCH_ASSOC);
        $id_usuario = intval($id_usuario_row['id_usuario']);

        $stmt4 = $conn->prepare('INSERT INTO propietarios(id_usuario) VALUES(:id_usuario)');
        $stmt4->bindParam(':id_usuario', $id_usuario);
        $stmt4->execute();

        
        // Recuperamos el id_propietario
        $stmt5 = $conn->prepare('SELECT id_propietario FROM propietarios WHERE id_usuario = :id_usuario');
        $stmt5->bindParam(':id_usuario', $id_usuario);
        $stmt5->execute();
        $id_propietario_row = $stmt5->fetch(PDO::FETCH_ASSOC);
        $id_propietario = intval($id_propietario_row['id_propietario']);

        $stmt6 = $conn->prepare('INSERT INTO apartamentos(numero, id_propietario) VALUES(:numero, :id_propietario)');
        $stmt6->bindParam(':id_propietario', $id_propietario);
        $stmt6->bindParam(':numero', $apartamento);
        $stmt6->execute();

        

        $d_insertados = 1;//datos insertados
        $_SESSION['d_insertados'] = 1;
        
        header('Location:crear_usuario.php');
        exit();

        
    };

    
        
    

    
} ;

