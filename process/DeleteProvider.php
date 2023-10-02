<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
if(consultasSQL::DeleteSQL("proveedor", "CodigoProveedor='$primaryKey'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Proveedor eliminado!", 
            text:"Los datos del proveedor se eliminaron exitosamente", 
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
            text:"No se pudo eliminar el proveedor, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
