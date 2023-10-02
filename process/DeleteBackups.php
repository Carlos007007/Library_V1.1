<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$AdminCode=consultasSQL::CleanStringText($_POST['AdminCode']);
$adminUserName=consultasSQL::CleanStringText($_POST['adminUserName']);
$adminPassword=SED::encryption(consultasSQL::CleanStringText($_POST['adminPassword']));
$ruta=BACKUP_PATH;
$checkAdmin=ejecutarSQL::consultar("SELECT * FROM administrador WHERE NombreUsuario COLLATE latin1_bin='".$adminUserName."' AND Clave COLLATE latin1_bin='".$adminPassword."'");
$dataAdmin=mysqli_fetch_array($checkAdmin, MYSQLI_ASSOC);
if(mysqli_num_rows($checkAdmin)>=1 && $AdminCode==$dataAdmin['CodigoAdmin']){
    chmod(BACKUP_PATH, 0777);
    if(is_dir($ruta)){
        if($aux=opendir($ruta)){
            $Errors=0;
            while(($archivo=readdir($aux))!==false){
                if($archivo!="."&&$archivo!=".."){
                    $ruta_completa=$ruta.$archivo;
                    if(is_dir($ruta_completa)){
                    }else{
                        chmod($ruta_completa, 0777);
                        if(unlink($ruta_completa)){  
                        }else{
                            $Errors++;
                        }
                    }
                }
            }
            closedir($aux);
            if($Errors<=0){
                echo '<script type="text/javascript">
                    swal({ 
                        title:"¡Copias de seguridad eliminadas!", 
                        text:"Las copias de seguridad han sido eliminadas del sistema con éxito", 
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
                        text:"No hemos podido eliminar las copias de seguridad del sistema", 
                        type: "error", 
                        confirmButtonText: "Aceptar" 
                    });
                </script>';
            }
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No hemos podido abrir el directorio de las copias de seguridad", 
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