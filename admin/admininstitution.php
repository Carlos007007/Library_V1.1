<!DOCTYPE html>
<html lang="es">
<head>
    <title>Institución</title>
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
              <li role="presentation" class="active"><a href="admininstitution.php">Institución</a></li>
              <li role="presentation"><a href="adminprovider.php">Proveedores</a></li>
              <li role="presentation"><a href="admincategory.php">Categorías</a></li>
              <li role="presentation"><a href="adminsection.php">Secciones</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/institution.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Guarda los datos de tu institución, una vez almacenados los datos no podrás hacer más registros.
                    Puedes actualizar la información actual, o eliminar el registro completamente y añadir uno nuevo, siempre
                    y cuando no hayas registrado libros.
                </div>
            </div>
        </div>
        <?php 
            $checkInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
            $checktotal=mysqli_num_rows($checkInstitution);
            if($checktotal<=0){
        ?>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">Guardar datos de la institución</div>
                <form action="../process/AddInstitution.php" method="post" class="form_SRCB" data-type-form="save"  autocomplete="off">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Código de infraestructura" name="institutionCode" required="" pattern="[0-9]{1,10}" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solo números, máximo 10 caracteres">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Código infraestructura</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Distrito de la institución" name="institutionDistrict" required="" pattern="[0-9]{1,20}" maxlength="20" data-toggle="tooltip" data-placement="top" title="Solo números, máximo 20 caracteres">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Distrito</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Nombre de la institución" name="institutionName" required="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre de la institución">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre de la institución</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Nombre del director o gerente de la institución" name="institutionDirector" required="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Nombre del director o gerente de la institución">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre del director o gerente de la institución</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Nombre del encargado de la biblioteca" name="institutionLibrarian" required="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del encargado de la biblioteca">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre del encargado de la biblioteca</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Teléfono de la institución" name="institutionPhone" required="" pattern="[0-9]{8,8}" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solo 8 números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Teléfono</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Año lectivo" name="institutionYear" required="" pattern="[0-9]{1,4}" maxlength="4" data-toggle="tooltip" data-placement="top" title="Solo números, máximo 4 caracteres">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Año</label>
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
        <?php
            }else{
            $fila=mysqli_fetch_array($checkInstitution, MYSQLI_ASSOC);
        ?>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-green">Actualizar datos de la institución</div>
                <form action="../process/UpdateInstitution.php" method="post" class="form_SRCB" data-type-form="update"  autocomplete="off">
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <div class="group-material">
                                <span>Código infraestructura</span>
                                <input type="text" readonly value="<?php echo $fila["CodigoInfraestructura"]; ?>" class="material-control tooltips-general" name="institutionCode" required="" pattern="[0-9]{1,10}" maxlength="10">
                            </div>
                            <div class="group-material">
                                <input type="text" value="<?php echo $fila["Distrito"]; ?>" class="material-control tooltips-general" name="institutionDistrict" required="" pattern="[0-9]{1,20}" maxlength="20" data-toggle="tooltip" data-placement="top" title="Solo números, máximo 2 caracteres">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Distrito</label>
                            </div>
                            <div class="group-material">
                                <input type="text" value="<?php echo $fila["Nombre"]; ?>" class="material-control tooltips-general" name="institutionName" required="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre de la institución">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre de la institución</label>
                            </div>
                            <div class="group-material">
                                <input type="text" value="<?php echo $fila["NombreDirector"]; ?>" class="material-control tooltips-general" placeholder="Nombre del director o gerente de la institución" name="institutionDirector" required="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Nombre del director o gerente de la institución">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre del director o gerente de la institución</label>
                            </div>
                            <div class="group-material">
                                <input type="text" value="<?php echo $fila["NombreBibliotecario"]; ?>" class="material-control tooltips-general" placeholder="Nombre del encargado de la biblioteca" name="institutionLibrarian" required="" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ. ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del encargado de la biblioteca">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Nombre del encargado de la biblioteca</label>
                            </div>
                            <div class="group-material">
                                <input type="text" value="<?php echo $fila["Telefono"]; ?>" class="material-control tooltips-general" name="institutionPhone" required="" pattern="[0-9]{8,8}" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solo 8 números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Teléfono</label>
                            </div>
                            <div class="group-material">
                                <input type="text" value="<?php echo $fila["Year"]; ?>" class="material-control tooltips-general" name="institutionYear" required="" pattern="[0-9]{1,4}" maxlength="4" data-toggle="tooltip" data-placement="top" title="Solo números, máximo 4 caracteres">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Año</label>
                            </div>
                            <p class="text-center">
                                <button type="submit" class="btn btn-success"><i class="zmdi zmdi-refresh"></i> &nbsp;&nbsp; Actualizar</button>
                            </p>
                       </div>
                   </div>
               </form>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar institución</div>
                <div class="row">
                    <div class="col-xs-12">
                        <?php 
                            $checkInstitutionBook=ejecutarSQL::consultar("SELECT * FROM libro");
                            if(mysqli_num_rows($checkInstitutionBook)>=1){
                                echo '<p class="text-center"><button  class="btn btn-danger btn-lg" disabled="disabled"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar</button></p>';
                            }else{
                                echo '<form action="../process/DeleteInstitution.php" method="post" class="form_SRCB" data-type-form="delete">   
                                    <input value="'. $fila["CodigoInfraestructura"] .'" type="hidden" name="primaryKey">
                                    <p class="text-center"><button type="submit" class="btn btn-danger btn-lg"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar</button></p>
                                </form>';
                            }
                            mysqli_free_result($checkInstitutionBook);
                        ?>
                    </div>
                </div>
            </div>
        </div> 
        <?php
            }
            mysqli_free_result($checkInstitution);
        ?>
        <div class="msjFormSend"></div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    <?php include '../help/help-admininstitution.php'; ?>
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