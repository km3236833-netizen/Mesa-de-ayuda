<?php
include "conexion.php";  

class Usuarios extends Conexion {
    public function loginUsuario($usuario, $password) {
        $conexion = $this->conectar();
        if (!$conexion) {
            return "Error de conexión: " . mysqli_connect_error();
        }

        $sql = "SELECT * FROM t_usuarios WHERE usuario = '$usuario' AND password = '$password'";
        $respuesta = mysqli_query($conexion, $sql);

        if (!$respuesta) {
            return "Error en la consulta: " . mysqli_error($conexion);
        }

        if (mysqli_num_rows($respuesta) > 0) {
            $datosUsuario = mysqli_fetch_assoc($respuesta);
            $_SESSION['usuario']['nombre'] = $datosUsuario['usuario'];
            $_SESSION['usuario']['id'] = $datosUsuario['id_usuario'];
            $_SESSION['usuario']['rol'] = $datosUsuario['id_rol'];
            return "1";
        } else {
            return "0";
        }
    }
}
?>