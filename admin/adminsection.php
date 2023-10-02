<!DOCTYPE html>
<html lang="es">
<head>
    <title>Secciones</title>
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
              <h1 class="all-tittles">Sistema bibliotecario <small>Administración Institución</small></h1>
            </div>
        </div>
        <div class="container-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
              <li role="presentation"><a href="admininstitution.php">Institución</a></li>
              <li role="presentation"><a href="adminprovider.php">Proveedores</a></li>
              <li role="presentation"><a href="admincategory.php">Categorías</a></li>
              <li role="presentation"  class="active"><a href="adminsection.php">Secciones</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/section.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para registrar nuevas secciones al sistema, debes de seleccionar los datos en el siguiente formulario para registrar una sección
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li class="active">Nueva sección</li>
                      <li><a href="adminlistsection.php">Listado de secciones</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">Agregar una nueva sección</div>
                <form action="../process/AddSection.php" method="post" class="form_SRCB" data-type-form="save">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <div class="group-material">
                                <span>Año</span>
                                <select class="material-control tooltips-general" name="sectionGrade" data-toggle="tooltip" data-placement="top" title="Elige el año">
                                    <option value="" disabled="" selected="">Selecciona una opción</option>
                                    <option value="1° año ">1°</option>
                                    <option value="2° año ">2°</option>
                                    <option value="3° año ">3°</option>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Especialidad</span>
                                <select class="material-control tooltips-general" name="sectionSpecialty" data-toggle="tooltip" data-placement="top" title="Elige la especialidad">
                                    <option value="" disabled="" selected="">Selecciona una opción</option>
                                    <option value="Asistente Ad. ">Asistente Ad.</option>
                                    <option value="Contador ">Contador</option>
                                    <option value="Enfermería ">Enfermería</option>
                                    <option value="General ">General</option>
                                    <option value="Mecánica A. ">Mecánica A.</option>
                                </select>
                            </div>
                            <div class="group-material">
                                <span>Sección</span>
                                <select class="material-control tooltips-general" name="sectionSection" data-toggle="tooltip" data-placement="top" title="Elige la sección">
                                    <option value="" disabled="" selected="">Selecciona una opción</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
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
                    <?php include '../help/help-adminsection.php'; ?>
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