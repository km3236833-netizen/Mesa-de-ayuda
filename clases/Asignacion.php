<?php
include "conexion.php";
 class Asignacion extends Conexion{
    public function agregarAsignacion($datos){
        $conexion= Conexion::conectar();

        $sql = "INSERT INTO t_asignacion(id_asignacion,
                            id_cat_equipo,
                            id_persona,  
                            marca,
                            modelo,
                            color,
                            descripcion,  
                            memoria,
                            disco_duro,
                            procesador );
    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $query =$conexion->prepare($sql);
    $query->bind_param('iisssssss',$datos['id_persona'],
                                    $datos['idEquipo'],
                                    $datos['marca'],
                                    $datos['modelo'],
                                    $datos['color'],
                                    $datos['descripcion'],
                                    $$datos['memoria'],
                                    $datos['discoDuro'],
                                    $datos['procesador'],
                                    );
    $respuesta = $query -> execute();
    $query->close();
    return $respuesta;

    }
 }