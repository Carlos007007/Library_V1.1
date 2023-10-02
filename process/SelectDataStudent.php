<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeStudent=consultasSQL::CleanStringText($_POST['code']);
$selectStudent=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$codeStudent."'");
$dataStudent=mysqli_fetch_array($selectStudent, MYSQLI_ASSOC);
if(mysqli_num_rows($selectStudent)>=1){
    echo '
    <legend><strong>Información del estudiante</strong></legend><br>
    <input type="hidden" value="'.$dataStudent['NIE'].'" name="studentNIEOld">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['NIE'].'" name="studentNIE" required="" maxlength="20" data-toggle="tooltip" data-placement="top" title="NIE de estudiante">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>NIE</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['Nombre'].'" name="studentName" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Nombres del estudiante">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombres</label>
    </div>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['Apellido'].'" name="studentSurname" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Apellidos del estudiante">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Apellidos</label>
    </div>
    <input type="hidden" value="'.$dataStudent["NombreUsuario"].'" name="UserNameOld">
    <div class="group-material">
        <input type="text" class="material-control tooltips-general input-check-user2" value="'.$dataStudent["NombreUsuario"].'" data-user="Student" placeholder="Nombre de usuario" name="UserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}" data-toggle="tooltip" data-placement="top" title="Escribe un nombre de usuario sin espacios, que servira para iniciar sesión">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Nombre de usuario</label>
        <div class="check-user-bd2"></div>
   </div>
    <div class="group-material">
        <span>Sección</span>
        <select class="material-control tooltips-general" name="studentSection" data-toggle="tooltip" data-placement="top" title="Elige la sección a la que pertenece el alumno">';
            $checkTeacherSection=ejecutarSQL::consultar("SELECT * FROM docente WHERE CodigoSeccion <> '".$dataStudent['CodigoSeccion']."' ORDER BY Nombre ASC");
            $checkSectionStudent=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataStudent['CodigoSeccion']."'");
            $dataSts=mysqli_fetch_array($checkSectionStudent, MYSQLI_ASSOC);
            echo '<option value="'.$dataSts['CodigoSeccion'].'">'.$dataSts['Nombre'].'</option>';
            while($fila=mysqli_fetch_array($checkTeacherSection, MYSQLI_ASSOC)){
                $checkStudentSection=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$fila['CodigoSeccion']."' ORDER BY Nombre ASC");
                $row=mysqli_fetch_array($checkStudentSection, MYSQLI_ASSOC);
                echo '<option value="'.$row['CodigoSeccion'].'">'.$row['Nombre'].'</option>';
                mysqli_free_result($checkStudentSection);
            }
            mysqli_free_result($checkTeacherSection);
            mysqli_free_result($checkSectionStudent);
        echo '</select>
    </div>
    <legend>Datos del encargado</legend>
    <br><br>
    <div class="group-material">
        <input type="text" class="material-control tooltips-general" value="'.$dataStudent['Parentesco'].'" name="representativeRelationship" required="" pattern="[a-zA-ZéíóúáñÑ ]{1,30}" maxlength="30" data-toggle="tooltip" data-placement="top" title="Parentesco">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Parentesco</label>
    </div>
    <input type="hidden" value="'.$dataStudent['DUI'].'" name="representativeDUIold" >
    <div class="group-material">
        <input type="text" class="material-control tooltips-general check-representative" value="'.$dataStudent['DUI'].'" name="representativeDUI" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números y guiones, 10 dígitos">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Número de DUI del encargado</label>
    </div>
    <div class="full-reset representative-resul"></div>
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
            $(".input-check-user2").on("keyup", function(){
                var userType=$(this).attr("data-user");
                var userName=$(this).val();
                $.ajax({
                    url:"../process/check-user.php?userName="+userName+"&&userType="+userType,
                    success:function(data){
                       $(".check-user-bd2").html(data);
                    }
                });
            });
            $(".check-representative").on("keyup", function(){
              $.ajax({
                url:"../process/check-representative.php?DUI="+$(this).val(),
                success:function(data){
                  $(".representative-resul").html(data);
                }
              });
            });
        });
    </script>';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectStudent);