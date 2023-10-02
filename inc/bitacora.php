<section id="cd-timeline" class="cd-container">
    <?php
        $selectBita=ejecutarSQL::consultar("SELECT * FROM bitacora ORDER BY Fecha DESC, Entrada DESC LIMIT 15");
        $c=0;
        while($row=mysqli_fetch_array($selectBita, MYSQLI_ASSOC)){
            $c=$c+1;
            if($row['Tipo']=='Administrador'){
                $selectName=ejecutarSQL::consultar("SELECT * FROM administrador WHERE CodigoAdmin='".$row['CodigoUsuario']."'");
                $dataUser=mysqli_fetch_array($selectName, MYSQLI_ASSOC);
                $nameUser=$dataUser['Nombre'];
                $img='../assets/img/user01.png';
                $type='Administrador';
            }elseif ($row['Tipo']=='Docente'){
                $selectName=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$row['CodigoUsuario']."'");
                $dataUser=mysqli_fetch_array($selectName, MYSQLI_ASSOC);
                $nameUser=$dataUser['Nombre']." ".$dataUser['Apellido'];
                $img='../assets/img/user02.png';
                $type='Docente';
            }elseif ($row['Tipo']=='Estudiante'){
                $selectName=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE NIE='".$row['CodigoUsuario']."'");
                $dataUser=mysqli_fetch_array($selectName, MYSQLI_ASSOC);
                $nameUser=$dataUser['Nombre']." ".$dataUser['Apellido'];
                $img='../assets/img/user03.png';
                $type='Estudiante';
            }elseif ($row['Tipo']=='Personal'){
                $selectName=ejecutarSQL::consultar("SELECT * FROM personal WHERE DUI='".$row['CodigoUsuario']."'");
                $dataUser=mysqli_fetch_array($selectName, MYSQLI_ASSOC);
                $nameUser=$dataUser['Nombre']." ".$dataUser['Apellido'];
                $img='../assets/img/user05.png';
                $type='Personal administrativo';
            }
            $SelectDay=date("d",strtotime($row['Fecha']));
            $SelectMonth=date("m",strtotime($row['Fecha']));
            $SelectYear=date("Y",strtotime($row['Fecha']));
            $SelectMontName=CalMonth::CurrentMonth($SelectMonth);
            $SelectDate=$SelectDay.' de '.$SelectMontName.' de '.$SelectYear;
            echo '<div class="cd-timeline-block">
                <div class="cd-timeline-img">
                    <img src="'.$img.'" alt="user-picture">
                </div>
                <div class="cd-timeline-content">
                    <h4 class="text-center">'.$c.' - '.$nameUser.' ('.$type.')</h4>
                    <p class="text-center"><i class="zmdi zmdi-timer zmdi-hc-fw"></i> Inicio: <em>'.$row['Entrada'].'</em> &nbsp;&nbsp;&nbsp; <i class="zmdi zmdi-time zmdi-hc-fw"></i> Finalización: <em>'.$row['Salida'].'</em></p>
                    <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> '.$SelectDate.'</span>
                </div>
            </div>';
            mysqli_free_result($selectName);
        }
        mysqli_free_result($selectBita);
    ?>
</section>