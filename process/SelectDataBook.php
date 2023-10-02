<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$codeBook=consultasSQL::CleanStringText($_POST['code']);
$SdataB=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='$codeBook'");
$dBook=mysqli_fetch_array($SdataB, MYSQLI_ASSOC);
if(mysqli_num_rows($SdataB)>=1){
    echo '<input value="'.$dBook["CodigoLibro"].'" type="hidden" name="primaryKey">
    <legend><strong>Información básica</strong></legend><br>
    <div class="group-material">
        <span>Categoría</span>
        <select class="tooltips-general material-control" name="bookCategory" data-toggle="tooltip" data-placement="top" title="Elige la categoría del libro">';
            $nameCateg=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria='".$dBook['CodigoCategoria']."'");
            $nC=mysqli_fetch_array($nameCateg, MYSQLI_ASSOC);
            echo '<option value="'.$nC['CodigoCategoria'].'">'.$nC['Nombre'].'</option>'; 
            $checkCategory=ejecutarSQL::consultar("SELECT * FROM categoria WHERE CodigoCategoria <> '".$dBook['CodigoCategoria']."'");
            while($row=mysqli_fetch_array($checkCategory, MYSQLI_ASSOC)){
                echo '<option value="'.$row['CodigoCategoria'].'">'.$row['Nombre'].'</option>'; 
            }
            mysqli_free_result($checkCategory);
            mysqli_free_result($nameCateg);
    echo '</select>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['CodigoCorrelativo'].'" class="tooltips-general material-control" name="bookCorrelative" pattern="[0-9]{1,20}" required="" maxlength="20" data-toggle="tooltip" data-placement="top" title="Escribe el código correlativo del libro, solamente números">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Código correlativo</label>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Titulo'].'" class="tooltips-general material-control" name="bookName" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe el título o nombre del libro">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Título</label>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Autor'].'" class="tooltips-general material-control" name="bookAutor" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Escribe el nombre del autor del libro">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Autor</label>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Pais'].'" class="tooltips-general material-control" required="" name="bookCountry" maxlength="50" data-toggle="tooltip" data-placement="top" title="Escribe el país del libro">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>País</label>
    </div>
    <legend><strong>Otros datos</strong></legend><br>
    <div class="group-material">
        <span>Proveedor</span>
        <select class="tooltips-general material-control" name="bookProvider" data-toggle="tooltip" data-placement="top" title="Elige el proveedor del libro">';
            $nameProv=ejecutarSQL::consultar("SELECT * FROM proveedor WHERE CodigoProveedor='".$dBook['CodigoProveedor']."'");
            $nP=mysqli_fetch_array($nameProv, MYSQLI_ASSOC);
            echo '<option value="'.$nP['CodigoProveedor'].'">'.$nP['Nombre'].'</option>'; 
            $checkProvider=ejecutarSQL::consultar("SELECT * FROM proveedor WHERE CodigoProveedor <> '".$dBook['CodigoProveedor']."'");
            while($row=mysqli_fetch_array($checkProvider, MYSQLI_ASSOC)){
                echo '<option value="'.$row['CodigoProveedor'].'">'.$row['Nombre'].'</option>'; 
            }
            mysqli_free_result($checkProvider);
            mysqli_free_result($nameProv);
        echo '</select>
    </div>
    <div class="group-material">
       <input type="text" value="'.$dBook['Year'].'" class="material-control tooltips-general" name="bookYear" required="" pattern="[0-9]{1,4}" maxlength="4" data-toggle="tooltip" data-placement="top" title="Solamente números, sin espacios">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Año</label>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Editorial'].'" class="material-control tooltips-general" name="bookEditorial" required="" maxlength="70" data-toggle="tooltip" data-placement="top" title="Editorial del libro">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Editorial</label>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Edicion'].'" class="material-control tooltips-general" name="bookEdition" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="Edición del libro">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Edición</label>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Existencias'].'" class="material-control tooltips-general" name="bookCopies" required=" "pattern="[0-9]{1,7}" maxlength="7" data-toggle="tooltip" data-placement="top" title="¿Cuántos libros registraras?">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Ejemplares</label>
    </div>
    <legend><strong>Estado físico, ubicación y valor</strong></legend><br>
    <div class="group-material">
       <input type="text" value="'.$dBook['Ubicacion'].'" class="material-control tooltips-general" name="bookLocation" required="" maxlength="50" data-toggle="tooltip" data-placement="top" title="¿Dónde se ubicara el libro?">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Ubicación</label>
    </div>
    <div class="group-material">
        <span>Cargo</span>
        <select class="tooltips-general material-control" name="bookOffice" data-toggle="tooltip" data-placement="top" title="Elige el cargo del libro">';
        switch ($dBook['Cargo']){
            case "1-1":
                echo ' 
                <option value="1-1">Entrega del ministerio</option>
                <option value="1-2">Donaciones</option>
                <option value="1-3">Compras con fondos propios</option>
                <option value="1-4">Presupuesto escolar</option>
                <option value="1-5">Otros</option> 
                ';
                break;
            case "1-2":
                echo ' 
                <option value="1-2">Donaciones</option>
                <option value="1-1">Entrega del ministerio</option>
                <option value="1-3">Compras con fondos propios</option>
                <option value="1-4">Presupuesto escolar</option>
                <option value="1-5">Otros</option> 
                ';
                break;
            case "1-3":
                echo ' 
                <option value="1-3">Compras con fondos propios</option>
                <option value="1-1">Entrega del ministerio</option>
                <option value="1-2">Donaciones</option>
                <option value="1-4">Presupuesto escolar</option>
                <option value="1-5">Otros</option> 
                ';
                break;
            case "1-4":
                echo ' 
                <option value="1-4">Presupuesto escolar</option>
                <option value="1-1">Entrega del ministerio</option>
                <option value="1-2">Donaciones</option>
                <option value="1-3">Compras con fondos propios</option>
                <option value="1-5">Otros</option> 
                ';
                break;
            case "1-5":
                echo ' 
                <option value="1-5">Otros</option>
                <option value="1-1">Entrega del ministerio</option>
                <option value="1-2">Donaciones</option>
                <option value="1-3">Compras con fondos propios</option>
                <option value="1-4">Presupuesto escolar</option>
                ';
                break;
            default : echo 'Error al recuperar el cargo';
        }
        echo '</select>
    </div>
    <div class="group-material">
        <input type="text" value="'.$dBook['Estimado'].'" class="material-control tooltips-general" name="bookEstimated" required="" pattern="[0-9.]{1,7}" maxlength="7" data-toggle="tooltip" data-placement="top" title="Sólo números y un punto si el valor posee decimales. Ejemplo: 7.79">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Estimado</label>
    </div>
    <div class="group-material">
        <span>Estado</span>
        <select class="tooltips-general material-control" name="bookState" data-toggle="tooltip" data-placement="top" title="Elige el estado del libro">';
           switch($dBook['Estado']){
                case "Bueno":
                    echo '
                    <option value="Bueno">Bueno</option>
                    <option value="Deteriorado">Deteriorado</option>
                    ';
                    break;
                case "Deteriorado":
                    echo '
                    <option value="Deteriorado">Deteriorado</option>
                    <option value="Bueno">Bueno</option>
                    ';
                    break;
                default : echo 'Error al intentar recuperar el estado';
            }
        echo '</select>
    </div>';
}else{
    echo '<div class="alert alert-danger text-center" role="alert"><strong><i class="zmdi zmdi-alert-triangle"></i> &nbsp; ¡Error!:</strong> Lo sentimos ha ocurrido un error.</div>';
}
mysqli_free_result($SdataB);