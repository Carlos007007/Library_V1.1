<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$teachingDUI=consultasSQL::CleanStringText($_POST['teachingDUI']);
$teachingName=consultasSQL::CleanStringText($_POST['teachingName']);
$teachingSurname=consultasSQL::CleanStringText($_POST['teachingSurname']);
$teachingPhone=consultasSQL::CleanStringText($_POST['teachingPhone']);
$teachingSpecialty=consultasSQL::CleanStringText($_POST['teachingSpecialty']);
$teachingSection=consultasSQL::CleanStringText($_POST['teachingSection']);
$teachingTime=consultasSQL::CleanStringText($_POST['teachingTime']);
$UserName=consultasSQL::CleanStringText($_POST['UserName']);
$Password1=consultasSQL::CleanStringText($_POST['Password1']);
$Password2=consultasSQL::CleanStringText($_POST['Password2']);
if(!$teachingSection==""){
    $checkDUI=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$teachingDUI."'");
    if(mysqli_num_rows($checkDUI)<=0){
        if($Password1==$Password2){
            $checkUserName=ejecutarSQL::consultar("SELECT * FROM docente WHERE NombreUsuario='".$UserName."'");
            if(mysqli_num_rows($checkUserName)<=0){
                $Password1=SED::encryption($Password1);
                if(consultasSQL::InsertSQL("docente", "DUI, CodigoSeccion, Nombre, NombreUsuario, Clave, Apellido, Telefono, Especialidad, Jornada", "'$teachingDUI','$teachingSection','$teachingName', '$UserName', '$Password1','$teachingSurname','$teachingPhone','$teachingSpecialty','$teachingTime'")){ 
                    echo '<script type="text/javascript">
                        swal({
                           title:"¡Docente registrado!",
                           text:"Los datos del docente se almacenaron exitosamente",
                           type: "success",
                           confirmButtonText: "Aceptar"
                        });
                        $(".form_SRCB")[0].reset();
                    </script>';
                }else{
                    echo '<script type="text/javascript">
                        swal({ 
                            title:"¡Ocurrió un error inesperado!", 
                            text:"No se pudo registrar el docente, por favor intenta nuevamente", 
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
                text:"Este número de DUI está asociado a un docente registrado en el sistema, verifícalo e intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>'; 
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"No has seleccionado una sección válida o no has registrado secciones, verifica e intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>'; 
}
mysqli_free_result($checkDUI);
mysqli_free_result($checkUserName);