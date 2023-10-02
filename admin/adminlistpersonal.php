<!DOCTYPE html>
<html lang="es">
<head>
    <title>Personal administrativo</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <script src="../js/jPages.js"></script>
    <script src="../js/SendForm.js"></script>
    <script>
        $(document).ready(function(){
            $(function(){
                $("div.holder").jPages({
                    containerID : "itemContainer",
                    perPage: 20
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
        $PersonalN=consultasSQL::CleanStringText($_GET['PersonalN']);
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
                <li role="presentation"><a href="adminstudent.php">Estudiantes</a></li>
                <li role="presentation"  class="active"><a href="adminpersonal.php">Personal administrativo</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user05.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección donde se encuentra el listado del personal administrativo registrado en el sistema, puedes actualizar algunos datos  o eliminar el registro completo del personal administrativo siempre y cuando no tenga préstamos pendientes.<br>
                    <strong class="text-danger"><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante! </strong>Si eliminas el personal administrativo del sistema se borrarán todos los datos relacionados con él, incluyendo préstamos y registros en la bitácora.
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                        <li><a href="adminpersonal.php">Nuevo personal ad.</a></li>
                        <li class="active">Listado de personal ad.</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <form class="pull-right" style="width: 30% !important;" action="adminlistpersonal.php" method="get" autocomplete="off">
                <div class="group-material">
                    <input type="search" style="display: inline-block !important; width: 70%;" class="material-control tooltips-general" placeholder="Buscar personal" name="PersonalN" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres, sin los apellidos">
                    <button class="btn" style="margin: 0; height: 43px; background-color: transparent !important;">
                        <i class="zmdi zmdi-search" style="font-size: 25px;"></i>
                    </button>
                </div>
            </form>
            <h2 class="text-center all-tittles" style="clear: both; margin: 25px 0;">listado de personal administrativo</h2>
            <div class="table-responsive">
                <div class="div-table" style="margin:0 !important;">
                    <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                        <div class="div-table-cell" style="width: 6%;">#</div>
                        <div class="div-table-cell" style="width: 15%;">DUI</div>
                        <div class="div-table-cell" style="width: 15%;">Apellidos</div>
                        <div class="div-table-cell" style="width: 15%;">Nombres</div>
                        <div class="div-table-cell" style="width: 12%;">Teléfono</div>
                        <div class="div-table-cell" style="width: 15%;">Cargo</div>
                        <div class="div-table-cell" style="width: 9%;">Actualizar</div>
                        <div class="div-table-cell" style="width: 9%;">Eliminar</div>
                    </div>
                </div>
            </div>
            <?php
                if(!$PersonalN==""){
                    $selectPersonalByName=ejecutarSQL::consultar("SELECT * FROM personal WHERE Nombre like '%".$PersonalN."%' ORDER BY Apellido ASC, Nombre ASC");
                    if(mysqli_num_rows($selectPersonalByName)>=1){
                        echo '<ul id="itemContainer" class="list-unstyled">';
                        $c=1;
                        while($dataP=mysqli_fetch_array($selectPersonalByName, MYSQLI_ASSOC)){
                            echo '<li>
                                <div class="table-responsive">
                                    <div class="div-table" style="margin:0 !important;">
                                        <div class="div-table-row div-table-row-list">
                                            <div class="div-table-cell" style="width: 6%;">'.$c.'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$dataP['DUI'].'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$dataP['Apellido'].'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$dataP['Nombre'].'</div>
                                            <div class="div-table-cell" style="width: 12%;">'.$dataP['Telefono'].'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$dataP['Cargo'].'</div>
                                            <div class="div-table-cell" style="width: 9%;"><button class="btn btn-success btn-update" data-code="'.$dataP['DUI'].'" data-url="../process/SelectDataPersonal.php"><i class="zmdi zmdi-refresh"></i></button></div>
                                            <form class="div-table-cell form_SRCB" action="../process/DeletePersonal.php" method="post" data-type-form="delete" style="width: 9%;">
                                                <input value="'.$dataP['DUI'].'" type="hidden" name="primaryKey">
                                                <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>';
                            $c++;
                        }
                        echo '</ul><div class="holder"></div>';
                    }else{
                        echo '<br><br><br><h2 class="text-center all-tittles">No hay personal administrativo registrado con el nombre "'.$PersonalN.'" en el sistema</h2><br><br><br>';
                    }
                    mysqli_free_result($selectPersonalByName);
                }else{
                    $selectAllPersonal=ejecutarSQL::consultar("SELECT * FROM personal ORDER BY Apellido ASC, Nombre ASC");
                    if(mysqli_num_rows($selectAllPersonal)>=1){
                        echo '<ul id="itemContainer" class="list-unstyled">';
                        $c=1;
                        while($data=mysqli_fetch_array($selectAllPersonal, MYSQLI_ASSOC)){
                            echo '<li>
                                <div class="table-responsive">
                                    <div class="div-table" style="margin:0 !important;">
                                        <div class="div-table-row div-table-row-list">
                                            <div class="div-table-cell" style="width: 6%;">'.$c.'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$data['DUI'].'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$data['Apellido'].'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$data['Nombre'].'</div>
                                            <div class="div-table-cell" style="width: 12%;">'.$data['Telefono'].'</div>
                                            <div class="div-table-cell" style="width: 15%;">'.$data['Cargo'].'</div>
                                            <div class="div-table-cell" style="width: 9%;"><button class="btn btn-success btn-update" data-code="'.$data['DUI'].'" data-url="../process/SelectDataPersonal.php"><i class="zmdi zmdi-refresh"></i></button></div>
                                            <form class="div-table-cell form_SRCB" action="../process/DeletePersonal.php" method="post" data-type-form="delete" style="width: 9%;">
                                                <input value="'.$data['DUI'].'" type="hidden" name="primaryKey">
                                                <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>';
                            $c++;
                        }
                        echo '</ul><div class="holder"></div>';
                    }else{
                        echo '<br><br><br><h2 class="text-center all-tittles">No hay personal administrativo registrado en el sistema</h2><br><br><br>';
                    }
                    mysqli_free_result($selectAllPersonal);
                }
            ?>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
              <form class="form_SRCB modal-content" action="../process/UpdatePersonal.php" method="post" data-type-form="update"  autocomplete="off">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center all-tittles">Actualizar datos de personal ad.</h4>
              </div>
              <div class="modal-body" id="ModalData"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="zmdi zmdi-refresh"></i> &nbsp;&nbsp; Guardar cambios</button>
              </div>
            </form>
          </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    <?php include '../help/help-adminlistpersonal.php'; ?>
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