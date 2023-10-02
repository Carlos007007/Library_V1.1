<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
              <h1 class="all-tittles">realizar <small>préstamo</small></h1>
            </div>
            <p class="lead">
                Para realizar un préstamo llena los campos correspondientes a el usuario que realizara el préstamo del libro
            </p>
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#loan1" aria-controls="home" role="tab" data-toggle="tab">Préstamo Estudiante</a></li>
                <li role="presentation"><a href="#loan2" aria-controls="profile" role="tab" data-toggle="tab">Préstamo Docente</a></li>
                <li role="presentation"><a href="#loan3" aria-controls="messages" role="tab" data-toggle="tab">Préstamo personal ad.</a></li>
                <li role="presentation"><a href="#loan4" aria-controls="messages" role="tab" data-toggle="tab">Préstamo Visitante</a></li>
            </ul>
            <div class="tab-content" style="padding: 50px 0;">
                <div role="tabpanel" class="tab-pane fade in active" id="loan1">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <form action="process/AddLoanUsers.php" method="post" class="form_SRCB" data-type-form="saveLoan" autocomplete="off">
                                <?php
                                    echo '<input type="hidden"  name="bookCode" value="'.$codeBook.'">';
                                    echo '<input type="hidden"  name="adminCode" value="'.$_SESSION['primaryKey'].'">';
                                    echo '<input type="hidden"  name="userType" value="'.$_SESSION['UserPrivilege'].'">';
                                    echo '<input type="hidden"  name="userLoan" value="Student">';
                                ?>
                                <div class="group-material">
                                    <span>Código correlativo</span>
                                    <select class="tooltips-general material-control" name="bookCorrelative" data-toggle="tooltip" data-placement="top" title="Elige el código correlativo del libro">
                                        <?php
                                            for($c=1;$c<=$fila['Existencias'];$c++){
                                                if($c>=100){
                                                   $correl=substr($fila['CodigoCorrelativo'], 0, -2);
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>';
                                                }elseif($c>=10){
                                                   $correl=substr($fila['CodigoCorrelativo'], 0, -1);
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>';
                                                }elseif($c<10){
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$fila['CodigoCorrelativo'].$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>'; 
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                                <div class="search-box">
                                    <i class="zmdi zmdi-search search-box-icon tooltips-general" data-toggle="tooltip" data-placement="top" title="Haz clic aquí para buscar el NIE del estudiante" data-id="formStudents"></i>
                                    <div class="search-box-form" id="formStudents">
                                        <input type="text" class="material-control inputUsersearch" placeholder="Escribe el nombre del estudiante" data-user="Student" data-res="resultStudents">
                                        <div class="search-box-result" id="resultStudents">
                                        </div>
                                    </div>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" id="inputStudents" placeholder="Escribe aquí el NIE del alumno" name="userKey" required="" maxlength="20" data-toggle="tooltip" data-placement="top" title="NIE de estudiante">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>NIE</label>
                                </div>
                                <div class="group-material">
                                    <span>Fecha de solicitud</span>
                                    <input type="text" readonly class="material-control StarCalendarInput"  data-input="adminStudent" required="" name="startDate" placeholder="Fecha de solicitud">
                                </div>
                                <div class="group-material">
                                    <span>Fecha de entrega</span>
                                    <input type="text" readonly class="material-control EndCalendarInput material-input-disabled" id="inputEnd-adminStudent" required="" name="endDate" placeholder="Primero debes seleccionar la fecha de solicitud">
                                </div>
                                <p class="text-center">
                                    <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                    <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Realizar préstamo</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="loan2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <form action="process/AddLoanTeacher.php" method="post" class="form_SRCB" data-type-form="saveLoan" autocomplete="off"> 
                                <?php
                                    echo '<input type="hidden"  name="bookCode" value="'.$codeBook.'">';
                                    echo '<input type="hidden"  name="adminCode" value="'.$_SESSION['primaryKey'].'">';
                                    echo '<input type="hidden"  name="userType" value="'.$_SESSION['UserPrivilege'].'">';
                                ?>
                                <div class="group-material">
                                    <span>Selecciona los códigos correlativos</span><br><br>
                                    <?php
                                        for($c=1;$c<=$fila['Existencias'];$c++){
                                            if($c>=100){
                                                $correl=substr($fila['CodigoCorrelativo'], 0, -2);
                                                $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                $checkCorrelative=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CorrelativoLibro='".$correlativo."' AND Estado='Prestamo' AND CodigoLibro='".$codeBook."'");
                                                if(mysqli_num_rows($checkCorrelative)<=0){
                                                    echo '<input type="checkbox" class="correlativeBookT" name="bookCorrelative[]" value="'.$correlativo.'"> '.$correlativo.'<br>';
                                                }
                                                mysqli_free_result($checkCorrelative);
                                            }elseif($c>=10){
                                                $correl=substr($fila['CodigoCorrelativo'], 0, -1);
                                                $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                $checkCorrelative=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CorrelativoLibro='".$correlativo."' AND Estado='Prestamo' AND CodigoLibro='".$codeBook."'");
                                                if(mysqli_num_rows($checkCorrelative)<=0){
                                                    echo '<input type="checkbox" class="correlativeBookT" name="bookCorrelative[]" value="'.$correlativo.'"> '.$correlativo.'<br>';
                                                }
                                                mysqli_free_result($checkCorrelative);
                                            }elseif($c<10){
                                                $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$fila['CodigoCorrelativo'].$c;
                                                $checkCorrelative=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CorrelativoLibro='".$correlativo."' AND Estado='Prestamo' AND CodigoLibro='".$codeBook."'");
                                                if(mysqli_num_rows($checkCorrelative)<=0){
                                                    echo '<input type="checkbox" class="correlativeBookT" name="bookCorrelative[]" value="'.$correlativo.'"> '.$correlativo.'<br>';
                                                }
                                                mysqli_free_result($checkCorrelative); 
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="group-material">
                                    <span>Cantidad de libros seleccionados</span>
                                    <input type="num" disabled class="material-control" id="CantL" value="0">
                                    <input type="hidden" class="material-control CantL" name="CantL">
                                </div>
                                <script>
                                    $(document).on('ready', function(){
                                        $('.correlativeBookT').on('click', function(){
                                            var total=parseInt($('#CantL').attr("value"));
                                            var total2;
                                            if($(this).is(':checked')) { 
                                                total2=total+1;
                                                $('#CantL').attr("value",total2); 
                                                $('.CantL').val(total2);
                                            } else {  
                                                total2=total-1;
                                                $('#CantL').attr("value",total2); 
                                                $('.CantL').val(total2); 
                                            }
                                        });
                                    });
                                </script>
                                <div class="search-box">
                                    <i class="zmdi zmdi-search search-box-icon tooltips-general" data-toggle="tooltip" data-placement="top" title="Haz clic aquí para buscar el DUI del docente" data-id="formTeachers"></i>
                                    <div class="search-box-form" id="formTeachers">
                                        <input type="text" class="material-control inputUsersearch" placeholder="Escribe el nombre del docente" data-user="Teacher" data-res="resultTeachers">
                                        <div class="search-box-result" id="resultTeachers">
                                        </div>
                                    </div>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" id="inputTeachers" placeholder="Escribe aquí el número de DUI del docente" name="userKey" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números y guiones, 10 dígitos">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Número de DUI</label>
                                </div>
                                <div class="group-material">
                                    <span>Fecha de solicitud</span>
                                    <input type="text" readonly class="material-control StarCalendarInput" data-input="adminTeacher" required="" name="startDate" placeholder="Fecha de solicitud">
                                </div>
                                <div class="group-material">
                                    <span>Fecha de entrega</span>
                                    <input type="text" readonly class="material-control EndCalendarInput material-input-disabled" id="inputEnd-adminTeacher" required="" name="endDate" placeholder="Primero debes seleccionar la fecha de solicitud">
                                </div>
                                <p class="text-center">
                                    <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                    <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Realizar préstamo</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                <div role="tabpanel" class="tab-pane fade" id="loan3">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <form action="process/AddLoanUsers.php" method="post" class="form_SRCB" data-type-form="saveLoan" autocomplete="off"> 
                                <?php
                                    echo '<input type="hidden"  name="bookCode" value="'.$codeBook.'">';
                                    echo '<input type="hidden"  name="adminCode" value="'.$_SESSION['primaryKey'].'">';
                                    echo '<input type="hidden"  name="userType" value="'.$_SESSION['UserPrivilege'].'">';
                                    echo '<input type="hidden"  name="userLoan" value="Personal">';
                                ?>
                                <div class="group-material">
                                    <span>Código correlativo</span>
                                    <select class="tooltips-general material-control" name="bookCorrelative" data-toggle="tooltip" data-placement="top" title="Elige el código correlativo del libro">
                                        <?php
                                            for($c=1;$c<=$fila['Existencias'];$c++){
                                                if($c>=100){
                                                   $correl=substr($fila['CodigoCorrelativo'], 0, -2);
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>';
                                                }elseif($c>=10){
                                                   $correl=substr($fila['CodigoCorrelativo'], 0, -1);
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>';
                                                }elseif($c<10){
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$fila['CodigoCorrelativo'].$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>'; 
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                                <div class="search-box">
                                    <i class="zmdi zmdi-search search-box-icon tooltips-general" data-toggle="tooltip" data-placement="top" title="Haz clic aquí para buscar el DUI del personal ad." data-id="formPersonals"></i>
                                    <div class="search-box-form" id="formPersonals">
                                        <input type="text" class="material-control inputUsersearch" placeholder="Escribe el nombre del personal ad." data-user="Personal" data-res="resultPersonals">
                                        <div class="search-box-result" id="resultPersonals">
                                        </div>
                                    </div>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" id="inputPersonals" placeholder="Escribe aquí el número de DUI del personal administrativo" name="userKey" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números y guiones, 10 dígitos">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Número de DUI</label>
                                </div>
                                <div class="group-material">
                                    <span>Fecha de solicitud</span>
                                    <input type="text" readonly class="material-control StarCalendarInput" data-input="adminPersonal" required="" name="startDate" placeholder="Fecha de solicitud">
                                </div>
                                <div class="group-material">
                                    <span>Fecha de entrega</span>
                                    <input type="text" readonly class="material-control EndCalendarInput material-input-disabled" id="inputEnd-adminPersonal" required="" name="endDate" placeholder="Primero debes seleccionar la fecha de solicitud">
                                </div>
                                <p class="text-center">
                                    <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                    <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Realizar préstamo</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                <div role="tabpanel" class="tab-pane fade" id="loan4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                            <form action="process/AddLoanVisitor.php" method="post" class="form_SRCB" data-type-form="saveLoan" autocomplete="off"> 
                               <?php
                                    echo '<input type="hidden"  name="bookCode" value="'.$codeBook.'">';
                                    echo '<input type="hidden"  name="adminCode" value="'.$_SESSION['primaryKey'].'">';
                                ?>
                                <div class="group-material">
                                    <span>Código correlativo</span>
                                    <select class="tooltips-general material-control" name="bookCorrelative" data-toggle="tooltip" data-placement="top" title="Elige el código correlativo del libro">
                                        <?php
                                            for($c=1;$c<=$fila['Existencias'];$c++){
                                                if($c>=100){
                                                   $correl=substr($fila['CodigoCorrelativo'], 0, -2);
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>';
                                                }elseif($c>=10){
                                                   $correl=substr($fila['CodigoCorrelativo'], 0, -1);
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$correl.$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>';
                                                }elseif($c<10){
                                                   $correlativo=$fila['CodigoInfraestructura']."-".$fila['CodigoCategoria']."-".$fila['CodigoCorrelativo'].$c;
                                                   echo '<option value="'.$correlativo.'">'.$correlativo.'</option>'; 
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el número de DUI del visitante" name="visitorDUI" pattern="[0-9-]{1,10}" required="" maxlength="10" data-toggle="tooltip" data-placement="top" title="Solamente números y guiones, 10 dígitos">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Número de DUI</label>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el nombre del visitante" name="visitorName" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ]{1,50}" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del visitante, solamente letras">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Nombre</label>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí la institución de donde visita" name="visitorInstitution" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ]{1,60}" required="" maxlength="60" data-toggle="tooltip" data-placement="top" title="Escribe el nombre de la institución de donde visita">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Institución de donde visita</label>
                                </div>
                                <div class="group-material">
                                    <input type="text" class="material-control tooltips-general" placeholder="Escribe aquí el número de teléfono del visitante" name="visitorPhone" pattern="[0-9]{8,8}" required="" maxlength="8" data-toggle="tooltip" data-placement="top" title="Solamente 8 números">
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Teléfono</label>
                                </div>
                                <div class="group-material">
                                    <span>Fecha de solicitud</span>
                                    <input type="text" readonly class="material-control StarCalendarInput" data-input="adminVisitor" required="" name="startDate" placeholder="Fecha de solicitud">
                                </div>
                                <div class="group-material">
                                    <span>Fecha de entrega</span>
                                    <input type="text" readonly class="material-control EndCalendarInput material-input-disabled" id="inputEnd-adminVisitor" required="" name="endDate" placeholder="Primero debes seleccionar la fecha de solicitud">
                                </div>
                                <p class="text-center">
                                    <button type="reset" class="btn btn-info" style="margin-right: 20px;"><i class="zmdi zmdi-roller"></i> &nbsp;&nbsp; Limpiar</button>
                                    <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i> &nbsp;&nbsp; Realizar préstamo</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>