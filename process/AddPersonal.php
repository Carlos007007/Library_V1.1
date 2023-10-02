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
$Password1=consultasSQL::CleanStringText($_POST['Password1']);
$Password2=consultasSQL::CleanStringText($_POST['Password2']);
$checkDUI=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$personalDUI."'");
if(mysqli_num_rows($checkDUI)<=0){
    if($Password1==$Password2){
        $checkUserName=ejecutarSQL::consultar("SELECT * FROM personal WHERE NombreUsuario='".$UserName."'");
        if(mysqli_num_rows($checkUserName)<=0){
            $Password1=SED::encryption($Password1);
            if(consultasSQL::InsertSQL("personal", "DUI, Nombre, NombreUsuario, Clave, Apellido, Telefono, Cargo", "'$personalDUI','$personalName','$UserName','$Password1','$personalSurname','$personalPhone','$personalPosition'")){ 
                echo '<script type="text/javascript">
                    swal({
                       title:"¡Personal admin. registrado!",
                       text:"Los datos del personal administrativo se almacenaron exitosamente",
                       type: "success",
                       confirmButtonText: "Aceptar"
                    });
                    $(".form_SRCB")[0].reset();
                </script>';
            }else{
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Ocurrió un error inesperado!", 
                        text:"No se pudo registrar personal administrativo, por favor intenta nuevamente", 
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
                text:"Las contraseñas no coinciden. Por favor ingresa nuevamente las contraseñas", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"Este número de DUI está asociado con otro personal administrativo registrado en el sistema, verifícalo e intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>'; 
}
mysqli_free_result($checkDUI);
mysqli_free_result($checkUserName);