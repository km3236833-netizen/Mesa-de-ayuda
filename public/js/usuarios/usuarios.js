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