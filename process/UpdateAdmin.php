<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$codeAdmin=consultasSQL::CleanStringText($_POST['codeAdmin']);
$adminName=consultasSQL::CleanStringText($_POST['adminName']);
$adminUserName=consultasSQL::CleanStringText($_POST['adminUserName']);
$adminUserNameOld=consultasSQL::CleanStringText($_POST['adminUserNameOld']);
$adminMail=consultasSQL::CleanStringText($_POST['adminMail']);
$adminPassword1=consultasSQL::CleanStringText($_POST['adminPassword1']);
$adminPassword2=consultasSQL::CleanStringText($_POST['adminPassword2']);
$pass1=SED::encryption($adminPassword1);
if($adminPassword1!="" && $adminPassword2!=""){ $fields="Nombre='$adminName',NombreUsuario='$adminUserName',Clave='$pass1',Email='$adminMail'"; }else{ $fields="Nombre='$adminName',NombreUsuario='$adminUserName',Email='$adminMail'"; }
if($adminPassword1==$adminPassword2){
    if($adminUserNameOld==$adminUserName){
        $totalCheckUser=0;
    }else{
        $checkUserName=ejecutarSQL::consultar("SELECT * FROM administrador WHERE NombreUsuario='".$adminUserName."'");
        $totalCheckUser=mysqli_num_rows($checkUserName);
    }
    if($totalCheckUser<=0){
        if(consultasSQL::UpdateSQL("administrador", $fields, "CodigoAdmin='$codeAdmin'")){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Administrador actualizado!", 
                    text:"Los datos del administrador se actualizaron correctamente", 
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
                    text:"No hemos podido actualizar los datos del administrador, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"Has introducido un nombre de administrador que ya esta siendo utilizado, por favor ingresa otro nombre", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"Las contraseñas no coinciden, por favor verifica e intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkUserName);