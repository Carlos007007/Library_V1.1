<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$CDI=ejecutarSQL::consultar("SELECT * FROM institucion");
$CDP=ejecutarSQL::consultar("SELECT * FROM proveedor");
$CDC=ejecutarSQL::consultar("SELECT * FROM categoria");
if(mysqli_num_rows($CDI)>=1 && mysqli_num_rows($CDP)>=1 && mysqli_num_rows($CDC)>=1){
    echo 'Avaliable';
}else{
    echo 'NotAvaliable';
}
mysqli_free_result($CDI);
mysqli_free_result($CDP);
mysqli_free_result($CDC);