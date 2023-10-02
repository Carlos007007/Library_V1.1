<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$categoryCode=consultasSQL::CleanStringText($_POST['categoryCode']);
$categoryName=consultasSQL::CleanStringText($_POST['categoryName']);
$checkCategory=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$categoryCode."'");
if(mysqli_num_rows($checkCategory)<=0){
    $checkname=ejecutarSQL::consultar("SELECT * FROM categoria WHERE Nombre='".$categoryName."'");
    if(mysqli_num_rows($checkname)<=0){
        if(consultasSQL::InsertSQL("categoria", "CodigoCategoria, Nombre", "'$categoryCode','$categoryName'")){
            echo '<script type="text/javascript">
                swal({
                   title:"¡Categoría registrada!",
                   text:"Los datos de la categoría se almacenaron correctamente",
                   type: "success",
                   confirmButtonText: "Aceptar"
                });
                $(".form_SRCB")[0].reset();
            </script>';
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"No se pudo registrar la categoría, por favor intente nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"El nombre ingresado ya existe, escribe otro nombre e intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }   
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"El código ingresado ya existe, escribe otro código e intenta nuevamente", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>'; 
}
mysqli_free_result($checkCategory);
mysqli_free_result($checkname);