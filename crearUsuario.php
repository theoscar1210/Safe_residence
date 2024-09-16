<?php

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
    $u_existente = 0;
    $password_diferente = 0;

    // Verificamos si el usuario ya existe en la base de datos
    $stmt = $conn->prepare('SELECT usuario FROM usuarios WHERE usuario = :usuario and email = :email and cedula = :cedula ' );
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->execute();

    
    
    if( $stmt->rowCount() > 0){
        $d_insertados = 0;
        $u_existente = 1;//usuario ya existe
        
    }else if($password != $c_password){
        $d_insertados = 0;
        $password_diferente = 1;//contraseña no coincide
        
    }else{
        
        
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

        $d_insertados = 1;//datos insertados

        
    };
    
 

    

    
} ;


header('Location: confirmarUsuario.php');
exit();
