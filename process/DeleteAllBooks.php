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
    $checkLoans=ejecutarSQL::consultar("SELECT * FROM prestamo");
    if(mysqli_num_rows($checkLoans)<=0){
        if(ejecutarSQL::consultar("DELETE FROM libro")){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Libros eliminados!", 
                    text:"Todos los libros han sido eliminados del sistema satisfactoriamente", 
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
                    text:"No hemos podido eliminar los libros del sistema, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No podemos eliminar los libros, debes eliminar todos los préstamos para realizar la operación", 
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