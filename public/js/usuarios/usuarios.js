$(document).ready(function(){
    $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
});

function agregarNuevoUsuario(){
    
    $.ajax({
        type: "POST",
        data: $('#frmAgregarUsuario').serialize(),
        url:"/Mesa-de-ayuda/procesos/usuarios/crud/agregarNuevoUsuario.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                $('#tablaUsuariosLoad').load("usuarios/tablaUsuarios.php");
                $('#frmAgregarUsuario')[0].reset();
                Swal.fire(":D","Agregado con exito!","success");
            } else { 
                 Swal.fire("Error", "No se pudo agregar el usuario. Código: " + respuesta, "error");    
            }
        }
    });

    return false;
}

function obtenerDatosUsuario(idUsuario){
    $.ajax({
        type: "POST",
        data: "idUsuario=" + idUsuario,
        url:"/Mesa-de-ayuda/procesos/usuarios/crud/obtenerDatosUsuarios.php",
        success:function(respuesta){
            respuesta = jQuery.parseJSON(respuesta);
           $('#idUsuario').val($respuesta['idUsuario']);
           $('#partenou').val($respuesta['paterno']);
           $('#maternou').val($respuesta['materno']);
           $('#nombreu').val($respuesta['nombrePersona']);
           $('#fechaNacimientou').val($respuesta['fechaNacimiento']);
           $('#sexou').val($respuesta['sexo']);
           $('#telefonou').val($respuesta['telefono']);
           $('#correou').val($respuesta['correo']);
           $('#usuariou').val($respuesta['nombreUsuario']);
           $('#idRolu').val($respuesta['idRol']);
           $('#ubicacionu').val($respuesta['ubicacion']);
           
        }
    });

}