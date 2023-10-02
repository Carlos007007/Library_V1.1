<!DOCTYPE html>
<html lang="es">
<head>
    <title>Catálogo</title>
    <?php
        session_start();
        $LinksRoute="./";
        include './inc/links.php'; 
    ?>
    <script type="text/javascript" src="js/jPages.js"></script>
    <script>
        $(document).ready(function(){
            $(function(){
              $("div.holder").jPages({
                containerID : "itemContainer",
                perPage: 20
              });
            });
           $('.btn-info-book').click(function(){
               window.location ="infobook.php?codeBook="+$(this).attr("data-code-book");
           });
           $('.list-catalog-container li').click(function(){
               window.location="catalog.php?CategoryCode="+$(this).attr("data-code-category");
           });
        });
    </script>
</head>
<body>
    <?php 
        include './library/configServer.php';
        include './library/consulSQL.php';
        include './process/SecurityUser.php';
        $VarCategoryCatalog=consultasSQL::CleanStringText($_GET['CategoryCode']);
        include './inc/NavLateral.php';
    ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php 
            include './inc/NavUserInfo.php';  
        ?>
        <div class="container">
            <div class="page-header">
              <h1 class="all-tittles">Sistema bibliotecario <small>Catálogo de libros</small></h1>
            </div>
        </div>
         <div class="container-fluid"  style="margin: 40px 0;">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <img src="assets/img/checklist.png" alt="pdf" class="img-responsive center-box" style="max-width: 110px;">
                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 text-justify lead">
                    Bienvenido al catálogo, selecciona una categoría de la lista para empezar, si deseas buscar un libro por nombre o título has click en el icono &nbsp; <i class="zmdi zmdi-search"></i> &nbsp; que se encuentra en la barra superior
                </div>
            </div>
        </div>
        <?php
            $checkingAllBooks=ejecutarSQL::consultar("SELECT * FROM libro");
            if(mysqli_num_rows($checkingAllBooks)>0){
                echo '<div class="container-fluid" style="margin: 0 0 50px 0;"><h2 class="text-center" style="margin: 0 0 25px 0;">Categorías</h2><ul class="list-unstyled text-center list-catalog-container">';
                $checkCategory=ejecutarSQL::consultar("SELECT * FROM categoria order by Nombre ASC");
                if(mysqli_num_rows($checkCategory)>0){
                    while($fila=mysqli_fetch_array($checkCategory, MYSQLI_ASSOC)){
                        echo '<li class="list-catalog" data-code-category="'.$fila['CodigoCategoria'].'">'.$fila['Nombre'].'</li>'; 
                    }  
                }else{
                    echo '<p class="lead text-center all-tittles">No hay categorías registradas</p>';
                }
                mysqli_free_result($checkCategory);  
                echo '</ul></div>';
                if($VarCategoryCatalog==''){
                    echo '<p class="text-center lead all-tittles" style="padding: 0 25px;">Selecciona una categoría para empezar</p><br><br><br><br><br><br>';
                }else{
                    $checkCodeBook=ejecutarSQL::consultar("select * from libro where CodigoCategoria='".$VarCategoryCatalog."' order by Titulo ASC");
                    if(mysqli_num_rows($checkCodeBook)>0){
                            $selectCategC=ejecutarSQL::consultar("select * from categoria where CodigoCategoria='".$VarCategoryCatalog."'");
                            $dataCategC=mysqli_fetch_array($selectCategC, MYSQLI_ASSOC);
                            echo '<p class="text-center lead all-tittles" style="padding: 0 25px;">Se muestran los libros de la categoría '.$dataCategC['Nombre'].'</p><br>';
                            mysqli_free_result($selectCategC);
                            echo '<div class="container-fluid">
                                <ul id="itemContainer" class="list-unstyled">';
                                    $countBook=1;
                                    while ($bookCodeInfo=mysqli_fetch_array($checkCodeBook, MYSQLI_ASSOC)){
                                    echo '<li>
                                        <div class="media media-hover">
                                          <div class="media-left media-middle">
                                              <a href="infobook.php?codeBook='.$bookCodeInfo['CodigoLibro'].'" class="tooltips-general" data-toggle="tooltip" data-placement="right" title="Más información del libro">
                                                  <img class="media-object" src="assets/img/book.png" alt="Libro" width="48" height="48">
                                              </a>
                                          </div>
                                          <div class="media-body">
                                            <h4 class="media-heading">'.$countBook.' - '.$bookCodeInfo['Titulo'].'</h4>
                                            <div class="pull-left">
                                                <strong>Autor: </strong>'.$bookCodeInfo['Autor'].'<br>
                                                <strong>Año: </strong>'.$bookCodeInfo['Year'].'<br>
                                            </div>
                                            <p class="text-center pull-right">
                                                <a href="#" class="btn btn-info btn-xs btn-info-book" style="margin-right: 10px;" data-code-book="'.$bookCodeInfo['CodigoLibro'].'"><i class="zmdi zmdi-info-outline"></i> &nbsp;&nbsp; Más información</a>
                                            </p>
                                          </div>
                                        </div>
                                    </li>';
                                   $countBook=$countBook+1;
                                }
                                echo '</ul>
                                <div class="holder"></div>
                            </div>';    
                    }else{
                        echo '<br><br><br><p class="lead text-center all-tittles">No hay libros registrados en esta categoría</p><br><br><br><br><br><br>'; 
                    }
                    mysqli_free_result($checkCodeBook);
                }
            }else{
                echo '<br><br><br><p class="lead text-center all-tittles">No hay libros registrados en el sistema</p><br><br><br><br><br><br>';
            }
            mysqli_free_result($checkingAllBooks);
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    <?php include './help/help-catalog.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="zmdi zmdi-thumb-up"></i> &nbsp; De acuerdo</button>
                </div>
            </div>
          </div>
        </div>
        <?php include './inc/footer.php'; ?>
    </div>
</body>
</html>