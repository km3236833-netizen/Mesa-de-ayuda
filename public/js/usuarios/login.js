function loginUsuario(){
    
    $.ajax({
        type:"POST",
        data:$('#frmLogin').serialize(),
       url: "/Mesa-de-ayuda/procesos/usuarios/login/loginUsuario.php",
        success:function(respuesta){
            respuesta = respuesta.trim();
            if(respuesta == 1){
                window.location.href = "/Mesa-de-ayuda/vistas/inicio.php";
            }else{
                Swal.fire(":(","Error al entrar!" + respuesta, "error");
            }
        }
    });
    return false;
}