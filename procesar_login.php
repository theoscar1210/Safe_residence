<?php
session_start();
include('conecta.php');

// Sanear entradas
$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
$password = $_POST['password'];
$password_error = 0;
$user_error = 0;


try {
    // Consulta preparada con cláusula WHERE
    $stmt1 = $conn->prepare('SELECT usuario, contraseña, id_rol FROM usuarios WHERE usuario = :usuario');
    $stmt1->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt1->execute();

    // Obtener el resultado
    $datos = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($datos) {
        // Verificar la contraseña
        if (password_verify($password, $datos['contraseña'])) {

            switch ($datos["id_rol"]) {
                case 1:
                    header('Location: panelAdministrador.php');
            }
        } else {
            
            $_SESSION['password_error'] = 1;
            header('Location: index.php');
        }
    } else {
        
        $_SESSION['user_error'] = 1;
        header('Location: index.php');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


