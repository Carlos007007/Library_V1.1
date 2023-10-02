<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$sectionCode=consultasSQL::CleanStringText($_POST['sectionCode']);
$teacherDUI=consultasSQL::CleanStringText($_POST['teacherDUI']);
if(consultasSQL::UpdateSQL("docente","CodigoSeccion='$sectionCode'","DUI='$teacherDUI'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Sección actualizada!", 
            text:"Los datos de la sección se actualizaron correctamente", 
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
            text:"No se pudo actualizar los datos de la sección, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}