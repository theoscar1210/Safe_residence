<?php
session_start(); //iniciamos sesion para enviar datos de variables a crear_usuario.php


//incluimos el archivo que conecta a la base de datos
include("conecta.php");

//Seleccionando tabla "Usuarios"
$query = "SELECT * FROM usuarios";
$result = $conn->query($query);

if(!$result){
    echo "Error de conexión";
}else{
    echo "Conexión exitosa";
}