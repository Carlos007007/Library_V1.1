<!DOCTYPE html>
<html lang="es">
<head>
    <title>Prestamos</title>
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
           $('.btn-file-loan').click(function(){
               var user=$(this).attr('data-user');
               var codeL=$(this).attr('data-code-loan');
               swal({
                    title: "¿Quieres ver la ficha?",
                    text: "La ficha se generará en formato PDF y se abrirá una ventana nueva. Debes esperar un lapso de tiempo de 15 segundos para que el sistema genere la ficha",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#31B0D5",
                    confirmButtonText: "Si, ver ficha",
                    cancelButtonText: "No, cancelar",
                    animation: "slide-from-top",
                    closeOnConfirm: true 
                },function(){
                    if(user==="Docente"){
                       var file="../report/fichaDN.php?loanCode="+codeL;
                       window.open(file,"_blank");
                   }else if(user==="Estudiante"){
                       var file="../report/fichaEN.php?loanCode="+codeL;
                       window.open(file,"_blank");
                   }else if(user==="Visitante"){
                       var file="../report/fichaVN.php?loanCode="+codeL;
                       window.open(file,"_blank");
                   }else if(user==="Personal"){
                       var file="../report/fichaPN.php?loanCode="+codeL;
                       window.open(file,"_blank");
                   }else{
                        swal({
                           title:"¡Ocurrió un error inesperado!",
                           text:"Hemos tenido un error, por favor recarga la página e intenta nuevamente",
                           type: "error",
                           confirmButtonText: "Aceptar"
                        });
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
              <h1 class="all-tittles">Sistema bibliotecario <small>préstamos y reservaciones</small></h1>
            </div>
        </div>
        <div class="conteiner-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
                <li><a href="adminloan.php">Todos los préstamos</a></li>
                <li class="active"><a href="adminloanpending.php">Devoluciones pendientes</a></li>
                <li><a href="adminreservation.php">Reservaciones</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/clock.png" alt="calendar" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a esta sección, aquí se muestran todos los préstamos de libros que no han sido devueltos por los docentes y estudiantes
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h2 class="text-center all-tittles">Listado de devoluciones pendientes</h2>
            <?php
                $checkLoansPending=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Prestamo' ORDER BY FechaEntrega ASC");
                if(mysqli_num_rows($checkLoansPending)>=1){
                    echo '<div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;">
                            <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                                <div class="div-table-cell" style="width: 6%;">#</div>
                                <div class="div-table-cell" style="width: 22%;">Nombre de libro</div>
                                <div class="div-table-cell" style="width: 22%;">Nombre de usuario</div>
                                <div class="div-table-cell" style="width: 10%;">Tipo</div>
                                <div class="div-table-cell" style="width: 10%;">F. Solicitud</div>
                                <div class="div-table-cell" style="width: 10%;">F. Entrega</div>
                                <div class="div-table-cell" style="width: 8%;">Recibir</div>
                                <div class="div-table-cell" style="width: 8%;">Ver Ficha</div>
                            </div>
                        </div>
                    </div>';
                    $f=0;
                    echo '<ul id="itemContainer" class="list-unstyled">';
                    while($data=mysqli_fetch_array($checkLoansPending, MYSQLI_ASSOC)){
                        $f++;
                        $checkLoanU1=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkLoanU1)>=1){
                            $dataU1=mysqli_fetch_array($checkLoanU1, MYSQLI_ASSOC);
                            $selectTeacherData=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$dataU1['DUI']."'");
                            $dataT=mysqli_fetch_array($selectTeacherData, MYSQLI_ASSOC);
                            $nameUser=$dataT['Nombre']." ".$dataT['Apellido'];
                            $typeUser='Docente';
                        }
                        $checkLoanU2=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkLoanU2)>=1){
                            $dataU2=mysqli_fetch_array($checkLoanU2, MYSQLI_ASSOC);
                            $selectStudentData=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$dataU2['NIE']."'");
                            $dataS=mysqli_fetch_array($selectStudentData, MYSQLI_ASSOC);
                            $nameUser=$dataS['Nombre']." ".$dataS['Apellido'];
                            $typeUser='Estudiante';
                        }
                        $checkLoanU3=ejecutarSQL::consultar("SELECT * FROM prestamovisitante WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkLoanU3)>=1){
                            $dataU3=mysqli_fetch_array($checkLoanU3, MYSQLI_ASSOC);
                            $nameUser=$dataU3['Nombre'];
                            $typeUser='Visitante';
                        }
                        $checkLoanU4=ejecutarSQL::consultar("SELECT * FROM prestamopersonal WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkLoanU4)>=1){
                            $dataU4=mysqli_fetch_array($checkLoanU4, MYSQLI_ASSOC);
                            $selectPersonalData=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$dataU4['DUI']."'");
                            $dataP=mysqli_fetch_array($selectPersonalData, MYSQLI_ASSOC);
                            $nameUser=$dataP['Nombre']." ".$dataP['Apellido'];
                            $typeUser='Personal';
                        }
                        $selecBook=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$data['CodigoLibro']."'");
                        $file=mysqli_fetch_array($selecBook, MYSQLI_ASSOC);
                        $SelectMonth=date("m",strtotime($data['FechaSalida']));
                        $SelectYear=date("Y",strtotime($data['FechaSalida']));
                        $SelectMontName=CalMonth::CurrentMonth($SelectMonth);
                        $SelectDate=$SelectMontName.' '.$SelectYear;
                        if($CurrentDate!=$SelectDate){
                            $CurrentDate=$SelectDate;
                            echo '<div class="table-responsive">
                                <div class="div-table" style="margin:0 !important;">
                                    <div class="div-table-row div-table-row-list" style="background-color:#B2EBF2; font-weight:bold;">
                                        <p class="text-center all-tittles" style="margin: 0;">'.$CurrentDate.'</p>
                                    </div>
                                </div>
                            </div>';
                        }
                        echo '<li>
                            <div class="table-responsive">
                                <div class="div-table" style="margin:0 !important;">
                                    <div class="div-table-row div-table-row-list">
                                        <div class="div-table-cell" style="width: 6%;">'.$f.'</div>
                                        <div class="div-table-cell" style="width: 22%;">'.$file['Titulo'].'</div>
                                        <div class="div-table-cell" style="width: 22%;">'.$nameUser.'</div>
                                        <div class="div-table-cell" style="width: 10%;">'.$typeUser.'</div>
                                        <div class="div-table-cell" style="width: 10%;">'.$data['FechaSalida'].'</div>
                                        <div class="div-table-cell" style="width: 10%;">'.$data['FechaEntrega'].'</div>
                                        <form action="../process/UpdateLoan.php" method="post" class="div-table-cell form_SRCB" data-type-form="receiveLoan" style="width: 8%;">
                                            <input type="hidden" value="'.$data['CodigoPrestamo'].'" name="LoanKey">
                                            <input type="hidden" value="'.$data['CodigoLibro'].'" name="BookKey">
                                            <input type="hidden" value="'.$typeUser.'" name="typeUser">
                                            <button type="submit" class="btn btn-success"><i class="zmdi zmdi-time-restore"></i></button>
                                        </form>
                                        <div class="div-table-cell" style="width: 8%;"><button class="btn btn-info btn-file-loan" data-user="'.$typeUser.'" data-code-loan="'.$data['CodigoPrestamo'].'"><i class="zmdi zmdi-file-text"></i></button></div>
                                    </div>
                                </div>
                            </div>
                        </li>';
                        mysqli_free_result($checkLoanU1);
                        mysqli_free_result($checkLoanU2);
                        mysqli_free_result($checkLoanU3);
                        mysqli_free_result($checkLoanU4);
                        mysqli_free_result($selectTeacherData);
                        mysqli_free_result($selectStudentData);
                        mysqli_free_result($selectPersonalData);
                        mysqli_free_result($selecBook);
                    }
                    echo '</ul><div class="holder"></div>';
                }else{
                    echo '<br><br><br><p class="lead text-center all-tittles">No hay devoluciones pendientes</p><br><br><br><br><br><br>';
                }
                mysqli_free_result($checkLoansPending);
            ?>
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
                    <?php include '../help/help-adminloanpending.php'; ?>
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