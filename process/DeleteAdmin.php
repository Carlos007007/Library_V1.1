<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
if(consultasSQL::DeleteSQL("administrador", "CodigoAdmin='".$primaryKey."'") && consultasSQL::DeleteSQL("bitacora", "CodigoUsuario='".$primaryKey."' AND Tipo='Administrador'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Cuenta eliminada!", 
            text:"La cuenta del administrador se eliminó exitosamente", 
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
    </script>';
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No se pudo eliminar la cuenta del administrador, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
