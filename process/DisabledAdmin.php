<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
if(consultasSQL::UpdateSQL("administrador", "Estado='Desactivado'", "CodigoAdmin='$primaryKey'")){
    echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({ 
                    title:"¡Cuenta desactivada!", 
                    text:"La cuenta del administrador se desactivo exitosamente", 
                    type: "success", 
                    confirmButtonText: "Aceptar" 
                },
                function(isConfirm){  
                    if (isConfirm) {     
                        location.reload();
                    } else {    
                        location.reload();
                    } 
                });
            });
        </script>'; 
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No se pudo desactivar la cuenta del administrador, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}