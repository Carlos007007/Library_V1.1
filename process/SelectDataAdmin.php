<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeAdmin=consultasSQL::CleanStringText($_POST['code']);
$selectAdmin=ejecutarSQL::consultar("SELECT * FROM administrador WHERE CodigoAdmin='$codeAdmin'");
$dataAdmin=mysqli_fetch_array($selectAdmin, MYSQLI_ASSOC);
if(mysqli_num_rows($selectAdmin)>=1){
    echo '
    <legend><strong>Información del administrador</strong></legend><br>
    <input type="hidden" value="'.$dataAdmin["CodigoAdmin"].'" name="codeAdmin">
    <div class="group-material"> 
    <input type="text" class="material-control tooltips-general" value="'.$dataAdmin["Nombre"].'" name="adminName" required="" maxlength="70" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del administrador">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre completo</label>
    </div>
    <input type="hidden" value="'.$dataAdmin["NombreUsuario"].'" name="adminUserNameOld" >
    <div class="group-material">
        <input type="text" class="material-control tooltips-general input-check-user2" value="'.$dataAdmin["NombreUsuario"].'" name="adminUserName" data-user="Admin" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}" data-toggle="tooltip" data-placement="top" title="Escribe un nombre de usuario sin espacios, que servira para iniciar sesión">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre de usuario</label>
        <div class="check-user-bd2"></div>
    </div>
    <div class="group-material">
        <input type="email" class="material-control tooltips-general" value="'.$dataAdmin["Email"].'" name="adminMail" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el Email del administrador">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Email</label>
    </div>
    <legend><strong>Cambio de contraseña</strong></legend>
    <p><strong>No es necesario cambiar la contraseña, sin embargo, si quieres cambiarla deberás de llenar los siguientes campos</strong></p><br>
    <div class="group-material">
        <input type="password" class="material-control tooltips-general" placeholder="Contraseña" name="adminPassword1" maxlength="200" data-toggle="tooltip" data-placement="top" title="Escribe una contraseña">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nueva contraseña</label>
    </div>
    <div class="group-material">
        <input type="password" class="material-control tooltips-general" placeholder="Repite la contraseña" name="adminPassword2" maxlength="200" data-toggle="tooltip" data-placement="top" title="Repite la contraseña">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Repetir contraseña</label>
    </div>
    <script>
        $(document).ready(function(){
            $(".input-check-user2").keyup(function(){
                var userType=$(this).attr("data-user");
                var userName=$(this).val();
                $.ajax({
                    url:"../process/check-user.php?userName="+userName+"&&userType="+userType,
                    success:function(data){
                       $(".check-user-bd2").html(data);
                    }
                });
            });
        });
    </script>';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($codeAdmin);