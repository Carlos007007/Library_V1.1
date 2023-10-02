<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeCategory=consultasSQL::CleanStringText($_POST['code']);
$selectCategory=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$codeCategory."'");
$dataCategory=mysqli_fetch_array($selectCategory, MYSQLI_ASSOC);
if(mysqli_num_rows($selectCategory)>=1){
    echo '
    <legend><strong>Información de la categoría</strong></legend><br>
    <input type="hidden" value="'.$dataCategory['CodigoCategoria'].'" name="categoryCodeOld">
    <input type="hidden" value="'.$dataCategory['Nombre'].'" name="categoryNameOld">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataCategory['CodigoCategoria'].'" name="categoryCode" required="" pattern="[0-9]{1,20}" maxlength="20" data-toggle="tooltip" data-placement="top" title="Solo números, máximo 20 caracteres">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Código de categoría</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataCategory['Nombre'].'" name="categoryName" required="" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre de la categoría">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre</label>
    </div>
    ';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectCategory);