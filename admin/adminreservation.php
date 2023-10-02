<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reservaciones</title>
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
                    perPage: 15
                });
            });
            $('.btn-reservation').on('click', function(){
                var codeLoan=$(this).attr('data-code-loan');
                var userType=$(this).attr('data-user');
                $.ajax({
                    url:'../process/checkReservationData.php',
                    type: 'POST',
                    data: 'codeLoan='+codeLoan+'&userType='+userType,
                    success:function(data){
                        $('#modalDataLoan').html(data);
                        $('#modalR').modal({
                            show: true,
                            backdrop: "static"
                        });
                    }
                });
                return false;
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
                <li><a href="adminloanpending.php">Devoluciones pendientes</a></li>
                <li class="active"><a href="adminreservation.php">Reservaciones</a></li>
            </ul>
        </div>
         <div class="container-fluid" style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/calendar.png" alt="clock" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a esta sección, aquí se muestran las reservaciones de libros hechas por los docentes y estudiantes, las cuales están pendientes para ser aprobadas por ti
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h2 class="text-center all-tittles">Listado de reservaciones</h2>
            <?php
                $checkingRservations=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Reservacion' ORDER BY FechaSalida ASC");
                if(mysqli_num_rows($checkingRservations)>=1){
                    echo '<div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;">
                            <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                                <div class="div-table-cell" style="width: 6%;">#</div>
                                <div class="div-table-cell" style="width: 22%;">Nombre de libro</div>
                                <div class="div-table-cell" style="width: 22%;">Nombre de usuario</div>
                                <div class="div-table-cell" style="width: 10%;">Tipo</div>
                                <div class="div-table-cell" style="width: 10%;">F. Solicitud</div>
                                <div class="div-table-cell" style="width: 10%;">F. Entrega</div>
                                <div class="div-table-cell" style="width: 8%;">Aprobar</div>
                                <div class="div-table-cell" style="width: 8%;">Eliminar</div>
                            </div>
                        </div>
                    </div>';
                    $y=0;
                    echo '<ul id="itemContainer" class="list-unstyled">';
                    while($data=mysqli_fetch_array($checkingRservations, MYSQLI_ASSOC)){
                        $y++;
                        $checkReserU1=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkReserU1)>=1){
                            $dataU1=mysqli_fetch_array($checkReserU1, MYSQLI_ASSOC);
                            $selectTeacherData=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$dataU1['DUI']."'");
                            $dataT=mysqli_fetch_array($selectTeacherData, MYSQLI_ASSOC);
                            $nameUser=$dataT['Nombre']." ".$dataT['Apellido'];
                            $typeUser='Docente';
                            $table="prestamodocente";
                        }
                        $checkReserU2=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkReserU2)>=1){
                            $dataU2=mysqli_fetch_array($checkReserU2, MYSQLI_ASSOC);
                            $selectStudentData=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$dataU2['NIE']."'");
                            $dataS=mysqli_fetch_array($selectStudentData, MYSQLI_ASSOC);
                            $nameUser=$dataS['Nombre']." ".$dataS['Apellido'];
                            $typeUser='Estudiante';
                            $table="prestamoestudiante";
                        }
                        $checkReserU3=ejecutarSQL::consultar("SELECT * FROM prestamopersonal WHERE CodigoPrestamo='".$data['CodigoPrestamo']."'");
                        if(mysqli_num_rows($checkReserU3)>=1){
                            $dataU3=mysqli_fetch_array($checkReserU3, MYSQLI_ASSOC);
                            $selectPersonalData=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$dataU3['DUI']."'");
                            $dataP=mysqli_fetch_array($selectPersonalData, MYSQLI_ASSOC);
                            $nameUser=$dataP['Nombre']." ".$dataP['Apellido'];
                            $typeUser='Personal';
                            $table="prestamopersonal";
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
                                        <div class="div-table-cell" style="width: 6%;">'.$y.'</div>
                                        <div class="div-table-cell" style="width: 22%;">'.$file['Titulo'].'</div>
                                        <div class="div-table-cell" style="width: 22%;">'.$nameUser.'</div>
                                        <div class="div-table-cell" style="width: 10%;">'.$typeUser.'</div>
                                        <div class="div-table-cell" style="width: 10%;">'.$data['FechaSalida'].'</div>
                                        <div class="div-table-cell" style="width: 10%;">'.$data['FechaEntrega'].'</div>
                                        <div class="div-table-cell" style="width: 8%;"><button class="btn btn-success btn-reservation" data-user="'.$typeUser.'" data-code-loan="'.$data['CodigoPrestamo'].'"><i class="zmdi zmdi-timer"></i></button></div>
                                        <form action="../process/DeleteReservation.php" method="post" class="div-table-cell form_SRCB" data-type-form="deleteReservation" style="width: 8%;">
                                            <input type="hidden" value="'.$data['CodigoPrestamo'].'" name="loanCode">
                                            <input type="hidden" value="'.$table.'" name="userTable">
                                            <input type="hidden" value="adminreservation.php" name="urlRefresh">
                                            <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>';
                        mysqli_free_result($checkReserU1);
                        mysqli_free_result($checkReserU2);
                        mysqli_free_result($checkReserU3);
                        mysqli_free_result($selectTeacherData);
                        mysqli_free_result($selectStudentData);
                        mysqli_free_result($selecBook);
                        mysqli_free_result($selectPersonalData);
                    }
                    echo '</ul><div class="holder"></div>';
                }else{
                    echo '<br><br><br><p class="lead text-center all-tittles">No hay reservaciones pendientes</p><br><br><br><br><br><br>';
                }
                mysqli_free_result($checkingRservations);
            ?>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalR">
            <div class="modal-dialog" role="document">
                <form class="modal-content form_SRCB" action="../process/UpdateReservation.php" method="post" data-type-form="approveReservation" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title all-tittles text-center">selecciona el código correlativo</h4>
                    </div>
                    <div class="modal-body" id="modalDataLoan"></div>
                    <input type="hidden" name="AdminCode" value="<?php echo $_SESSION['primaryKey']; ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success"><i class="zmdi zmdi-timer"></i>&nbsp; Aprobar reservación</button>
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
                    <?php include '../help/help-adminreservation.php'; ?>
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