<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$adminName=consultasSQL::CleanStringText($_POST['adminName']);
$adminUserName=consultasSQL::CleanStringText($_POST['adminUserName']);
$adminMail=consultasSQL::CleanStringText($_POST['adminMail']);
$adminPassword1=consultasSQL::CleanStringText($_POST['adminPassword1']);
$adminPassword2=consultasSQL::CleanStringText($_POST['adminPassword2']);
$adminState="Activo";
$checkAdmin=ejecutarSQL::consultar("SELECT * FROM administrador");
$checktotal=mysqli_num_rows($checkAdmin);
$numA=$checktotal+1;
$checInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataIns=mysqli_fetch_array($checInstitution, MYSQLI_ASSOC);
$codigo=""; 
$longitud=4; 
for ($i=1; $i<=$longitud; $i++){ 
    $numero = rand(0,9); 
    $codigo .= $numero; 
}
$admminCode="I".$dataIns['CodigoInfraestructura']."Y".$dataIns['Year']."A".$numA."N".$codigo."";
if(mysqli_num_rows($checInstitution)>=1){
    if($adminPassword1==$adminPassword2){
        $checkUserName=ejecutarSQL::consultar("SELECT * FROM administrador WHERE NombreUsuario='".$adminUserName."'");
        $checkUsertotal=mysqli_num_rows($checkUserName);
        if($checkUsertotal<=0){
            $adminPassword1=SED::encryption($adminPassword1);
           if(consultasSQL::InsertSQL("administrador", "CodigoAdmin,Estado,Nombre,NombreUsuario,Clave,Email", "'$admminCode','$adminState','$adminName','$adminUserName','$adminPassword1','$adminMail'")){
                echo '<script type="text/javascript">
                    swal({
                       title:"¡Administrador registrado!",
                       text:"Los datos del administrador se almacenaron correctamente",
                       type: "success",
                       confirmButtonText: "Aceptar"
                    });
                    $(".form_SRCB")[0].reset();
                </script>'; 
           }else{
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Ocurrió un error inesperado!", 
                        text:"No se pudo registrar el administrador, por favor intente nuevamente", 
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
            text:"Primero debes de registrar los datos de la institución, ve a la opción Administración y luego a Datos Institución", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checInstitution);
mysqli_free_result($checkAdmin);
mysqli_free_result($checkUserName);