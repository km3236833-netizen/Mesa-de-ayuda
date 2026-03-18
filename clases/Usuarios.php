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

    
    public function agregaNuevoUsuario($datos) {
        $conexion = $this->conectar();
        
        // 1. Insertar persona y obtener su ID
        $idPersona = $this->agregarPersona($datos);
        
        if ($idPersona > 0) {
            // 2. Insertar usuario con el ID de persona obtenido
            $sql = "INSERT INTO t_usuarios (id_rol, id_persona, usuario, password, ubicacion)
                    VALUES (?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
            $query->bind_param(
                "iisss",
                $datos['idRol'],
                $idPersona,
                $datos['usuario'],
                $datos['password'],
                $datos['ubicacion']
            );
            
            if ($query->execute()) {
                $respuesta = 1;
            } else {
                $respuesta = 0;
                error_log("Error al insertar en t_usuarios: " . $conexion->error);
            }
            $query->close();
            return $respuesta;
        } else {
            return 0;
        }
    }

    
    public function agregarPersona($datos) {
        $conexion = $this->conectar();
        $sql = "INSERT INTO t_persona (paterno, materno, nombre, fecha_nacimiento, sexo, telefono, correo)
                VALUES (?, ?, ?, ?, ?, ?, ?)";    
        $query = $conexion->prepare($sql);
        $query->bind_param(
            "sssssss",
            $datos['paterno'],
            $datos['materno'],
            $datos['nombre'],
            $datos['fechaNacimiento'],
            $datos['sexo'],
            $datos['telefono'],
            $datos['correo']
        );
        
        if ($query->execute()) {
            $idPersona = $conexion->insert_id;
        } else {
            $idPersona = 0;
            error_log("Error al insertar en t_persona: " . $conexion->error);
        }
        $query->close();
        return $idPersona;
    }

    public function obtenerDatosUsuario($idUsuario) {
    $conexion = $this->conectar();

        $sql ="SELECT
                usuarios.id_usuario AS idUsuario,
                usuarios.usuario AS nombreUsuario,
                 roles.nombre AS rol,
                usuarios.id_rol AS idRol,
                usuarios.ubicacion AS ubicacion,
                usuarios.activo AS estatus,
                usuarios.id_persona AS idPersona,
                 persona.nombre AS nombrePersona,
                persona.paterno AS paterno,
                persona.materno AS materno,
                persona.fecha_nacimiento AS fechaNacimiento,
                persona.sexo AS sexo,
                persona.correo AS correo,
                 persona.telefono AS telefono   
            FROM 
                t_usuarios AS usuarios 
                    INNER JOIN
                t_cat_roles AS roles ON usuarios.id_rol = roles.id_rol 
                    INNER JOIN
                t_persona AS persona ON usuarios.id_persona = persona.id_persona 
                AND usuarios.id_usuario = '$idUsuario'";
        $respuesta = mysqli_query($conexion,$sql);
        $usuario = mysqli_fetch_array($respuesta);

        $datos = array(
                'idUsuario' => $usuario['idUsuario'],
                'nombreUsuario' => $usuario['nombreUsuario'],
                'rol' => $usuario['rol'],
                'idRol' => $usuario['idRol'],
                'ubicacion' => $usuario['ubicacion'],
                'estatus' => $usuario['estatus'],
                'idPersona' => $usuario['idPersona'],
                'nombrePersona' => $usuario['nombrePersona'],
                'paterno' => $usuario['paterno'],
                'materno' => $usuario['materno'],
                'fechaNacimiento' => $usuario['fechaNacimiento'],
                'sexo' => $usuario['sexo'],
                'correo' => $usuario['correo'],
                'telefono' => $usuario['telefono']
                );
        return $datos;
        
        }

        public function actualizarUsuario($datos){
        $conexion = $this->conectar(); 
        $exitoPersona = self::actualizarPersona($datos);
        if($exitoPersona){
            $sql= "UPDATE t_usuarios SET id_rol = ?,
                                            usuario =?,
                                            ubicacion =?,
                    WHERE id_usuario = ?";
                $query = $conexion -> prepare($sql);
                $query->bind_param( 'issi',$datos['idRol'],
                                           $datos['usuario'],
                                           $datos['ubicacion'],
                                           $datos['idUsuario']);
                $respuesta = $query->execute();
                $query->close();
                return $respuesta;
        }else { 
            return 0;
        }
    }

        public function actualizarPersona($datos){
        $conexion = $this->conectar(); 
        $idPersona = self::obtenerIdPersona($datos['idUsuario']);    

        $sql = "UPDATE t_persona SET    paterno  = ?,                    
                                        materno  = ?,         
                                        nombre = ?,                        
                                        fecha_nacimiento = ?,
                                        sexo = ?,           
                                        telefono = ?,     
                                        correo = ?,      
                                        fechaInser =?,
                WHERE id_persona = ?";
                $query = $conexion ->prepare($sql);
                $query->bind_param('ssssssssi', $datos['paterno'],
                                                $datos['materno'],
                                                $datos['nombre'],
                                                $datos['fechaNacimiento'],
                                                $datos['sexo'],
                                                $datos['telefono'],
                                                $datos['correo '],
                                                $datos['fechaInser'],
                                                $idPersona);
                $respuesta = $query -> execute();
                $query->close();
                return $respuesta;
        }
        
        public function obtenerIdPersona($idUsuario){
        $conexion = $this->conectar(); 
        $sql =" SELECT
                        persona.id_persona AS idPersona
                FROM
                        t_usuarios AS usuarios
                INNER JOIN
                        t_persona AS persona ON usuarios.id_persona = persona.id_persona
                        AND usuarios.id_usuario = '$idUsuario'";
                $respuesta = mysqli_query($conexion, $sql);

                $idPersona = mysqli_fetch_array($respuesta)['idPersona']; 
                
                return $idPersona;
        }
    }


?>