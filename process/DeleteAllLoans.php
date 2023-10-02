<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$AdminCode=consultasSQL::CleanStringText($_POST['AdminCode']);
$adminUserName=consultasSQL::CleanStringText($_POST['adminUserName']);
$adminPassword=SED::encryption(consultasSQL::CleanStringText($_POST['adminPassword']));
$checkAdmin=ejecutarSQL::consultar("SELECT * FROM administrador WHERE NombreUsuario COLLATE latin1_bin='".$adminUserName."' AND Clave COLLATE latin1_bin='".$adminPassword."'");
$dataAdmin=mysqli_fetch_array($checkAdmin, MYSQLI_ASSOC);
if(mysqli_num_rows($checkAdmin)>=1 && $AdminCode==$dataAdmin['CodigoAdmin']){
    $con1="DELETE FROM prestamodocente";
    $con2="DELETE FROM prestamoestudiante";
    $con3="DELETE FROM prestamopersonal";
    $con4="DELETE FROM prestamovisitante";
    if(ejecutarSQL::consultar($con1) && ejecutarSQL::consultar($con2) && ejecutarSQL::consultar($con3) && ejecutarSQL::consultar($con4)){
        if(ejecutarSQL::consultar("DELETE FROM prestamo")){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Préstamos eliminados!", 
                    text:"Todos los préstamos han sido eliminados satisfactoriamente", 
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
                    text:"No hemos podido eliminar los préstamos, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No hemos podido eliminar los préstamos, por favor intenta nuevamente", 
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