<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


if (!isset($_POST['login']) || !isset($_POST['password'])) {
    die("Error: No se recibieron los datos de login.");
}

$usuario = $_POST['login'];
$password = sha1($_POST['password']);

include "../../../clases/Usuarios.php"; 

$Usuarios = new Usuarios();
echo $Usuarios->loginUsuario($usuario, $password);
?>
