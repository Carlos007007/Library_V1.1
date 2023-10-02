<!DOCTYPE html>
<html lang="es">
<head>
    <title>Docentes</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <script src="../js/SendForm.js"></script>
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
                <li role="presentation"  class="active"><a href="adminteacher.php">Docentes</a></li>
                <li role="presentation"><a href="adminstudent.php">Estudiantes</a></li>
                <li role="presentation"><a href="adminpersonal.php">Personal administrativo</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user02.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para registrar nuevos docentes. Para registrar un docente debes de llenar todos los campos del siguiente formulario, también puedes ver el listado de docentes registrados
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li class="active">Nuevo docente</li>
                      <li><a href="adminlistteacher.php">Listado de docentes</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">Registrar un nuevo docente</div>
                <form action="../process/AddTeacher.php" method="post" class="form_SRCB" data-type-form="save" autocomplete="off">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                           <?php
                                $checkSection=ejecutarSQL::consultar("SELECT * FROM seccion ORDER BY Nombre");
                                if(mysqli_num_rows($checkSection)<=0){
                                    echo '<br><div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante!:</strong> No puedes registrar docentes, primero debes de agregar secciones al sistema</div><br>';
                                } 
                            ?>
                            <legend>Datos básicos</legend><br>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el número de DUI del docente" name="teachingDUI" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números y guiones, 10 dígitos">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Número de DUI</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí los nombres del docente" name="teachingName" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres del docente, solamente letras">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombres</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí los apellidos del docente" name="teachingSurname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los apellidos del docente, solamente letras">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Apellidos</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el número de teléfono del docente" name="teachingPhone" pattern="[0-9]{8,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente 8 números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Teléfono</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí la especialidad del docente" name="teachingSpecialty" required="" maxlength="40" data-toggle="tooltip" data-placement="top" title="Especialidad del docente">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Especialidad</label>
                            </div>
                            <legend>Turno y Sección encargada</legend>
                            <div class="group-material">
                                <span>Sección encargada</span>
                                <select class="material-control tooltips-general" name="teachingSection" data-toggle="tooltip" data-placement="top" title="Elige la sección encargada del docente">
                                    <option value="" disabled="" selected="">Selecciona una sección</option>
                                    <?php
                                        while($fila=mysqli_fetch_array($checkSection, MYSQLI_ASSOC)){
                                            $checkSectionTeacher=ejecutarSQL::consultar("select * from docente where CodigoSeccion='".$fila['CodigoSeccion']."'");
                                            if(mysqli_num_rows($checkSectionTeacher)<=0){
                                               echo '<option value="'.$fila['CodigoSeccion'].'">'.$fila['Nombre'].'</option>'; 
                                            } 
                                            mysqli_free_result($checkSectionTeacher);
                                        }
                                        mysqli_free_result($checkSection);
                                    ?>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Turno</span>
                                <select class="material-control tooltips-general" name="teachingTime" data-toggle="tooltip" data-placement="top" title="Elige el turno que labora el docente">
                                    <option value="Mañana">Mañana</option>
                                    <option value="Tarde">Tarde</option>
                                </select>
                            </div>
                            <legend>Datos de la cuenta <small>(Para ingresar al sistema)</small></legend><br>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general input-check-user" data-user="Teacher" placeholder="Nombre de usuario" name="UserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}" data-toggle="tooltip" data-placement="top" title="Escribe un nombre de usuario sin espacios, que servira para iniciar sesión">
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
                    <?php include '../help/help-adminteacher.php'; ?>
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