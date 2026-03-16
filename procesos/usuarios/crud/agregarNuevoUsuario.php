<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método no permitido");
}

$datos = array(
    "paterno" => $_POST['paterno'] ?? '',
    "materno" => $_POST['materno'] ?? '',
    "nombre" => $_POST['nombre'] ?? '',
    "fechaNacimiento" => $_POST['fecha_nacimiento'] ?? '', // name del formulario
    "sexo" => $_POST['sexo'] ?? '',
    "telefono" => $_POST['telefono'] ?? '',
    "correo" => $_POST['correo'] ?? '',
    "usuario" => $_POST['usuario'] ?? '',
    "password" => sha1($_POST['password'] ?? ''),
    "idRol" => $_POST['idRol'] ?? '',
    "ubicacion" => $_POST['ubicacion'] ?? ''
);

include $_SERVER['DOCUMENT_ROOT'] . '/Mesa-de-ayuda/clases/Usuarios.php';

if (!class_exists('Usuarios')) {
    die("Error: Clase Usuarios no encontrada");
}

$usuarios = new Usuarios();
echo $usuarios->agregaNuevoUsuario($datos); // ¡sin la 'r' en "agrega"!
?>