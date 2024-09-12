<?php

$user = 'root';
$password = '';
$servidor = 'localhost';
$database = 'SafeResidence';

try{

    $conn = new PDO('mysql:local=$servidor, dbname=$database, charset= utf8', $user, $password);
    $conn ->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
} catch (PDOExeption $e){
    echo 'Error de conexion'.$e->getMesagge();
}

