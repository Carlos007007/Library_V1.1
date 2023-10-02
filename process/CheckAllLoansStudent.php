<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$selAllLS=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante");
if(mysqli_num_rows($selAllLS)>=1){
    echo 'Avaliable';
}else{
    echo 'NotAvaliable';
}
mysqli_free_result($selAllLS);