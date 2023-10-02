<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reportes</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <link rel="stylesheet" href="../css/timeline.css">
    <script>
        $(document).ready(function(){
            $('.btn-file').on('click', function(){
                var file; var uTipe; var urlData; var title1; var text1; var text2; var file_type=$(this).attr('data-type');
                if(file_type==="file"){
                    file=$(this).attr('data-file');
                    urlData='../process/checkInstitution.php';
                    title1="¿Quieres generar la ficha?";
                    text1="La ficha se generará en formato PDF y se abrirá en una ventana nueva. Debes esperar un lapso de tiempo de 15 segundos para que el sistema genere la ficha";
                    text2="No puedes generar fichas, primero debes de registrar los datos de la institución. Ve a la opción Administración del menú y luego a Datos institución";
                }
                if(file_type==="report"){
                    file=$(this).attr('data-file');
                    urlData=$(this).attr('data-check');
                    title1="¿Quieres generar el reporte?";
                    text1="El reporte se generará en formato PDF y se abrirá en una ventana nueva. Debes esperar unos minutos para que el sistema genere el reporte";
                    text2="Lo sentimos no puedes generar el reporte, no hay registros en el sistema";
                }
                if(file_type==="reportLP"){
                    uTipe=$(this).attr('data-user');
                    file='../report/ReportLoansPending.php?user='+uTipe;
                    urlData='../process/CheckLoansPending.php?user='+uTipe;
                    title1="¿Quieres generar el reporte?";
                    text1="El reporte de devoluciones pendientes se generará en formato PDF y se abrirá en una ventana nueva. Debes esperar unos minutos para que el sistema genere el reporte";
                    text2="Lo sentimos no puedes generar el reporte, no hay devoluciones pendientes de este tipo de usuario";
                }
                swal({
                    title: title1,
                    text: text1,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#31B0D5",
                    confirmButtonText: "Si, generar",
                    cancelButtonText: "No, cancelar",
                    animation: "slide-from-top",
                    closeOnConfirm: false
                },function(){
                    $.ajax({
                        url:urlData,
                        success:function(data){
                            if(data==="Avaliable"){
                                window.open(file,"_blank");
                                swal.close();
                            }else if (data==="NotAvaliable"){
                                swal({
                                   title:"¡Ocurrió un error inesperado!",
                                   text: text2,
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
        });
    </script>
</head>
<body>
    <?php 
        include '../library/configServer.php';
        include '../library/consulSQL.php';
        include '../library/SelectMonth.php';
        include '../process/SecurityAdmin.php';
        include '../inc/NavLateral.php';
    ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php 
            include '../inc/NavUserInfo.php';
        ?>
        <div class="container">
            <div class="page-header">
              <h1 class="all-tittles">Sistema bibliotecario <small>Reportes y estadísticas</small></h1>
            </div>
        </div>
        <div class="container-fluid">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#statistics" aria-controls="statistics" role="tab" data-toggle="tab">Estadísticas</a></li>
                <li role="presentation"><a href="#bitacora" aria-controls="bitacora" role="tab" data-toggle="tab">Bitácora</a></li>
                <li role="presentation"><a href="#reports" aria-controls="reports" role="tab" data-toggle="tab">Reportes y fichas</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="statistics">
                    <div class="container-fluid"  style="margin: 50px 0;">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <img src="../assets/img/chart.png" alt="chart" class="img-responsive center-box" style="max-width: 120px;">
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                                Bienvenido al área de estadísticas, aquí puedes ver las diferentes estadísticas de los préstamos y libros.
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid"><?php include '../inc/graph.php'; ?></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="bitacora">
                    <div class="container-fluid"  style="margin: 50px 0;">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <img src="../assets/img/user-sesion.png" alt="users-sesion" class="img-responsive center-box" style="max-width: 120px;">
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                                Bienvenido al área de bitácora, aquí se muestran los registros de los últimos 15 usuarios (personal administrativo, docentes, administradores y estudiantes) que han iniciado sesión en el sistema. Recuerda eliminar los registros de la bitácora cada año para que el sistema funcione correctamente.
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid"><?php include '../inc/bitacora.php'; ?></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="reports">
                    <div class="container-fluid"  style="margin: 50px 0;">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <img src="../assets/img/pdf.png" alt="pdf" class="img-responsive center-box" style="max-width: 120px;">
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                                Bienvenido al área de reportes, aquí puedes generar fichas de préstamos vacías de estudiantes, docentes o visitantes en formato pdf, también puedes generar reportes de inventario entre otros.
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="page-header">
                              <h2 class="all-tittles">fichas <small>vacías</small></h2>
                            </div><br>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-file-text zmdi-hc-5x btn-file" data-file="../report/fichaEN.php" data-type="file"></i>
                                    </p>
                                    <h3 class="text-center">Ficha estudiante</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-file-text zmdi-hc-5x btn-file" data-file="../report/fichaDN.php" data-type="file"></i>
                                    </p>
                                    <h3 class="text-center">Ficha docente</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-file-text zmdi-hc-5x btn-file" data-file="../report/fichaPN.php" data-type="file"></i>
                                    </p>
                                    <h3 class="text-center">Ficha personal administrativo</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-file-text zmdi-hc-5x btn-file" data-file="../report/fichaVN.php" data-type="file"></i>
                                    </p>
                                    <h3 class="text-center">Ficha visitante</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="page-header">
                              <h2 class="all-tittles">reportes <small>generales</small></h2>
                            </div><br>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-trending-up zmdi-hc-5x btn-file" data-file="../report/ReportGeneral.php" data-check="../process/check-inventory.php" data-type="report"></i>
                                    </p>
                                    <h3 class="text-center">Reporte General de Inventario</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-trending-up zmdi-hc-5x btn-file" data-file="../report/ReportBookCategories.php" data-check="../process/check-inventory.php" data-type="report"></i>
                                    </p>
                                    <h3 class="text-center">Reporte Libros por Categoría</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-trending-up zmdi-hc-5x btn-file" data-file="../report/ReportAllLoans.php" data-check="../process/CheckAllLoans.php" data-type="report"></i>
                                    </p>
                                    <h3 class="text-center">Préstamos entregados (por usuarios)</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-trending-up zmdi-hc-5x btn-file" data-file="../report/ReportAllLoansBySection.php" data-check="../process/CheckAllLoansStudent.php" data-type="report"></i>
                                    </p>
                                    <h3 class="text-center">Préstamos entregados (por sección)</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="page-header">
                                <h2 class="all-tittles">reportes <small>devoluciones pendientes</small></h2>
                            </div><br>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-calendar-close zmdi-hc-5x btn-file" data-type="reportLP" data-user="Teacher"></i>
                                    </p>
                                    <h3 class="text-center">Docentes</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-calendar-close zmdi-hc-5x btn-file" data-type="reportLP" data-user="Personal"></i>
                                    </p>
                                    <h3 class="text-center">Personal Administrativo</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-calendar-close zmdi-hc-5x btn-file" data-type="reportLP" data-user="Student"></i>
                                    </p>
                                    <h3 class="text-center">Estudiantes</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="full-reset report-content">
                                    <p class="text-center">
                                        <i class="zmdi zmdi-calendar-close zmdi-hc-5x btn-file" data-type="reportLP" data-user="Visitor"></i>
                                    </p>
                                    <h3 class="text-center">Visitantes</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <?php include '../help/help-adminreport.php'; ?>
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