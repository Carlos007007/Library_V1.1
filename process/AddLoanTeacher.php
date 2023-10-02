<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$bookCode=consultasSQL::CleanStringText($_POST['bookCode']);
$bookCorrelative=consultasSQL::CleanStringText($_POST['bookCorrelative']);
$userKey=consultasSQL::CleanStringText($_POST['userKey']);
$adminCode=consultasSQL::CleanStringText($_POST['adminCode']);
$userType=consultasSQL::CleanStringText($_POST['userType']);
$startDate=consultasSQL::CleanStringText($_POST['startDate']);
$endDate=consultasSQL::CleanStringText($_POST['endDate']);
$CantL=consultasSQL::CleanStringText($_POST['CantL']);
$tableUser="docente";
$tableLoan="prestamodocente";
$userField="DUI";
$userLoanFile="fichaDN";
$msj3='No se ha registrado ningún docente con número de '.$userField.' '.$userKey.'';
if($userType=="Teacher"){
    $msj="La reservación se realizó con éxito, por favor espera a que sea aprobada por la bibliotecaria";
    $title1="Reservación realizada";
    $loanState='Reservacion';
    $msj2="No puedes realizar préstamos ni reservaciones por el momento. Tienes préstamos o reservaciones pendientes, entrega los libros que has prestado o cancela las reservaciones. Si tienes problemas ponte en contacto con el/la bibliotecario/a";
    $msj4="Haz excedido el número de libros permitido o no hay suficientes libros disponibles por el momento, por favor verifique el máximo permitido";
}
if($userType=="Admin"){
    $loanState='Prestamo';
    $msj="El préstamo se realizo con éxito";
    $title1="Préstamo realizado";
    $msj2="El usuario tiene préstamos pendientes o reservaciones que no han sido aprobadas, verifica e intenta nuevamente";
    $msj4="No hay libros disponibles con la cantidad especificada para poder realizar el préstamo. Recuerda que debes de dejar un ejemplar en la biblioteca";
    $ct=0;
    foreach($_POST['bookCorrelative'] as $codeTemp){
        if($codeTemp!=""){
            if($ct<=0){
            $finalcorrelative=$finalcorrelative.$codeTemp;
        }else{
            $finalcorrelative=$finalcorrelative.','.$codeTemp;
        }
        $ct++;
        }
    }
}
$checkLoans=ejecutarSQL::consultar("SELECT * FROM prestamo");
$totalLoans=mysqli_num_rows($checkLoans);
$numLoans=$totalLoans+1;
$codigo=""; 
$longitud=4; 
for ($i=1; $i<=$longitud; $i++){ 
    $numero = rand(0,9); 
    $codigo .= $numero; 
}
$loanCode="U".$userKey."P".$numLoans."N".$codigo."";
$checkTotalsBooks=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$bookCode."'");
$dataBook=mysqli_fetch_array($checkTotalsBooks, MYSQLI_ASSOC);
$bookUnits=$dataBook['Prestado']+$CantL;
$totalBL=($dataBook['Existencias'])-($dataBook['Prestado']+$CantL);
if($totalBL>0){
    $checkUsers=ejecutarSQL::consultar("SELECT * FROM ".$tableUser." WHERE ".$userField."='".$userKey."'");
    if(mysqli_num_rows($checkUsers)>=1){
        $checkLoanUsers=ejecutarSQL::consultar("SELECT * FROM ".$tableLoan." WHERE ".$userField."='".$userKey."'");
        $totalChecked=0;
        while($tmp=mysqli_fetch_array($checkLoanUsers, MYSQLI_ASSOC)){
            $totalCheckedPending=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$tmp['CodigoPrestamo']."' AND Estado='Prestamo'");
            if(mysqli_num_rows($totalCheckedPending)>=1){
                $totalChecked=$totalChecked+1;
            }
        }
        $checkLoanUsers2=ejecutarSQL::consultar("SELECT * FROM ".$tableLoan." WHERE ".$userField."='".$userKey."'");
        $totalChecked2=0;
        while($tmp2=mysqli_fetch_array($checkLoanUsers2, MYSQLI_ASSOC)){
            $totalCheckedPending2=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$tmp2['CodigoPrestamo']."' and Estado='Reservacion'");
            if(mysqli_num_rows($totalCheckedPending2)>=1){
                $totalChecked2=$totalChecked2+1;
            }
        }
        if($totalChecked<=0 && $totalChecked2<=0){
            if(!$startDate=="" && !$endDate==""){
                $firstDate=strtotime($startDate);
                $secondDate=strtotime($endDate);
                if($firstDate<$secondDate || $firstDate==$secondDate){
                    if(consultasSQL::InsertSQL("prestamo", "CodigoPrestamo,CodigoLibro,CorrelativoLibro,CodigoAdmin,FechaSalida,FechaEntrega,Estado", "'$loanCode','$bookCode','$finalcorrelative','$adminCode','$startDate','$endDate','$loanState'")){
                        if(consultasSQL::InsertSQL("$tableLoan", "CodigoPrestamo,".$userField.",Cantidad", "'$loanCode','$userKey','$CantL'")){
                            if($loanState=="Prestamo"){
                                if(consultasSQL::UpdateSQL("libro", "Prestado='$bookUnits'", "CodigoLibro='$bookCode'")){
                                    echo '<script type="text/javascript">
                                        swal({ 
                                            title:"¡'.$title1.'!", 
                                            text:"'.$msj.'", 
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
                                                    window.open("report/'.$userLoanFile.'.php?loanCode='.$loanCode.'","_blank");
                                                    window.location="infobook.php?codeBook='.$bookCode.'";
                                                } else {    
                                                    window.location="infobook.php?codeBook='.$bookCode.'";
                                                } 
                                            });
                                        });
                                    </script>';
                                }else{
                                    consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='$loanCode'");
                                    consultasSQL::DeleteSQL("$tableLoan", "CodigoPrestamo='$loanCode'");
                                    echo '<script type="text/javascript">
                                        swal({ 
                                            title:"¡Ocurrió un error inesperado!", 
                                            text:"No se pudo realizar el préstamo, por favor intenta nuevamente", 
                                            type: "error", 
                                            confirmButtonText: "Aceptar" 
                                        });
                                    </script>';
                                }
                            }else{
                                echo '<script type="text/javascript">
                                    swal({ 
                                        title:"¡'.$title1.'!", 
                                        text:"'.$msj.'", 
                                        type: "success", 
                                        confirmButtonText: "Aceptar" 
                                    },
                                    function(isConfirm){  
                                        if (isConfirm) {     
                                            window.location="infobook.php?codeBook='.$bookCode.'";
                                        } else {    
                                            window.location="infobook.php?codeBook='.$bookCode.'";
                                        } 
                                    });
                                </script>';
                            }
                        }else{
                            consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='$loanCode'");
                            echo '<script type="text/javascript">
                                swal({ 
                                    title:"¡Ocurrió un error inesperado!", 
                                    text:"No se pudo realizar el préstamo, por favor intenta nuevamente", 
                                    type: "error", 
                                    confirmButtonText: "Aceptar" 
                                });
                            </script>';
                        }
                    }else{
                        echo '<script type="text/javascript">
                            swal({ 
                                title:"¡Ocurrió un error inesperado!", 
                                text:"No se pudo realizar el préstamo, por favor intenta nuevamente", 
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
                    text:"'.$msj2.'", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"'.$msj3.'", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"'.$msj4.'", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkLoans);
mysqli_free_result($checkTotalsBooks);
mysqli_free_result($checkUsers);
mysqli_free_result($totalCheckedPending);
mysqli_free_result($totalCheckedPending2);