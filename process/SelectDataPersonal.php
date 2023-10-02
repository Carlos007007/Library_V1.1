<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codePersonal=consultasSQL::CleanStringText($_POST['code']);
$selectPersonal=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$codePersonal."'");
$dataPersonal=mysqli_fetch_array($selectPersonal, MYSQLI_ASSOC);
if(mysqli_num_rows($selectPersonal)>=1){
    echo '
    <legend><strong>Información del personal administrativo</strong></legend><br>
    <input type="hidden" value="'.$dataPersonal["DUI"].'" name="personalDUI" >
    <div class="group-material">
        <input type="text" class="material-control tooltips-general"  value="'.$dataPersonal["Nombre"].'" name="personalName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres del personal administrativo, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombres</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataPersonal["Apellido"].'" name="personalSurname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los apellidos del personal administrativo, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Apellidos</label>
    </div>
    <input type="hidden" value="'.$dataPersonal["NombreUsuario"].'" name="UserNameOld">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general input-check-user2" value="'.$dataPersonal["NombreUsuario"].'" data-user="Personal" placeholder="Nombre de usuario" name="UserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}" data-toggle="tooltip" data-placement="top" title="Escribe un nombre de usuario sin espacios, que servira para iniciar sesión">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre de usuario</label>
        <div class="check-user-bd2"></div>
   </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataPersonal["Telefono"].'" name="personalPhone" pattern="[0-9]{8,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente 8 números">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Teléfono</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataPersonal["Cargo"].'" name="personalPosition" required="" maxlength="30" data-toggle="tooltip" data-placement="top" title="Cargo del personal administrativo">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Cargo</label>
    </div>
    <legend><strong>Cambio de contraseña</strong></legend>
    <p><strong>No es necesario cambiar la contraseña, sin embargo, si quieres cambiarla deberás de llenar los siguientes campos</strong></p><br>
    <div class="group-material">
        <input type="password" class="material-control tooltips-general" placeholder="Contraseña" name="Password1" maxlength="200" data-toggle="tooltip" data-placement="top" title="Escribe una contraseña">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Contraseña</label>
    </div>
   <div class="group-material">
        <input type="password" class="material-control tooltips-general" placeholder="Repite la contraseña" name="Password2" maxlength="200" data-toggle="tooltip" data-placement="top" title="Repite la contraseña">
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
mysqli_free_result($selectPersonal);