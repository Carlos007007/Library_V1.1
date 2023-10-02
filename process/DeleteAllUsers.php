<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$AdminCode=consultasSQL::CleanStringText($_POST['AdminCode']);
$adminUserName=consultasSQL::CleanStringText($_POST['adminUserName']);
$adminPassword=SED::encryption(consultasSQL::CleanStringText($_POST['adminPassword']));
$userType=consultasSQL::CleanStringText($_GET['userType']);
if($userType=="Teacher"){
    $tableUser="docente";
    $tableUserLoans="prestamodocente";
    $bitacoraUser="Docente";
    $textAlertError="los docentes";
    $textAlertSuccess="Todos los docentes han sido eliminados del sistema";
    $titleAlert="Docentes eliminados";
}else if($userType=="Student"){
    $tableUser="estudiante";
    $tableUserLoans="prestamoestudiante";
    $bitacoraUser="Estudiante";
    $textAlertError="los estudiantes";
    $textAlertSuccess="Todos los estudiantes han sido eliminados del sistema";
    $titleAlert="Estudiantes eliminados";
}else if($userType=="Personal"){
    $tableUser="personal";
    $tableUserLoans="prestamopersonal";
    $bitacoraUser="Personal";
    $textAlertError="el personal administrativo";
    $textAlertSuccess="Todo el personal administrativo ha sido eliminado del sistema";
    $titleAlert="Personal eliminado";
}
$checkAdmin=ejecutarSQL::consultar("SELECT * FROM administrador WHERE NombreUsuario COLLATE latin1_bin='".$adminUserName."' AND Clave COLLATE latin1_bin='".$adminPassword."'");
$dataAdmin=mysqli_fetch_array($checkAdmin, MYSQLI_ASSOC);
if(mysqli_num_rows($checkAdmin)>=1 && $AdminCode==$dataAdmin['CodigoAdmin']){
    $checkLoans=ejecutarSQL::consultar("SELECT * FROM ".$tableUserLoans."");
    if(mysqli_num_rows($checkLoans)<=0){
        $con1="DELETE FROM ".$tableUser."";
        $con2="DELETE FROM bitacora WHERE Tipo='".$bitacoraUser."'";
        if(ejecutarSQL::consultar($con1) && ejecutarSQL::consultar($con2)){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡'.$titleAlert.'!", 
                    text:"'.$textAlertSuccess.'", 
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
                    text:"No hemos podido eliminar '.$textAlertError.' del sistema, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No podemos eliminar '.$textAlertError.', debes eliminar todos los préstamos para realizar la operación", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"El nombre de usuario o contraseña son incorrectos", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkAdmin);
mysqli_free_result($checkLoans);