<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
$checkLoanBook=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoLibro='".$primaryKey."'");
if(mysqli_num_rows($checkLoanBook)<=0){
    if(consultasSQL::DeleteSQL("libro", "CodigoLibro='$primaryKey'")){
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Libro eliminado!", 
                text:"Los datos del libro se eliminaron exitosamente", 
                type: "success", 
                confirmButtonText: "Aceptar" 
            },
            function(isConfirm){  
                if (isConfirm) {     
                   window.location="home.php";
                } else {    
                    window.location="home.php";
                } 
            });
        </script>';
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No se pudo eliminar el libro del sistema, por favor intenta de nuevo", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    } 
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"Este libro tiene préstamos registrados, no puedes eliminarlo", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkLoanBook);