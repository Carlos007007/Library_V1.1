<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registrar Libro</title>
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
              <h1 class="all-tittles">Sistema bibliotecario <small>Añadir libro</small></h1>
            </div>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/flat-book.png" alt="pdf" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección para agregar nuevos libros a la biblioteca, deberas de llenar todos los campos para poder registrar el libro
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <form action="../process/AddBook.php" method="post" class="form_SRCB" data-type-form="save" autocomplete="off">
                <div class="container-flat-form">
                    <div class="title-flat-form title-flat-blue">Nuevo libro</div>
                    <div class="row">
                       <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <legend><strong>Información básica</strong></legend><br>
                            <div class="group-material">
                                <span>Categoría</span>
                                <select class="tooltips-general material-control" name="bookCategory" data-toggle="tooltip" data-placement="top" title="Elige la categoría del libro">
                                    <option value="" disabled="" selected="">Selecciona una categoría</option>
                                    <?php
                                        $checkCategory= ejecutarSQL::consultar("SELECT * FROM categoria");
                                        while($fila=mysqli_fetch_array($checkCategory, MYSQLI_ASSOC)){
                                            echo '<option value="'.$fila['CodigoCategoria'].'">'.$fila['Nombre'].'</option>'; 
                                        }
                                        mysqli_free_result($checkCategory);
                                    ?>
                                </select>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí el código correlativo del libro" name="bookCorrelative" value="000" pattern="[0]{1,20}" required="" maxlength="20" data-toggle="tooltip" data-placement="top" title="Escribe el código correlativo del libro, solamente números">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Código correlativo</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí el título o nombre del libro" name="bookName" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe el título o nombre del libro">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Título</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí el autor del libro" name="bookAutor" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del autor del libro">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Autor</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="tooltips-general material-control" placeholder="Escribe aquí el país del libro" required="" name="bookCountry" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el país del libro">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>País</label>
                            </div>
                            <legend><strong>Otros datos</strong></legend><br>
                            <div class="group-material">
                                <span>Proveedor</span>
                                <select class="tooltips-general material-control" name="bookProvider" data-toggle="tooltip" data-placement="top" title="Elige el proveedor del libro">
                                    <option value="" disabled="" selected="">Selecciona un proveedor</option>
                                    <?php
                                        $checkProvider= ejecutarSQL::consultar("select * from proveedor");
                                        while($fila=mysqli_fetch_array($checkProvider, MYSQLI_ASSOC)){
                                            echo '<option value="'.$fila['CodigoProveedor'].'">'.$fila['Nombre'].'</option>'; 
                                        }
                                        mysqli_free_result($checkProvider);
                                    ?>
                                </select>
                            </div>
                           <div class="group-material">
                               <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el año del libro" name="bookYear" required="" pattern="[0-9]{1,4}" maxlength="4" data-toggle="tooltip" data-placement="top" title="Solamente números, sin espacios">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Año</label>
                           </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí la editorial del libro" name="bookEditorial" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Editorial del libro">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Editorial</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí la edición del libro" name="bookEdition" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Edición del libro">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Edición</label>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general"  placeholder="Escribe aquí la cantidad de libros que registraras" name="bookCopies" required=" "pattern="[0-9]{1,7}" maxlength="7" data-toggle="tooltip" data-placement="top" title="¿Cuántos libros registraras?">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Ejemplares</label>
                            </div>
                            <legend><strong>Estado físico, ubicación y valor</strong></legend><br>
                            <div class="group-material">
                               <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí la ubicación del libro" name="bookLocation" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="¿Dónde se ubicara el libro?">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Ubicación</label>
                            </div>
                            <div class="group-material">
                                <span>Cargo</span>
                                <select class="tooltips-general material-control" name="bookOffice" data-toggle="tooltip" data-placement="top" title="Elige el cargo del libro">
                                    <option value="" disabled="" selected="">Selecciona el cargo del libro</option>
                                    <option value="1-1">Entrega del ministerio</option>
                                    <option value="1-2">Donaciones</option>
                                    <option value="1-3">Compras con fondos propios</option>
                                    <option value="1-4">Presupuesto escolar</option>
                                    <option value="1-5">Otros</option>
                                </select>
                            </div>
                            <div class="group-material">
                                <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el precio estimado del libro" name="bookEstimated" required="" pattern="[0-9.]{1,7}" maxlength="7" data-toggle="tooltip" data-placement="top" title="Sólo números y un punto si el valor posee decimales. Ejemplo: 7.79">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Estimado</label>
                            </div>
                            <div class="group-material">
                                <span>Estado</span>
                                <select class="tooltips-general material-control" name="bookState" data-toggle="tooltip" data-placement="top" title="Elige el estado del libro">
                                    <option value="" disabled="" selected="">Selecciona el estado del libro</option>
                                    <option value="Bueno">Bueno</option>
                                    <option value="Deteriorado">Deteriorado</option>
                                </select>
                            </div>
                            <p class="text-center">
                                <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Guardar</button>
                            </p>
                       </div>
                   </div>
                </div>
            </form>
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
                    <?php include '../help/help-admininventory.php'; ?>
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