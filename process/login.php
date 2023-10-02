<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SED.php';
$UserType=consultasSQL::CleanStringText($_POST['UserType']);
$loginName=consultasSQL::CleanStringText($_POST['loginName']);
$loginPassword=consultasSQL::CleanStringText($_POST['loginPassword']);
$fecha=date("d-m-Y");
$hora=date("H:i:s");
$pass=SED::encryption($loginPassword);
if($UserType=="Student"){
    $key="NIE";
    $table="estudiante";
    $userN="Estudiante";
}
if($UserType=="Teacher"){
    $key="DUI";
    $table="docente";
    $userN="Docente";
}
if($UserType=="Personal"){
    $key="DUI";
    $table="personal";
    $userN="Personal";
}
if($UserType=="Student" || $UserType=="Teacher" || $UserType=="Personal"){
    $consult="SELECT * FROM ".$table." WHERE NombreUsuario COLLATE latin1_bin='$loginName' AND Clave COLLATE latin1_bin='$pass'";
    $urlLocation='<script type="text/javascript"> window.location="catalog.php"; </script>';
}
if($UserType=="Admin"){
    $key="CodigoAdmin";
    $userN="Administrador";
    $consult="SELECT * FROM administrador WHERE NombreUsuario COLLATE latin1_bin='$loginName' AND Clave COLLATE latin1_bin='$pass' AND Estado='Activo'";
    $urlLocation='<script type="text/javascript"> window.location="home.php"; </script>';
}
if($UserType!=""){
    $checkUser=ejecutarSQL::consultar($consult);
    $fila=mysqli_fetch_array($checkUser, MYSQLI_ASSOC);
    if(mysqli_num_rows($checkUser)>0){
        $selectBit=ejecutarSQL::consultar("SELECT * FROM bitacora");
        $total=mysqli_num_rows($selectBit)+1;
        $longitud=4; 
        for ($i=1; $i<=$longitud; $i++){ 
            $numero = rand(0,9); 
            $codigo .= $numero; 
        }
        mysqli_free_result($selectBit);
        $codeBit="UK".$fila[$key]."N".$codigo."-".$total."";
        if(consultasSQL::InsertSQL("bitacora", "Codigo,CodigoUsuario,Tipo,Fecha,Entrada,Salida", "'".$codeBit."','".$fila[$key]."','$userN','$fecha','$hora','Sin registrar'")){
            $_SESSION['UserName']=$fila['NombreUsuario'];
            $_SESSION['UserPrivilege']=$UserType;
            $_SESSION['primaryKey']=$fila[$key];
            $_SESSION['codeBit']=$codeBit;
            $_SESSION['SessionToken']=md5(uniqid(mt_rand(), true));
            if($UserType=="Admin"){
                $_SESSION['CheckConfig']='unrevised';
            }
            echo $urlLocation;
        }else{
            echo '<script type="text/javascript">
                swal({ 
                    title:"¡Ocurrió un error inesperado!", 
                    text:"No se pudo iniciar la sesión, por favor intenta nuevamente", 
                    type: "error", 
                    confirmButtonText: "Aceptar" 
                });
            </script>';   
        }
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Datos invalidos o cuenta desactivada!", 
                text:"Verifique sus datos e intente nuevamente, o póngase en contacto con el administrador de la biblioteca", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"Selecciona el tipo de usuario", 
            text:"Debes de seleccionar el tipo de usuario para iniciar sesión en el sistema", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkUser);