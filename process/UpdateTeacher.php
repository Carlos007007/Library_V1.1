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
$UserNameOld=consultasSQL::CleanStringText($_POST['UserNameOld']);
$Password1=consultasSQL::CleanStringText($_POST['Password1']);
$Password2=consultasSQL::CleanStringText($_POST['Password2']);
$FinalPassword=SED::encryption($Password1);
if($Password1!="" && $Password2!=""){ $fields="CodigoSeccion='$teachingSection',Nombre='$teachingName',NombreUsuario='$UserName',Clave='$FinalPassword',Apellido='$teachingSurname',Telefono='$teachingPhone',Especialidad='$teachingSpecialty',Jornada='$teachingTime'"; }else{ $fields="CodigoSeccion='$teachingSection',Nombre='$teachingName',Apellido='$teachingSurname', NombreUsuario='$UserName', Telefono='$teachingPhone',Especialidad='$teachingSpecialty',Jornada='$teachingTime'"; }
if($Password1==$Password2){
    if($UserNameOld==$UserName){
        $totalCheckUser=0;
    }else{
        $checkUserName=ejecutarSQL::consultar("SELECT * FROM docente WHERE NombreUsuario='".$UserName."'");
        $totalCheckUser=mysqli_num_rows($checkUserName);
    }
    if($totalCheckUser<=0){
        if(consultasSQL::UpdateSQL("docente", $fields, "DUI='".$teachingDUI."'")){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Docente actualizado!", 
                    text:"Los datos del docente se actualizaron correctamente, recuerda que si cambiaste la sección encargada del docente los estudiantes de la sección anterior no tendrán encargado y deberás asignarle uno.", 
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
                    text:"No hemos podido actualizar los datos del docente, por favor intenta nuevamente", 
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