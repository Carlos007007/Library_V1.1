<!DOCTYPE html>
<html lang="es">
<head>
    <title>Estudiantes</title>
    <?php
        session_start();
        $LinksRoute="../";
        include '../inc/links.php'; 
    ?>
    <script type="text/javascript" src="../js/jPages.js"></script>
    <script src="../js/SendForm.js"></script>
    <script>
        $(document).ready(function(){
            $(function(){
              $("div.holder").jPages({
                containerID : "itemContainer",
                perPage: 20
              });
            });
            $('.list-catalog-container li').click(function(){
               window.location="adminliststudent.php?StudentS="+$(this).attr("data-code-section");
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
        $StudentS=consultasSQL::CleanStringText($_GET['StudentS']);
        $StudentN=consultasSQL::CleanStringText($_GET['StudentN']);
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
        <div class="conteiner-fluid">
            <ul class="nav nav-tabs nav-justified"  style="font-size: 17px;">
              <li role="presentation"><a href="adminuser.php">Administradores</a></li>
              <li role="presentation"><a href="adminteacher.php">Docentes</a></li>
              <li role="presentation"  class="active"><a href="adminstudent.php">Estudiantes</a></li>
              <li role="presentation"><a href="adminpersonal.php">Personal administrativo</a></li>
            </ul>
        </div>
        <div class="container-fluid"  style="margin: 50px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="../assets/img/user03.png" alt="user" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido a la sección donde se encuentra el listado de estudiantes de la institución, podrás buscar los estudiantes por sección o nombre. Puedes actualizar o eliminar los datos del estudiante.<br>
                    <strong class="text-danger"><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Importante! </strong>Si eliminas el estudiante del sistema se borrarán todos los datos relacionados con él, incluyendo préstamos y registros en la bitácora.
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 lead">
                    <ol class="breadcrumb">
                        <li><a href="adminstudent.php">Nuevo estudiante</a></li>
                        <li class="active">Listado de estudiantes</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="margin: 0 0 50px 0;">
            <form class="pull-right" style="width: 30% !important;" action="adminliststudent.php" method="get" autocomplete="off">
                <div class="group-material">
                    <input type="search" style="display: inline-block !important; width: 70%;" class="material-control tooltips-general" placeholder="Buscar estudiante" name="StudentN" required="" pattern="[a-zA-ZáéíóúÁÉÍÓÚ ]{1,50}" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe los nombres, sin los apellidos">
                    <button class="btn" style="margin: 0; height: 43px; background-color: transparent !important;">
                        <i class="zmdi zmdi-search" style="font-size: 25px;"></i>
                    </button>
                </div>
            </form>
            <h2 class="text-center all-tittles" style="margin: 25px 0; clear: both;">Secciones</h2>
            <ul class="list-unstyled text-center list-catalog-container">
                <?php
                    $selectSections=ejecutarSQL::consultar("SELECT * FROM seccion ORDER BY Nombre ASC");
                    while($fila=mysqli_fetch_array($selectSections, MYSQLI_ASSOC)){
                        echo '<li class="list-catalog" data-code-section="'.$fila['CodigoSeccion'].'">'.$fila['Nombre'].'</li>'; 
                    }
                    mysqli_free_result($selectSections);
                ?>
            </ul>
        </div>
        <div class="container-fluid">
            <h2 class="text-center all-tittles">listado de estudiantes</h2>
            <?php
                if(!$StudentN=="" || !$StudentS==""){
                    echo '<div class="table-responsive">
                        <div class="div-table" style="margin:0 !important;">
                            <div class="div-table-row div-table-row-list" style="background-color:#DFF0D8; font-weight:bold;">
                                <div class="div-table-cell" style="width: 6%;">#</div>
                                <div class="div-table-cell" style="width: 18%;">NIE</div>
                                <div class="div-table-cell" style="width: 18%;">Apellidos</div>
                                <div class="div-table-cell" style="width: 18%;">Nombres</div>
                                <div class="div-table-cell" style="width: 18%;">Sección</div>
                                <div class="div-table-cell" style="width: 9%;">Actualizar</div>
                                <div class="div-table-cell" style="width: 9%;">Eliminar</div>
                            </div>
                        </div>
                    </div>';
                }
                if(!$StudentN==""){
                    $selectStudentByName=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE Nombre LIKE '%".$StudentN."%' ORDER BY Apellido ASC, Nombre ASC");
                    if(mysqli_num_rows($selectStudentByName)>0){
                        echo '<ul id="itemContainer" class="list-unstyled">';
                        $c=1;
                        while($dataSN=mysqli_fetch_array($selectStudentByName, MYSQLI_ASSOC)){
                            $seletSect=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataSN['CodigoSeccion']."'");
                            $dataS=mysqli_fetch_array($seletSect, MYSQLI_ASSOC);
                            echo '<li>
                                <div class="table-responsive">
                                    <div class="div-table" style="margin:0 !important;">
                                        <div class="div-table-row div-table-row-list">
                                            <div class="div-table-cell" style="width: 6%;">'.$c.'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSN['NIE'].'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSN['Apellido'].'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSN['Nombre'].'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataS['Nombre'].'</div>
                                            <div class="div-table-cell" style="width: 9%;"><button class="btn btn-success btn-update" data-code="'.$dataSN['NIE'].'" data-url="../process/SelectDataStudent.php"><i class="zmdi zmdi-refresh"></i></button></div>
                                            <form class="div-table-cell form_SRCB" action="../process/DeleteStudent.php" method="post" data-type-form="delete" style="width: 9%;">
                                                <input value="'.$dataSN['NIE'].'" type="hidden" name="primaryKey">
                                                <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>';
                            mysqli_free_result($seletSect);
                            $c++;
                        }
                        echo '</ul><div class="holder"></div>';
                    }else{
                        echo '<br><br><br><h3 class="text-center all-tittles">No existe ningún estudiante registrado con los nombres "'.$StudentN.'"</h3><br><br>';
                    }
                    mysqli_free_result($selectStudentByName);
                }else if(!$StudentS==""){
                    $selectStudentBySection=ejecutarSQL::consultar("SELECT * FROM estudiante WHERE CodigoSeccion='".$StudentS."' ORDER BY Apellido ASC, Nombre ASC");
                    if(mysqli_num_rows($selectStudentBySection)>0){
                        echo '<ul id="itemContainer" class="list-unstyled">';
                        $c=1;
                        while($dataSS=mysqli_fetch_array($selectStudentBySection, MYSQLI_ASSOC)){
                            $seletSect=ejecutarSQL::consultar("SELECT * FROM seccion WHERE CodigoSeccion='".$dataSS['CodigoSeccion']."'");
                            $dataSt=mysqli_fetch_array($seletSect, MYSQLI_ASSOC);
                            echo '<li>
                                <div class="table-responsive">
                                    <div class="div-table" style="margin:0 !important;">
                                        <div class="div-table-row div-table-row-list">
                                            <div class="div-table-cell" style="width: 6%;">'.$c.'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSS['NIE'].'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSS['Apellido'].'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSS['Nombre'].'</div>
                                            <div class="div-table-cell" style="width: 18%;">'.$dataSt['Nombre'].'</div>
                                            <div class="div-table-cell" style="width: 9%;"><button class="btn btn-success btn-update" data-code="'.$dataSS['NIE'].'" data-url="../process/SelectDataStudent.php"><i class="zmdi zmdi-refresh"></i></button></div>
                                            <form class="div-table-cell form_SRCB" action="../process/DeleteStudent.php" method="post" data-type-form="delete" style="width: 9%;">
                                                <input value="'.$dataSS['NIE'].'" type="hidden" name="primaryKey">
                                                <button type="submit" class="btn btn-danger"><i class="zmdi zmdi-delete"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>';
                            mysqli_free_result($seletSect);
                            $c++;
                        }
                        echo '</ul><div class="holder"></div>';
                    }else{
                        echo '<br><br><br><h3 class="text-center all-tittles">No hay estudiantes registrados en esta sección</h3><br><br>';
                    }
                    mysqli_free_result($selectStudentBySection);
                }else{
                    echo '<br><br><br><h3 class="text-center all-tittles">Selecciona una sección o busca un estudiante por sus nombres</h3><br><br>';
                }
            ?>
        </div>
        <div class="msjFormSend"></div>
        <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form class="form_SRCB modal-content" action="../process/UpdateStudent.php" method="post" data-type-form="update"  autocomplete="off">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center all-tittles">Actualizar datos de estudiante</h4>
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
                    <?php include '../help/help-adminliststudent.php'; ?>
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