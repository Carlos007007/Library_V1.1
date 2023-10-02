<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeLoan=consultasSQL::CleanStringText($_POST['codeLoan']);
$userType=consultasSQL::CleanStringText($_POST['userType']);
if($userType=="Docente"){ $fileUser="fichaDN"; }
if($userType=="Estudiante"){ $fileUser="fichaEN"; }
if($userType=="Personal"){ $fileUser="fichaPN"; }
$selectDataL=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='$codeLoan'");
$dataL=mysqli_fetch_array($selectDataL, MYSQLI_ASSOC);
if(mysqli_num_rows($selectDataL)>=1){
    $selectDataB=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$dataL['CodigoLibro']."'");
    $fila=mysqli_fetch_array($selectDataB, MYSQLI_ASSOC);
    $totalBook=$fila['Existencias']-$fila['Prestado'];
    if($totalBook>=1){
        echo "<p><strong>Hay ".$totalBook." libros disponibles de ".$fila['Titulo']." para prestar.</strong></p>";
        if($userType=="Docente"){
            $selectDataLT=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE CodigoPrestamo='$codeLoan'");
            $dataLT=mysqli_fetch_array($selectDataLT, MYSQLI_ASSOC);
            echo '<div class="alert alert-info text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante!:<br></strong>El docente ha solicitado prestar <strong>'.$dataLT['Cantidad'].' libros</strong>. Para aprobar el préstamo selecciona los códigos correlativos de los libros a prestar y haz click el botón "Aprobar reservación"</div><div class="group-material"><span><strong>Códigos correlativos</strong></span><br><br>';
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
            echo '</div>';
        }else{
            echo '<div class="alert alert-info text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante!:</strong> Para aprobar el préstamo selecciona el código correlativo del libro a prestar y haz click el botón "Aprobar reservación"</div>';
            echo '<div class="group-material"><span>Código correlativo</span><select class="tooltips-general material-control" name="bookCorrelative" data-toggle="tooltip" data-placement="top" title="Elige el código correlativo del libro">';
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
            echo '</select><span class="highlight"></span><span class="bar"></span></div>';
        }
    }else{
        echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante!:</strong><br>No hay libros disponibles para realizar el préstamo.</div>';
    }
    echo '<input type="hidden" value="'.$userType.'" name="userType" ><input type="hidden" value="'.$dataL['CodigoLibro'].'" name="bookCode" ><input type="hidden" value="'.$dataL['CodigoPrestamo'].'" name="loanCode" ><input type="hidden" value="'.$fileUser.'" name="userFile" >';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($selectDataL);
mysqli_free_result($selectDataB);
mysqli_free_result($selectDataLT);