<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
if(consultasSQL::UpdateSQL("administrador", "Estado='Activo'", "CodigoAdmin='$primaryKey'")){
    echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({ 
                    title:"¡Cuenta activada!", 
                    text:"La cuenta del administrador se activo exitosamente", 
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
            text:"No hemos podido realizar la operación solicitada, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
