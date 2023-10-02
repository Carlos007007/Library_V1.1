<!DOCTYPE html>
<html lang="es">
<head>
    <title>Proveedores</title>
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
              <li role="presentation"  class="active"><a href="adminprovider.php">Proveedores</a></li>
              <li role="presentation"><a href="admincategory.php">Categorías</a></li>
              <li role="presentation"><a href="adminsection.php">Secciones</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user04.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección donde se encuentra el listado de proveedores de libros. Puedes actualizar o eliminar los datos del proveedor, si hay libros asociados al proveedor no podrás eliminarlo.
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                      <li><a href="adminprovider.php">Nuevo proveedor</a></li>
                      <li class="active">Listado de proveedores</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h2 class="text-center all-tittles">listado de proveedores</h2>
            <div class="div-table">
                <div class="div-table-row div-table-head">
                    <div class="div-table-cell">#</div>
                    <div class="div-table-cell">Nombre</div>
                    <div class="div-table-cell">Email</div>
                    <div class="div-table-cell">Dirección</div>
                    <div class="div-table-cell">Teléfono</div>
                    <div class="div-table-cell">Responsable</div>
                    <div class="div-table-cell">Actualizar</div>
                    <div class="div-table-cell">Eliminar</div>
                </div>
            <?php
                $checkProvider=ejecutarSQL::consultar("SELECT * FROM proveedor");  
                if(mysqli_num_rows($checkProvider)>0){
                    $p=1;
                    while($fila=mysqli_fetch_array($checkProvider, MYSQLI_ASSOC)){
                        echo '<div class="div-table-row">
                            <div class="div-table-cell">'.$p.'</div>
                            <div class="div-table-cell">'.$fila['Nombre'].'</div>
                            <div class="div-table-cell">'.$fila['Email'].'</div>
                            <div class="div-table-cell">'.$fila['Direccion'].'</div>
                            <div class="div-table-cell">'.$fila['Telefono'].'</div>
                            <div class="div-table-cell">'.$fila['ResponAtencion'].'</div>
                            <div class="div-table-cell"><button class="btn btn-success btn-update" data-code="'.$fila['CodigoProveedor'].'" data-url="../process/SelectDataProvider.php"><i class="zmdi zmdi-refresh"></i></button></div>';
                            $checkBookProvider=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoProveedor='".$fila['CodigoProveedor']."'");
                            if(mysqli_num_rows($checkBookProvider)>=1){
                                echo '<div class="div-table-cell"><button class="btn btn-danger" disabled="disabled"><i class="zmdi zmdi-delete"></i></button></div>';
                            }else{
                                echo '<form class="div-table-cell form_SRCB" action="../process/DeleteProvider.php" method="post" data-type-form="delete"><input value="'.$fila['CodigoProveedor'].'" type="hidden" name="primaryKey"><button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button></form>';
                            }
                            mysqli_free_result($checkBookProvider);
                        echo '</div>';
                        $p++;
                    }  
                }else{
                    echo '<br><br><br><h3 class="text-center all-tittles">No hay proveedores registrados en el sistema</h3><br><br>';
                }
                mysqli_free_result($checkProvider);
            ?>
            </div>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form class="form_SRCB modal-content" action="../process/UpdateProvider.php" method="post" data-type-form="update" autocomplete="off">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center all-tittles">Actualizar datos de proveedor</h4>
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
                    <?php include '../help/help-adminlistprovider.php'; ?>
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