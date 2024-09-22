<?php
session_start(); //iniciamos sesion para enviar datos de variables a crear_usuario.php


//incluimos el archivo que conecta a la base de datos
include("conecta.php");

//Seleccionando tabla "Usuarios"
$query = "select u.id_usuario, 
u.nombres,
u.apellidos,
u.cedula,
u.telefono,
u.email,
u.usuario,
r.rol
from usuarios u
join roles r
on u.id_rol = r.id_rol;";

//ejecutamos la consulta 
try{
    $result = $conn->query($query);
}catch(mysqli_sql_exception $e){
    echo "Error ". $e->getMessage() ;
}