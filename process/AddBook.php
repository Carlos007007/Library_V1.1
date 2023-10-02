<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$bookCorrelative=consultasSQL::CleanStringText($_POST['bookCorrelative']);
$bookCategory=consultasSQL::CleanStringText($_POST['bookCategory']);
$bookName=consultasSQL::CleanStringText($_POST['bookName']);
$bookAutor=consultasSQL::CleanStringText($_POST['bookAutor']);
$bookCountry=consultasSQL::CleanStringText($_POST['bookCountry']);
$bookProvider=consultasSQL::CleanStringText($_POST['bookProvider']);
$bookYear=consultasSQL::CleanStringText($_POST['bookYear']);
$bookEditorial=consultasSQL::CleanStringText($_POST['bookEditorial']);
$bookEdition=consultasSQL::CleanStringText($_POST['bookEdition']);
$bookCopies=consultasSQL::CleanStringText($_POST['bookCopies']);
$bookBorrowed=0;
$bookLocation=consultasSQL::CleanStringText($_POST['bookLocation']);
$bookOffice=consultasSQL::CleanStringText($_POST['bookOffice']);
$bookEstimated=consultasSQL::CleanStringText($_POST['bookEstimated']);
$bookState=consultasSQL::CleanStringText($_POST['bookState']);
$checkAllBookReg=ejecutarSQL::consultar("SELECT * FROM libro");
$checktotalBookReg=mysqli_num_rows($checkAllBookReg);
$numB=$checktotalBookReg+1;
$bookCheckInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInst=mysqli_fetch_array($bookCheckInstitution, MYSQLI_ASSOC);
$bookInstitution=$dataInst['CodigoInfraestructura'];
$codigo=""; 
$longitud=4; 
for ($i=1; $i<=$longitud; $i++){ 
    $numero = rand(0,9); 
    $codigo .= $numero; 
}
$bookCode="I".$dataInst['CodigoInfraestructura']."Y".$dataInst['Year']."C".$bookCategory."B".$numB."N".$codigo."";
if(mysqli_num_rows($bookCheckInstitution)>0){
    if(!$bookCategory=="" && !$bookProvider=="" && !$bookOffice=="" && !$bookState==""){
        $checkBookName=ejecutarSQL::consultar("SELECT * FROM libro WHERE Titulo='".$bookName."' AND Autor='".$bookAutor."'");
        if(mysqli_num_rows($checkBookName)<=0){
           if(consultasSQL::InsertSQL("libro", "CodigoLibro, CodigoCorrelativo, CodigoCategoria, CodigoProveedor, CodigoInfraestructura, Autor, Pais, Year, Estimado, Titulo, Edicion, Ubicacion, Cargo, Editorial, Existencias, Prestado,Estado", "'$bookCode','$bookCorrelative','$bookCategory','$bookProvider','$bookInstitution','$bookAutor','$bookCountry','$bookYear','$bookEstimated','$bookName','$bookEdition','$bookLocation','$bookOffice','$bookEditorial','$bookCopies','$bookBorrowed','$bookState'")){
               echo '<script type="text/javascript">
                    swal({
                       title:"¡Libro registrado!",
                       text:"Los datos del libro se registraron correctamente",
                       type: "success",
                       confirmButtonText: "Aceptar"
                    });
                    $(".form_SRCB")[0].reset();
                </script>'; 
           }else{
                echo '<script type="text/javascript">
                    swal({
                       title:"¡Ocurrió un error inesperado!",
                       text:"No se pudo registrar el libro, por favor intenta nuevamente",
                       type: "error",
                       confirmButtonText: "Aceptar"
                    });
                </script>';
           } 
        }else{
            echo '<script type="text/javascript">
                swal({
                   title:"¡Ocurrió un error inesperado!",
                   text:"El nombre y autor del libro que acabas de escribir ya está almacenado en el sistema",
                   type: "error",
                   confirmButtonText: "Aceptar"
                });
            </script>'; 
        }
    }else{
        echo '<script type="text/javascript">
            swal({
               title:"¡Ocurrió un error inesperado!",
               text:"Verifica que hayas seleccionado una categoría, proveedor, cargo y estado del libro válidos. Si aún tienes problemas verifica que tengas categorías y proveedores registrados en el sistema",
               type: "error",
               confirmButtonText: "Aceptar"
            });
        </script>';
    } 
}else{
    echo '<script type="text/javascript">
        swal({
           title:"¡Ocurrió un error inesperado!",
           text:"No has registrado los datos de la institución, por favor registralos para poder guardar libros",
           type: "error",
           confirmButtonText: "Aceptar"
        });
    </script>'; 
}
mysqli_free_result($checkBookName);
mysqli_free_result($bookCheckInstitution);
mysqli_free_result($checkAllBookReg);