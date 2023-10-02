<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
if(consultasSQL::DeleteSQL("seccion", "CodigoSeccion='$primaryKey'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Sección eliminada!", 
            text:"Los datos de la sección se eliminaron exitosamente", 
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
            text:"No se pudo eliminar la sección, por favor intente nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}