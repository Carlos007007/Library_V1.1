<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$CDB=ejecutarSQL::consultar("SELECT * FROM libro");
if(mysqli_num_rows($CDB)>=1){
    echo 'Avaliable';
}else{
    echo 'NotAvaliable';
}
mysqli_free_result($CDB);