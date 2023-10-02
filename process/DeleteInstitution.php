<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
if(consultasSQL::DeleteSQL("institucion", "CodigoInfraestructura='$primaryKey'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Datos eliminados!", 
            text:"Los datos de la institución se eliminaron exitosamente", 
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
            text:"No se pudo eliminar los datos de la institución, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}

