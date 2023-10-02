<!DOCTYPE html>
<html lang="es">
<head>
    <title>Administradores</title>
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
        <div class="container-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
              <li role="presentation"  class="active"><a href="adminuser.php">Administradores</a></li>
              <li role="presentation"><a href="adminteacher.php">Docentes</a></li>
              <li role="presentation"><a href="adminstudent.php">Estudiantes</a></li>
              <li role="presentation"><a href="adminpersonal.php">Personal administrativo</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user01.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección donde se encuentra el listado de los administradores, puedes desactivar la cuenta de cualquier administrador o eliminar los datos si no hay préstamos asociados a la cuenta
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                        <li><a href="adminuser.php">Nuevo administrador</a></li>
                        <li class="active">listado de administradores</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h2 class="text-center all-tittles">Lista de administradores</h2>
            <?php
                $checkAdmin=ejecutarSQL::consultar("SELECT * FROM administrador WHERE Nombre <> 'Super Administrador'");
                if(mysqli_num_rows($checkAdmin)>0){
                    echo '<div class="div-table" id="List-Admin">
                    <div class="div-table-row div-table-head">
                        <div class="div-table-cell">#</div>
                        <div class="div-table-cell">Nombre</div>
                        <div class="div-table-cell">Nombre de usuario</div>
                        <div class="div-table-cell">Email</div>
                        <div class="div-table-cell">Estado</div>
                        <div class="div-table-cell">Cambiar E.</div>
                        <div class="div-table-cell">Actualizar</div>
                        <div class="div-table-cell">Eliminar</div>
                    </div>';                    
                    $p=1;
                    while($fila=mysqli_fetch_array($checkAdmin, MYSQLI_ASSOC)){
                        echo '<div class="div-table-row">
                                <div class="div-table-cell">'.$p.'</div>
                                <div class="div-table-cell">'.$fila['Nombre'].'</div>
                                <div class="div-table-cell">'.$fila['NombreUsuario'].'</div>
                                <div class="div-table-cell">'.$fila['Email'].'</div>
                                <div class="div-table-cell">'.$fila['Estado'].'</div>';
                                if($fila['Estado']=='Activo'){
                                    $checkAdminLoan=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoAdmin='".$fila['CodigoAdmin']."'");
                                    echo '
                                    <form class="div-table-cell form_SRCB" action="../process/DisabledAdmin.php" method="post" data-type-form="updateAccounAdmin" >
                                        <input value="'.$fila["CodigoAdmin"].'" type="hidden" name="primaryKey">
                                        <button type="submit" class="btn btn-primary tooltips-general" data-toggle="tooltip" data-placement="top" title="Cuenta activa, pulsa el botón para desactivarla"><i class="zmdi zmdi-swap"></i></button>
                                    </form>
                                    <div class="div-table-cell"><button class="btn btn-success btn-update" data-code="'.$fila['CodigoAdmin'].'" data-url="../process/SelectDataAdmin.php"><i class="zmdi zmdi-refresh"></i></button></div>';
                                    if(mysqli_num_rows($checkAdminLoan)>0){
                                        echo '<div class="div-table-cell"><button disabled="disabled" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button></div>';
                                    }else{
                                        echo '<form class="div-table-cell form_SRCB" action="../process/DeleteAdmin.php" method="post" data-type-form="delete" >
                                            <input value="'.$fila["CodigoAdmin"].'" type="hidden" name="primaryKey">
                                            <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                        </form>';
                                    }
                                }else{
                                    echo '
                                    <form class="div-table-cell form_SRCB" action="../process/ActivateAdmin.php" method="post" data-type-form="updateAccounAdmin" >
                                        <input value="'.$fila["CodigoAdmin"].'" type="hidden" name="primaryKey">
                                        <button type="submit" class="btn btn-info tooltips-general" data-toggle="tooltip" data-placement="top" title="Cuenta desactivada, pulsa el botón para activarla"><i class="zmdi zmdi-swap"></i></button>
                                    </form>
                                    <div class="div-table-cell"><button class="btn btn-success btn-update" data-code="'.$fila['CodigoAdmin'].'" data-url="../process/SelectDataAdmin.php"><i class="zmdi zmdi-refresh"></i></button></div>
                                    <div class="div-table-cell"><button disabled="disabled" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button></div>';
                                }
                            echo '</div>'; 
                        $p++;
                        mysqli_free_result($checkAdminLoan);
                    }
                    echo '</div>';
                }else{
                    echo '<br><br><br><h2 class="text-center all-tittles">No hay administradores registrados en el sistema</h2><br><br><br>';
                }
                mysqli_free_result($checkAdmin);
            ?>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form class="form_SRCB modal-content" action="../process/UpdateAdmin.php" method="post" data-type-form="update"  autocomplete="off">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center all-tittles">Actualizar datos de administrador</h4>
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
                    <?php include '../help/help-adminlistuser.php'; ?>
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
