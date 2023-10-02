<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$AdminCode=consultasSQL::CleanStringText($_POST['AdminCode']);
$bookCorrelative=consultasSQL::CleanStringText($_POST['bookCorrelative']);
$bookCode=consultasSQL::CleanStringText($_POST['bookCode']);
$loanCode=consultasSQL::CleanStringText($_POST['loanCode']);
$userFile=consultasSQL::CleanStringText($_POST['userFile']);
$userType=consultasSQL::CleanStringText($_POST['userType']);
$selectDataBook=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='$bookCode'");
$dataBook=mysqli_fetch_array($selectDataBook, MYSQLI_ASSOC);
if($userType=="Docente"){
    $ct=0;
    foreach($_POST['bookCorrelative'] as $codeTemp){
        if($ct<=0){
            $finalcorrelative=$finalcorrelative.$codeTemp;
        }else{
            $finalcorrelative=$finalcorrelative.','.$codeTemp;
        }
        $ct++;
    }
    $numDesc=$ct;
}else{
    $numDesc=1;
    $finalcorrelative=$bookCorrelative;
}
$totalD=($dataBook['Existencias']-$dataBook['Prestado'])-$numDesc;
$totalUp=$dataBook['Prestado']+$numDesc;
if($totalD>=0){
    $checkingCorrelative=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CorrelativoLibro='$bookCorrelative' AND Estado='Prestamo'");
    if(mysqli_num_rows($checkingCorrelative)<=0){
        if(consultasSQL::UpdateSQL("libro", "Prestado='$totalUp'", "CodigoLibro='$bookCode'") && consultasSQL::UpdateSQL("prestamo", "CorrelativoLibro='$finalcorrelative',CodigoAdmin='$AdminCode',Estado='Prestamo'", "CodigoPrestamo='$loanCode'")){
            if($userType=="Docente"){
                consultasSQL::UpdateSQL("prestamodocente", "Cantidad='$numDesc'", "CodigoPrestamo='$loanCode'");
            }
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Préstamo aprobado!", 
                    text:"El préstamo se aprobó con éxito", 
                    type: "success", 
                    confirmButtonText: "Aceptar",
                    closeOnConfirm: false
                },
                function(){      
                    swal({
                      title: "¿Quieres ver la ficha del préstamo?",
                      text: "También puedes ver la ficha después ingresando a la sección de Devoluciones pendientes",
                      type: "info",
                      showCancelButton: true,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "Si, ver ficha",
                      cancelButtonText: "No, después",
                      closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            window.open("../report/'.$userFile.'.php?loanCode='.$loanCode.'","_blank");
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
                    text:"No hemos podido aprobar la reservación, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"El correlativo del libro se encuentra en un préstamo vigente, por favor verifica e intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No hay existencias disponibles o has excedido el número de libros disponibles para realizar el préstamo", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($selectDataBook);
mysqli_free_result($checkingCorrelative);