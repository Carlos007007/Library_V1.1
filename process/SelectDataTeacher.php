<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeTeacher=consultasSQL::CleanStringText($_POST['code']);
$selectTeacher=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$codeTeacher."'");
$dataTeacher=mysqli_fetch_array($selectTeacher, MYSQLI_ASSOC);
if(mysqli_num_rows($selectTeacher)>=1){
    echo '
    <legend><strong>Información del docente</strong></legend><br>
    <input type="hidden" value="'.$dataTeacher["DUI"].'" name="teachingDUI" >
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Nombre"].'" name="teachingName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres del docente, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombres</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Apellido"].'" name="teachingSurname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los apellidos del docente, solamente letras">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Apellidos</label>
    </div>
    <input type="hidden" value="'.$dataTeacher["NombreUsuario"].'" name="UserNameOld">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general input-check-user2" value="'.$dataTeacher["NombreUsuario"].'" data-user="Teacher" placeholder="Nombre de usuario" name="UserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}" data-toggle="tooltip" data-placement="top" title="Escribe un nombre de usuario sin espacios, que servira para iniciar sesión">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre de usuario</label>
        <div class="check-user-bd2"></div>
   </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Telefono"].'" name="teachingPhone" pattern="[0-9]{8,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente 8 números">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Teléfono</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataTeacher["Especialidad"].'" name="teachingSpecialty" required="" maxlength="40" data-toggle="tooltip" data-placement="top" title="Especialidad del docente">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Especialidad</label>
    </div>
    <legend>Turno y Sección encargada</legend>
    <div class="group-material">
        <select class="material-control tooltips-general" name="teachingSection" data-toggle="tooltip" data-placement="top" title="Elige la sección encargada del docente">';
            $checkSectiont=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataTeacher["CodigoSeccion"]."'");
            $dataSection=mysqli_fetch_array($checkSectiont, MYSQLI_ASSOC);
            echo '<option value="'.$dataSection['CodigoSeccion'].'">'.$dataSection['Nombre'].'</option>';
            $checkSection=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion <> '".$dataTeacher["CodigoSeccion"]."' ORDER BY Nombre ASC");
            while($fila=mysqli_fetch_array($checkSection, MYSQLI_ASSOC)){
                $checkSectionTeacher=ejecutarSQL::consultar("SELECT * FROM docente WHERE CodigoSeccion='".$fila['CodigoSeccion']."'");
                if(mysqli_num_rows($checkSectionTeacher)<=0){
                   echo '<option value="'.$fila['CodigoSeccion'].'">'.$fila['Nombre'].'</option>'; 
                } 
                mysqli_free_result($checkSectionTeacher);
            }
            mysqli_free_result($checkSection);
            mysqli_free_result($checkSectiont);
        echo '</select>
    </div>
    <div class="group-material">
        <select class="material-control tooltips-general" name="teachingTime" data-toggle="tooltip" data-placement="top" title="Elige el turno que labora el docente">';
            switch ($dataTeacher["Jornada"]){
                case 'Mañana':
                    echo'<option value="Mañana">Mañana</option><option value="Tarde">Tarde</option>';
                break;
                case 'Tarde':
                    echo'<option value="Tarde">Tarde</option><option value="Mañana">Mañana</option>';
                break;
                default :
                    echo'<option value="Mañana">Mañana</option><option value="Tarde">Tarde</option>';
                break;
            }
        echo '</select>
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
mysqli_free_result($selectTeacher);

