<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$personalDUI=consultasSQL::CleanStringText($_POST['personalDUI']);
$personalName=consultasSQL::CleanStringText($_POST['personalName']);
$personalSurname=consultasSQL::CleanStringText($_POST['personalSurname']);
$personalPhone=consultasSQL::CleanStringText($_POST['personalPhone']);
$personalPosition=consultasSQL::CleanStringText($_POST['personalPosition']);
$UserName=consultasSQL::CleanStringText($_POST['UserName']);
$UserNameOld=consultasSQL::CleanStringText($_POST['UserNameOld']);
$Password1=consultasSQL::CleanStringText($_POST['Password1']);
$Password2=consultasSQL::CleanStringText($_POST['Password2']);
$FinalPassword=SED::encryption($Password1);
if($Password1!="" && $Password2!=""){ $fields="Nombre='$personalName',NombreUsuario='$UserName',Clave='$FinalPassword',Apellido='$personalSurname',Telefono='$personalPhone',Cargo='$personalPosition'"; }else{ $fields="Nombre='$personalName',NombreUsuario='$UserName',Apellido='$personalSurname',Telefono='$personalPhone',Cargo='$personalPosition'"; }
if($Password1==$Password2){
    if($UserNameOld==$UserName){
        $totalCheckUser=0;
    }else{
        $checkUserName=ejecutarSQL::consultar("SELECT * FROM personal WHERE NombreUsuario='".$UserName."'");
        $totalCheckUser=mysqli_num_rows($checkUserName);
    }
    if($totalCheckUser<=0){
        if(consultasSQL::UpdateSQL("personal",$fields,"DUI='".$personalDUI."'")){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Personal administrativo actualizado!", 
                    text:"Los datos del personal administrativo se actualizaron correctamente", 
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
                    text:"No hemos podido actualizar los datos del personal administrativo, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"Has introducido un nombre de usuario que ya esta siendo utilizado, por favor ingresa otro nombre", 
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