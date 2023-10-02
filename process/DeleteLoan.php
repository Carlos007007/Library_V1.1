<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$LoanKey=consultasSQL::CleanStringText($_POST['LoanKey']);
$UserType=consultasSQL::CleanStringText($_POST['UserType']);
if($UserType=="Docente"){ $TableLoan="prestamodocente"; }
if($UserType=="Estudiante"){ $TableLoan="prestamoestudiante"; }
if($UserType=="Visitante"){ $TableLoan="prestamovisitante"; }
if($UserType=="Personal"){ $TableLoan="prestamopersonal"; }
if(consultasSQL::DeleteSQL($TableLoan, "CodigoPrestamo='$LoanKey'")){
    if(consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='$LoanKey'")){
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Préstamo eliminado!", 
                text:"Los datos del préstamo se eliminaron exitosamente", 
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
                text:"No hemos podido eliminar el préstamo, por favor intente nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No hemos podido eliminar el préstamo, por favor intente nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}