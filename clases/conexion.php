<?php
class Conexion {
    public function conectar() {
        $servidor = "localhost";
        $usuario = "lizbeth";
        $password = "231190031";
        $db = "helpdesk";
        $conexion = mysqli_connect($servidor, $usuario, $password, $db);
        return $conexion;
    }
}
?>