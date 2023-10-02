<!DOCTYPE html>
<html lang="es">
<head>
    <title>Estudiantes</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <script src="../js/SendForm.js"></script>
    <script>
        $().ready(function(){
            $(".check-representative").keyup(function(){
              $.ajax({
                url:"../process/check-representative.php?DUI="+$(this).val(),
                success:function(data){
                  $(".representative-resul").html(data);
                }
              });
            });
        });
    </script>
</head>
<body>
    <?php 
        include '../library/configServer.php';
        include '../library/consulSQL.php';
        include '../process/SecurityAdmin.php';
        include '../inc/NavLateral.php';
    ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php 
            include '../inc/NavUserInfo.php';
        ?>
        <div class="container">
            <div class="page-header">
              <h1 class="all-tittles">Sistema bibliotecario <small>Administración Usuarios</small></h1>
            </div>
        </div>
        <div class="conteiner-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
              <li role="presentation"><a href="adminuser.php">Administradores</a></li>
              <li role="presentation"><a href="adminteacher.php">Docentes</a></li>
              <li role="presentation"  class="active"><a href="adminstudent.php">Estudiantes</a></li>
              <li role="presentation"><a href="adminpersonal.php">Personal administrativo</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user03.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para registrar nuevos estudiantes, para poder registrar un estudiante deberás de llenar todos los campos del siguiente formulario
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li class="active">Nuevo estudiante</li>
                      <li><a href="adminliststudent.php">Listado de estudiantes</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">Registrar un nuevo estudiante</div>
                <form action="../process/AddStudent.php" method="post" class="form_SRCB" data-type-form="save" autocomplete="off">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                           <?php
                                $checkTeacherSection=ejecutarSQL::consultar("SELECT * FROM docente");
                                if(mysqli_num_rows($checkTeacherSection)<=0){
                                    echo '<br><div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante!:</strong> No puedes registrar estudiantes, primero debes de agregar docentes al sistema</div>';
                                }
                            ?>
                           <legend>Datos del estudiante</legend><br>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el NIE del alumno" name="studentNIE" required="" maxlength="20" data-toggle="tooltip" data-placement="top" title="NIE de estudiante">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>NIE</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí los nombres del alumno" name="studentName" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Nombres del estudiante">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombres</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí los apellidos del alumno" name="studentSurname" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Apellidos del estudiante">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Apellidos</label>
                            </div>
                           <div class="group-material">
                                <span>Sección</span>
                                <select class="material-control tooltips-general" name="studentSection" data-toggle="tooltip" data-placement="top" title="Elige la sección a la que pertenece el alumno">
                                    <option value="" disabled="" selected="">Selecciona una sección</option>
                                    <?php
                                        if(mysqli_num_rows($checkTeacherSection)>0){
                                            while($fila=mysqli_fetch_array($checkTeacherSection, MYSQLI_ASSOC)){
                                                $checkStudentSection=ejecutarSQL::consultar("select * from seccion where CodigoSeccion='".$fila['CodigoSeccion']."' order by Nombre");
                                                $row=mysqli_fetch_array($checkStudentSection, MYSQLI_ASSOC);
                                                echo '<option value="'.$row['CodigoSeccion'].'">'.$row['Nombre'].'</option>';
                                                mysqli_free_result($checkStudentSection);
                                            }
                                        }
                                        mysqli_free_result($checkTeacherSection);
                                    ?>
                                </select>
                            </div>
                            <legend>Datos del encargado</legend><br>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Parentesco" name="representativeRelationship" required="" pattern="[a-zA-ZéíóúáñÑ ]{1,30}" maxlength="30" data-toggle="tooltip" data-placement="top" title="Parentesco">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Parentesco</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general check-representative" placeholder="Escribe aquí el número de DUI del encargado" name="representativeDUI" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números y guiones, 10 dígitos">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Número de DUI del encargado</label>
                            </div>
                            <div class="full-reset representative-resul"></div>
                            <legend>Datos de la cuenta <small>(Para ingresar al sistema)</small></legend><br>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general input-check-user" data-user="Student" placeholder="Nombre de usuario" name="UserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}" data-toggle="tooltip" data-placement="top" title="Escribe un nombre de usuario sin espacios, que servira para iniciar sesión">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre de usuario</label>
                                <div class="check-user-bd"></div>
                           </div>
                           <div class="group-material">
                                <input type="password" class="material-control tooltips-general" placeholder="Contraseña" name="Password1" required="" maxlength="200" data-toggle="tooltip" data-placement="top" title="Escribe una contraseña">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Contraseña</label>
                            </div>
                           <div class="group-material">
                                <input type="password" class="material-control tooltips-general" placeholder="Repite la contraseña" name="Password2" required="" maxlength="200" data-toggle="tooltip" data-placement="top" title="Repite la contraseña">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Repetir contraseña</label>
                           </div>
                            <p class="text-center">
                                <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Guardar</button>
                            </p> 
                       </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    <?php include '../help/help-adminstudent.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="zmdi zmdi-thumb-up"></i> &nbsp; De acuerdo</button>
                </div>
            </div>
          </div>
        </div>
        <?php include '../inc/footer.php'; ?>
    </div>
</body>
</html>