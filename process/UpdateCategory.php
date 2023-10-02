<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$categoryCode=consultasSQL::CleanStringText($_POST['categoryCode']);
$categoryCodeOld=consultasSQL::CleanStringText($_POST['categoryCodeOld']);
$categoryName=consultasSQL::CleanStringText($_POST['categoryName']);
$categoryNameOld=consultasSQL::CleanStringText($_POST['categoryNameOld']);
if($categoryCodeOld==$categoryCode){
    if(consultasSQL::UpdateSQL("categoria", "Nombre='$categoryName'", "CodigoCategoria='$categoryCodeOld'")){
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Categoría actualizada!", 
                text:"Los datos de la categoría se actualizaron correctamente", 
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
                text:"No se pudo actualizar la categoría, por favor intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    if($categoryName==$categoryNameOld){
        $checkCategories1=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$categoryCode."'");
        if(mysqli_num_rows($checkCategories1)<=0){
            if(consultasSQL::UpdateSQL("categoria", "CodigoCategoria='$categoryCode'", "CodigoCategoria='$categoryCodeOld'")){
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Categoría actualizada!", 
                        text:"Los datos de la categoría se actualizaron correctamente", 
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
                        text:"No se pudo actualizar la categoría, por favor intenta nuevamente", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"El código de la categoría ya está registrado en el sistema, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }else{
        $checkCategories=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$categoryCode."' AND Nombre='".$categoryName."'");
        $checktotalCategories=mysqli_num_rows($checkCategories);
        $checkCategories2=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$categoryCode."'");
        $checktotalCategories2=mysqli_num_rows($checkCategories2);
        $checkCategories3=ejecutarSQL::consultar("SELECT * FROM categoria WHERE Nombre='".$categoryName."'");
        $checktotalCategories3=mysqli_num_rows($checkCategories3);
        if($checktotalCategories<=0 && $checktotalCategories2<=0 && $checktotalCategories3<=0){
            if(consultasSQL::UpdateSQL("categoria", "CodigoCategoria='$categoryCode',Nombre='$categoryName'", "CodigoCategoria='$categoryCodeOld'")){
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Categoría actualizada!", 
                        text:"Los datos de la categoría se actualizaron correctamente", 
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
                        text:"No hemos podido actualizar los datos de la categoría, por favor intenta nuevamente", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"El nombre o código que acabas de introducir ya está registrado, por favor verifica e intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';
        }
    }
}
mysqli_free_result($checkCategories);
mysqli_free_result($checkCategories1);
mysqli_free_result($checkCategories2);
mysqli_free_result($checkCategories3);