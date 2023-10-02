<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuraciones avanzadas</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <script src="../js/SendForm.js"></script>
    <script>
        $(document).ready(function(){
            $('.btn-backup').on('click', function(){
                swal({  
                    title: "¿Quieres realizar la copia?",   
                    text: "La copia de seguridad quedara guardada en el sistema. Podrás restaurar el sistema al punto actual  en caso de fallas",   
                    type: "info",   
                    showCancelButton: true,   
                    closeOnConfirm: false,   
                    showLoaderOnConfirm: true,    
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Realizar copia",
                    animation: "slide-from-top"
                }, function(){       
                    $.ajax({
                        url:"../process/Backup.php",
                        success:function(data){
                            if(data==="success"){
                                swal({ 
                                    title:"¡Copia de seguridad realizada!", 
                                    text:"La copia de seguridad se realizó con éxito, podrás recuperar el sistema al estado actual si lo deseas", 
                                    type: "success", 
                                    confirmButtonText: "Aceptar" 
                                },
                                function(isConfirm){  
                                    if (isConfirm) {     
                                        location.reload();
                                    } else {    
                                        location.reload();
                                    } 
                                });
                            }else if (data==="error"){
                                swal({
                                   title:"¡Ocurrió un error inesperado!",
                                   text: "No hemos podido realizar la copia de seguridad del sistema",
                                   type: "error",
                                   confirmButtonText: "Aceptar"
                                });
                            }else{
                                swal({
                                   title:"¡Ocurrió un error inesperado!",
                                   text:"Ocurrió un error al procesar la petición, por favor recarga la página e intenta nuevamente",
                                   type: "error",
                                   confirmButtonText: "Aceptar"
                                });
                            }
                        }
                    });
                    return false;
                });  
            });
            $('.btn-restore').on('click', function(){
                $('#ModalRestore').modal({
                    show: true,
                    backdrop: "static"
                });
            });
            $('.btn-delete').on('click', function(){
                var process=$(this).attr('data-process');
                var text_modal=$(this).attr('data-text');
                var type_form=$(this).attr('data-type');
                $('#text-modal').html(text_modal);
                $('#FORMSRCB').attr('action',process).attr('data-type-form',type_form);
                $('#ModalDeleteAll').modal({
                    show: true,
                    backdrop: "static"
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
              <h1 class="all-tittles">Sistema bibliotecario <small>configuraciones avanzadas</small></h1>
            </div>
        </div>
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li role="presentation" class="active"><a href="#security" aria-controls="security" role="tab" data-toggle="tab">Seguridad</a></li>
            <li role="presentation"><a href="#others" aria-controls="others" role="tab" data-toggle="tab">Otras opciones</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="security">
                <div class="container-fluid"  style="margin: 50px 0;">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3">
                            <p class="text-center text-danger"><i class="zmdi zmdi-shield-security zmdi-hc-5x"></i></p>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                            Puedes realizar copias de seguridad de la base de datos en cualquier momento, también puedes restaurar el sistema a un punto de restauración que hayas creado previamente.
                        </div>
                    </div>
                </div>  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-cloud-download zmdi-hc-4x btn-backup"></i></p>
                                <h3 class="text-center all-tittles">realizar copia de seguridad</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-cloud-upload zmdi-hc-4x btn-restore"></i></p>
                                <h3 class="text-center all-tittles">restaurar el sistema</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-cloud-off zmdi-hc-4x btn-delete" data-process="../process/DeleteBackups.php" data-text="todas las copias de seguridad" data-type="deleteBackup"></i></p>
                                <h3 class="text-center all-tittles">borrar copias de seguridad</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="others">
                <div class="container-fluid"  style="margin: 50px 0;">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3">
                            <p class="text-center text-danger"><i class="zmdi zmdi-fire zmdi-hc-5x"></i></p>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                            En esta sección se muestran opciones avanzadas para eliminar grandes cantidades de datos. Eliminarás todos los datos registrados en el sistema de la opción que elijas. .
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-calendar-close zmdi-hc-4x btn-delete" data-process="../process/DeleteAllLoans.php" data-text="todos los préstamos" data-type="delete"></i></p>
                                <h3 class="text-center all-tittles">eliminar préstamos</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-male-alt zmdi-hc-4x btn-delete" data-process="../process/DeleteAllUsers.php?userType=Teacher" data-text="todos los docentes" data-type="delete"></i></p>
                                <h3 class="text-center all-tittles">eliminar docentes</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-accounts-alt zmdi-hc-4x btn-delete" data-process="../process/DeleteAllUsers.php?userType=Student" data-text="todos los estudiantes" data-type="delete"></i></p>
                                <h3 class="text-center all-tittles">eliminar estudiantes</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-male-female zmdi-hc-4x btn-delete" data-process="../process/DeleteAllUsers.php?userType=Personal" data-text="todo el personal administrativo" data-type="delete"></i></p>
                                <h3 class="text-center all-tittles">eliminar personal ad.</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-book zmdi-hc-4x btn-delete" data-process="../process/DeleteAllBooks.php" data-text="todos los libros" data-type="delete"></i></p>
                                <h3 class="text-center all-tittles">eliminar libros</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="report-content">
                                <p class="text-center"><i class="zmdi zmdi-time-restore-setting zmdi-hc-4x btn-delete" data-process="../process/DeleteBitacora.php" data-text="registros de bitacora" data-type="delete"></i></p>
                                <h3 class="text-center all-tittles">eliminar bitacora</h3>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <?php include '../help/help-adminadvancesettings.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="zmdi zmdi-thumb-up"></i> &nbsp; De acuerdo</button>
                </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalRestore" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form class="form_SRCB modal-content" action="../process/RestoreSystem.php" method="post" data-type-form="restorePoint" autocomplete="off">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center all-tittles">Restaurar sistema</h4>
              </div>
                <div class="modal-body">
                    <legend><strong>Selecciona un punto de restauración</strong></legend><br>
                    <input type="hidden" name="AdminCode" value="<?php echo $_SESSION['primaryKey']; ?>">
                    <div class="group-material">
                        <span>Punto de restauración</span>
                        <select class="material-control" name="restorePoint">
                            <option value="" disabled="" selected="">selecciona un punto de restauración</option>
                            <?php include '../inc/ListBackup.php'; ?>
                        </select>
                    </div>
                    <legend><strong>Escribe tú nombre de usuario y contraseña</strong></legend><br>
                    <div class="group-material">
                        <input type="text" class="material-control" placeholder="Nombre de usuario" name="adminUserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Nombre de usuario</label>
                    </div>
                    <div class="group-material">
                        <input type="password" class="material-control" placeholder="Contraseña" name="adminPassword" required="" maxlength="200">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Contraseña</label>
                    </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-cloud-upload"></i> &nbsp;&nbsp; Restaurar sistema</button>
              </div>
            </form>
          </div>
        </div>
        <div class="modal fade" id="ModalDeleteAll" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
              <form class="form_SRCB modal-content" id="FORMSRCB"  method="post" data-type-form="delete" autocomplete="off">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center all-tittles">eliminar <span id="text-modal"></span></h4>
              </div>
                <div class="modal-body">
                    <legend><strong>Escribe tú nombre de usuario y contraseña</strong></legend><br>
                    <input type="hidden" name="AdminCode" value="<?php echo $_SESSION['primaryKey']; ?>">
                    <div class="group-material">
                        <input type="text" class="material-control" placeholder="Nombre de usuario" name="adminUserName" required="" maxlength="20" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,20}">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Nombre de usuario</label>
                    </div>
                    <div class="group-material">
                        <input type="password" class="material-control" placeholder="Contraseña" name="adminPassword" required="" maxlength="200">
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Contraseña</label>
                    </div>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar</button>
              </div>
            </form>
          </div>
        </div>
        <?php include '../inc/footer.php'; ?>
    </div>
</body>
</html>