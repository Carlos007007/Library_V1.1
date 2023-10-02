<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$institutionCode=consultasSQL::CleanStringText($_POST['institutionCode']);
$institutionName=consultasSQL::CleanStringText($_POST['institutionName']);
$institutionNameDirector=consultasSQL::CleanStringText($_POST['institutionDirector']);
$institutionNameLibrarian=consultasSQL::CleanStringText($_POST['institutionLibrarian']);
$institutionDistrict=consultasSQL::CleanStringText($_POST['institutionDistrict']);
$institutionPhone=consultasSQL::CleanStringText($_POST['institutionPhone']);
$institutionYear=consultasSQL::CleanStringText($_POST['institutionYear']);
$checkInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
if(mysqli_num_rows($checkInstitution)<=0){
    if(consultasSQL::InsertSQL("institucion", "CodigoInfraestructura, Nombre, NombreDirector, NombreBibliotecario, Distrito, Telefono, Year", "'$institutionCode','$institutionName','$institutionNameDirector','$institutionNameLibrarian','$institutionDistrict','$institutionPhone','$institutionYear'")){
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Institución registrada!", 
                text:"Los datos de la institución se almacenaron correctamente", 
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
    }
    else{
        echo '<script type="text/javascript">
            swal({
              title:"¡Ocurrió un error inesperado!",
               text:"No se pudo registrar los datos de la institución, por favor intente nuevamente",
               type: "error",
               confirmButtonText: "Aceptar"
                   });
        </script>';
    }
}
else{
    echo '<script type="text/javascript">
        swal({
          title:"¡Ocurrió un error inesperado!",
           text:"Solo puedes registrar una vez tu institución. Puedes actualizar los datos actuales, o eliminar el registro e intentar nuevamente",
           type: "error",
           confirmButtonText: "Aceptar"
               });
    </script>';
}
mysqli_free_result($checkInstitution);