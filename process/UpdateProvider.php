<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$providerCode=consultasSQL::CleanStringText($_POST['providerCode']);
$providerName=consultasSQL::CleanStringText($_POST['providerName']);
$providerEmail=consultasSQL::CleanStringText($_POST['providerEmail']);
$providerAddress=consultasSQL::CleanStringText($_POST['providerAddres']);
$providerPhone=consultasSQL::CleanStringText($_POST['providerPhone']);
$providerResponse=consultasSQL::CleanStringText($_POST['providerResponsible']);
if(consultasSQL::UpdateSQL("proveedor", "Nombre='$providerName',Email='$providerEmail',Direccion='$providerAddress',Telefono='$providerPhone',ResponAtencion='$providerResponse'", "CodigoProveedor='$providerCode'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Proveedor actualizado!", 
            text:"Los datos del proveedor se actualizaron correctamente", 
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
}
else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No se pudo actualizar los datos del proveedor, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}