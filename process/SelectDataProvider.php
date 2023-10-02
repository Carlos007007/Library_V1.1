<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeProvider=consultasSQL::CleanStringText($_POST['code']);
$selectProvider=ejecutarSQL::consultar("SELECT * FROM proveedor WHERE CodigoProveedor='".$codeProvider."'");
$dataProvider=mysqli_fetch_array($selectProvider, MYSQLI_ASSOC);
if(mysqli_num_rows($selectProvider)>=1){
    echo '
    <legend><strong>Información del proveedor</strong></legend><br>
    <input type="hidden" value="'.$dataProvider['CodigoProveedor'].'" name="providerCode">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataProvider['Nombre'].'" name="providerName" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del proveedor">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre del proveedor</label>
    </div>
    <div class="group-material">
        <input type="email" class="material-control tooltips-general" value="'.$dataProvider['Email'].'" name="providerEmail" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el Email del proveedor">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Email</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataProvider['Direccion'].'" name="providerAddres" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe la dirección del proveedor">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Dirección</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataProvider['Telefono'].'" name="providerPhone" required="" pattern="[0-9]{8,8}" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solo números, mínimo 8 dígitos">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Teléfono</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataProvider['ResponAtencion'].'" name="providerResponsible" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Responsable de atención">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Responsable de atención</label>
    </div>';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectProvider);