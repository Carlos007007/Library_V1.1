<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution, MYSQLI_ASSOC);
$selAllL=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Entregado'");
$Total=0;
while($dat=mysqli_fetch_array($selAllL, MYSQLI_ASSOC)){
    $SYear=date("Y",strtotime($dat['FechaSalida']));
    if($dataInstitution['Year']==$SYear){
        $Total++;
    }
}
if($Total>=1){
    echo 'Avaliable';
}else{
    echo 'NotAvaliable';
}
mysqli_free_result($selAllL);