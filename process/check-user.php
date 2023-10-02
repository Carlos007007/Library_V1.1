<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$userName=consultasSQL::CleanStringText($_GET['userName']);
$userType=consultasSQL::CleanStringText($_GET['userType']);
if($userType=="Admin"){ $consult="SELECT * FROM administrador WHERE NombreUsuario='".$userName."'"; }
if($userType=="Teacher"){ $consult="SELECT * FROM docente WHERE NombreUsuario='".$userName."'"; }
if($userType=="Student"){ $consult="SELECT * FROM estudiante WHERE NombreUsuario='".$userName."'"; }
if($userType=="Personal"){ $consult="SELECT * FROM personal WHERE NombreUsuario='".$userName."'"; }
$checkBDUser=ejecutarSQL::consultar($consult);
if(mysqli_num_rows($checkBDUser)>0){
    echo '<p class="control-label" style="margin-top:15px; color:red; font-size: 16px; "><i class="zmdi zmdi-alert-triangle"></i> &nbsp; Este nombre de usuario ya está siendo utilizado, por favor elige otro</p>';
}
mysqli_free_result($checkBDUser);