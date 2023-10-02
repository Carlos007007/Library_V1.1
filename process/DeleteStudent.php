<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$primaryKey=consultasSQL::CleanStringText($_POST['primaryKey']);
$selectStu=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$primaryKey."'");
$dataStudent=mysqli_fetch_array($selectStu, MYSQLI_ASSOC);
$totalRepre=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE DUI='".$dataStudent['DUI']."'");
$NumRep=mysqli_num_rows($totalRepre);
$KeyRep=$dataStudent['DUI'];
$selectAllLoansS=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE NIE='".$primaryKey."'");
$totalP=0;
while($rowA=mysqli_fetch_array($selectAllLoansS, MYSQLI_ASSOC)){
    $seletLP=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$rowA['CodigoPrestamo']."' AND Estado='Prestamo'");
    if(mysqli_num_rows($seletLP)>0){
       $totalP=$totalP+1; 
    }
    mysqli_free_result($seletLP);
}
if($totalP<=0){
    $totalErrors=0;
    $selectAllLoansStud=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE NIE='".$primaryKey."'");
    while($dataAllLoans=mysqli_fetch_array($selectAllLoansStud, MYSQLI_ASSOC)){
        if(consultasSQL::DeleteSQL("prestamoestudiante", "CodigoPrestamo='".$dataAllLoans['CodigoPrestamo']."'")){
            if(consultasSQL::DeleteSQL("prestamo", "CodigoPrestamo='".$dataAllLoans['CodigoPrestamo']."'")){

            }else{
                $totalErrors=$totalErrors+1;
            }
        }else{
            $totalErrors=$totalErrors+1; 
        }   
    }
    if($totalErrors<=0){
            if(consultasSQL::DeleteSQL("bitacora", "CodigoUsuario='".$primaryKey."' AND Tipo='Estudiante'")){
                if(consultasSQL::DeleteSQL("estudiante", "NIE='".$primaryKey."'")){
                    if($NumRep>1){
                        echo '<script type="text/javascript">
                            swal({ 
                                title:"¡Estudiante eliminado!", 
                                text:"Todos los datos del estudiante y prestamos asociados han sido eliminados del sistema exitosamente", 
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
                        if(consultasSQL::DeleteSQL("encargado", "DUI='".$KeyRep."'")){
                            echo '<script type="text/javascript">
                                swal({ 
                                    title:"¡Estudiante eliminado!", 
                                    text:"Todos los datos del estudiante y prestamos asociados han sido eliminados del sistema exitosamente", 
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
                                    title:"¡Estudiante eliminado!", 
                                    text:"Los datos del estudiante han sido eliminados, sin embargo, algunos datos no pudieron ser eliminados del sistema", 
                                    type: "warning", 
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
                    } 
                }else{
                    echo '<script type="text/javascript">
                        swal({ 
                            title:"¡Ocurrió un error inesperado!", 
                            text:"No hemos podido eliminar los datos del estudiante, por favor intenta nuevamente", 
                            type: "error", 
                            confirmButtonText: "Aceptar" 
                        });
                    </script>';
                }
            }else{
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Ocurrió un error inesperado!", 
                        text:"No hemos podido eliminar los datos del estudiante, por favor intenta nuevamente", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No hemos podido eliminar los datos del estudiante, por favor intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>'; 
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"El estudiante tiene préstamos pendientes, no se pueden borrar los datos del estudiante mientras no devuelva los libros", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($selectStu);
mysqli_free_result($totalRepre);
mysqli_free_result($selectAllLoansStud);