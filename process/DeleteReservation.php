<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$loanCode=consultasSQL::CleanStringText($_POST['loanCode']);
$userTable=consultasSQL::CleanStringText($_POST['userTable']);
$urlRefresh=consultasSQL::CleanStringText($_POST['urlRefresh']);
if(consultasSQL::DeleteSQL("$userTable", "CodigoPrestamo='$loanCode'") && consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='$loanCode'")){
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Reservación cancelada!", 
            text:"La reservación se cancelo con éxito", 
            type: "success", 
            confirmButtonText: "Aceptar" 
        },
        function(isConfirm){  
            if (isConfirm) {     
               window.location="'.$urlRefresh.'";
            } else {    
               window.location="'.$urlRefresh.'";
            } 
        });
    </script>';
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No se pudo eliminar la reservación, por favor intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}