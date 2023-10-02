<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$AdminCode=consultasSQL::CleanStringText($_POST['AdminCode']);
$restorePoint=consultasSQL::CleanStringText($_POST['restorePoint']);
$adminUserName=consultasSQL::CleanStringText($_POST['adminUserName']);
$adminPassword=SED::encryption(consultasSQL::CleanStringText($_POST['adminPassword']));
if($restorePoint!=""){
    $checkAdmin=ejecutarSQL::consultar("SELECT * FROM administrador WHERE NombreUsuario COLLATE latin1_bin='".$adminUserName."' AND Clave COLLATE latin1_bin='".$adminPassword."'");
    $dataAdmin=mysqli_fetch_array($checkAdmin, MYSQLI_ASSOC);
    if(mysqli_num_rows($checkAdmin)>=1 && $AdminCode==$dataAdmin['CodigoAdmin']){
        $sql=explode(";",file_get_contents($restorePoint));
        $totalErrors=0;
        set_time_limit (60);
        $con=mysqli_connect(SERVER, USER, PASS, BD);
        $con->query("SET FOREIGN_KEY_CHECKS=0");
        for($i = 0; $i < (count($sql)-1); $i++){
            if($con->query("$sql[$i];")){  }else{ $totalErrors++; }
        }
        $con->query("SET FOREIGN_KEY_CHECKS=0");
        $con->close();
        if($totalErrors<=0){
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Sistema restaurado!", 
                    text:"El sistema se restauró con éxito, debemos cerrar la sesión actual para terminar el proceso", 
                    type: "success", 
                    confirmButtonText: "Aceptar" 
                },
                function(isConfirm){  
                    if (isConfirm) {     
                        window.location="../process/logoutRestore.php";
                    } else {    
                        window.location="../process/logoutRestore.php";
                    } 
                });
            </script>';
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"Ocurrió un error al tratar de restaurar el sistema, por favor intenta nuevamente", 
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
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"Debes de seleccionar un punto de restauración", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysql_free_result($checkAdmin);