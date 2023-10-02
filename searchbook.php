<!DOCTYPE html>
<html lang="es">
<head>
    <title>Buscar libro</title>
    <?php
        session_start();
        $LinksRoute="./";
        include './inc/links.php'; 
    ?>
    <script src="js/jPages.js"></script>
    <script>
        $(document).ready(function(){
            $(function(){
              $("div.holder").jPages({
                containerID : "itemContainer",
                perPage: 10
              });
            });
           $('.btn-info-book').click(function(){
               window.location ="infobook.php?codeBook="+$(this).attr("data-code-book");
           });
        });
    </script>
</head>
<body>
    <?php 
        include './library/configServer.php';
        include './library/consulSQL.php';
        include './process/SecurityUser.php';
        include './inc/NavLateral.php';
    ?>
    <div class="content-page-container full-reset custom-scroll-containers">
        <?php 
            include './inc/NavUserInfo.php'; 
        ?>
        <div class="container">
            <div class="page-header">
              <h1 class="all-tittles">Sistema bibliotecario <small>Busqueda de libro</small></h1>
            </div>
        </div>
        <br><br><br>
        <?php
        $BookNameSearch=consultasSQL::CleanStringText($_GET["bookName"]);
        $checkNameBook= ejecutarSQL::consultar("SELECT * FROM libro WHERE Titulo LIKE '%".$BookNameSearch."%' ORDER BY Titulo ASC");
        $checktotalBook = mysqli_num_rows($checkNameBook);
        if($checktotalBook >0){
                echo '<br><h3 class="text-center all-tittles">resultados de la búsqueda  "'.$BookNameSearch.'"</h3><br><br><br>
                <div class="container-fluid">
                    <ul id="itemContainer" class="list-unstyled">
                    ';
                        $countBook=1;
                        while ($bookNameInfo=mysqli_fetch_array($checkNameBook, MYSQLI_ASSOC)){
                        echo '<li>
                            <div class="media media-hover">
                              <div class="media-left media-middle">
                                  <a href="infobook.php?codeBook='.$bookNameInfo['CodigoLibro'].'" class="tooltips-general" data-toggle="tooltip" data-placement="right" title="Más información del libro">
                                      <img class="media-object" src="assets/img/book.png" alt="Libro" width="48" height="48">
                                  </a>
                              </div>
                              <div class="media-body">
                                <h4 class="media-heading">'.$countBook.' - '.$bookNameInfo['Titulo'].'</h4>
                                <div class="pull-left">
                                    <strong>Autor: </strong>'.$bookNameInfo['Autor'].'<br>
                                    <strong>Año: </strong>'.$bookNameInfo['Year'].'<br>
                                </div>
                                <p class="text-center pull-right">
                                    <a href="#" class="btn btn-info btn-xs btn-info-book" style="margin-right: 10px;" data-code-book="'.$bookNameInfo['CodigoLibro'].'">
                                        <i class="fa fa-info-circle"></i> &nbsp;&nbsp; Más información
                                    </a>
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
            echo '<h2 class="text-center"><i class="zmdi zmdi-mood-bad zmdi-hc-5x"></i><br><br>Lo sentimos, no hemos encontrado ningún libro con el nombre <strong>'.$BookNameSearch.'</strong> en el sistema</h2>';
        }
        mysqli_free_result($checkNameBook);
        echo'<br><br><br><br><br><br>';
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="ModalHelp">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center all-tittles">ayuda del sistema</h4>
                </div>
                <div class="modal-body">
                    <?php include './help/help-searchbook.php'; ?>
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