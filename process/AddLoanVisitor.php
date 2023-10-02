<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$bookCode=consultasSQL::CleanStringText($_POST['bookCode']);
$adminCode=consultasSQL::CleanStringText($_POST['adminCode']);
$bookCorrelative=consultasSQL::CleanStringText($_POST['bookCorrelative']);
$visitorDUI=consultasSQL::CleanStringText($_POST['visitorDUI']);
$visitorName=consultasSQL::CleanStringText($_POST['visitorName']);
$visitorInstitution=consultasSQL::CleanStringText($_POST['visitorInstitution']);
$visitorPhone=consultasSQL::CleanStringText($_POST['visitorPhone']);
$startDate=consultasSQL::CleanStringText($_POST['startDate']);
$endDate=consultasSQL::CleanStringText($_POST['endDate']);
$loanState='Prestamo';
$checkLoans=ejecutarSQL::consultar("SELECT * FROM prestamo");
$totalLoans=mysqli_num_rows($checkLoans);
$numLoans=$totalLoans+1;
$codigo=""; 
$longitud=4; 
for ($i=1; $i<=$longitud; $i++){ 
    $numero = rand(0,9); 
    $codigo .= $numero; 
}
$loanCode="V".$visitorDUI."P".$numLoans."N".$codigo."";
$checkTotalsBooks=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$bookCode."'");
$dataBook=mysqli_fetch_array($checkTotalsBooks, MYSQLI_ASSOC);
$bookUnits=$dataBook['Prestado']+1;
$totalBL=$dataBook['Existencias']-($dataBook['Prestado']+1);
if($totalBL>0){
    $checkLoanVisitor=ejecutarSQL::consultar("SELECT * FROM prestamovisitante WHERE DUI='".$visitorDUI."'");
    $totalChecked=0;
    while($tmp=mysqli_fetch_array($checkLoanVisitor, MYSQLI_ASSOC)){
        $totalCheckedPending=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$tmp['CodigoPrestamo']."' AND Estado='Prestamo'");
        if(mysqli_num_rows($totalCheckedPending)>=1){ $totalChecked=$totalChecked+1; }
    }
    if($totalChecked<=0){
        if(!$startDate=="" && !$endDate==""){
            $firstDate=strtotime($startDate);
            $secondDate=strtotime($endDate);
            if($firstDate<$secondDate || $firstDate==$secondDate){
                $checkCorrelative=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CorrelativoLibro='".$bookCorrelative."' AND Estado='Prestamo' AND CodigoLibro='".$bookCode."'");
                if(mysqli_num_rows($checkCorrelative)<=0){
                    if(consultasSQL::InsertSQL("prestamo", "CodigoPrestamo,CodigoLibro,CorrelativoLibro,CodigoAdmin,FechaSalida,FechaEntrega,Estado", "'$loanCode','$bookCode','$bookCorrelative','$adminCode','$startDate','$endDate','$loanState'")){
                        if(consultasSQL::InsertSQL("prestamovisitante", "CodigoPrestamo,DUI,Institucion,Nombre,Telefono", "'$loanCode','$visitorDUI','$visitorInstitution','$visitorName','$visitorPhone'")){
                            if(consultasSQL::UpdateSQL("libro", "Prestado='$bookUnits'", "CodigoLibro='$bookCode'")){
                                echo '<script type="text/javascript">
                                    swal({ 
                                        title:"¡Préstamo realizado!", 
                                        text:"El préstamo se realizo con éxito", 
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
                                                window.open("report/fichaVN.php?loanCode='.$loanCode.'","_blank");
                                                window.location="infobook.php?codeBook='.$bookCode.'";
                                            } else {    
                                                window.location="infobook.php?codeBook='.$bookCode.'";
                                            } 
                                        });
                                    });
                                </script>'; 
                            }else{
                                consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='$loanCode'");
                                consultasSQL::DeleteSQL("prestamovisitante", "CodigoPrestamo='$loanCode'");
                                echo '<script type="text/javascript">
                                    swal({ 
                                        title:"¡Ocurrió un error inesperado!", 
                                        text:"No se pudo realizar el préstamo, por favor intenta de nuevo", 
                                        type: "error", 
                                        confirmButtonText: "Aceptar" 
                                    });
                                </script>';
                            }
                        }else{
                            consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='$loanCode'");
                            echo '<script type="text/javascript">
                                swal({ 
                                    title:"¡Ocurrió un error inesperado!", 
                                    text:"No se pudo realizar el préstamo, por favor intenta de nuevo", 
                                    type: "error", 
                                    confirmButtonText: "Aceptar" 
                                });
                            </script>';
                        }
                    }else{
                        echo '<script type="text/javascript">
                            swal({ 
                                title:"¡Ocurrió un error inesperado!", 
                                text:"No se pudo realizar el préstamo, por favor intenta de nuevo", 
                                type: "error", 
                                confirmButtonText: "Aceptar" 
                            });
                        </script>';
                    }
                }else{
                    echo '<script type="text/javascript">
                        swal({ 
                            title:"¡Ocurrió un error inesperado!", 
                            text:"El libro que corresponde al código correlativo que acabás de ingresar se encuentra en un préstamo vigente, por favor verifica e intenta nuevamente", 
                            type: "error", 
                            confirmButtonText: "Aceptar" 
                        });
                    </script>';
                }
            }else{
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Ocurrió un error inesperado!", 
                        text:"La fecha de solicitud no puede ser mayor que la fecha de entrega, verifica e intenta nuevamente", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"No puedes dejar los campos de fechas vacíos, por favor verifica e intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"El visitante tiene préstamos pendientes, por favor verifica e intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No hay libros disponibles para realizar el préstamo", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkLoans);
mysqli_free_result($checkTotalsBooks);
mysqli_free_result($checkLoanVisitor);
mysqli_free_result($totalCheckedPending);
mysqli_free_result($checkCorrelative);