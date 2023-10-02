<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
$bookCode=consultasSQL::CleanStringText($_POST['primaryKey']);
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
$bookLocation=consultasSQL::CleanStringText($_POST['bookLocation']);
$bookOffice=consultasSQL::CleanStringText($_POST['bookOffice']);
$bookEstimated=consultasSQL::CleanStringText($_POST['bookEstimated']);
$bookState=consultasSQL::CleanStringText($_POST['bookState']);
$checkLoanBook=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoLibro='".$bookCode."' AND Estado='Prestamo'");
$checkLoanBook1=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoLibro='".$bookCode."' AND Estado='Reservacion'");
if(mysqli_num_rows($checkLoanBook)<=0 && mysqli_num_rows($checkLoanBook1)<=0){
    if(consultasSQL::UpdateSQL("libro", "CodigoCategoria='$bookCategory',CodigoCorrelativo='$bookCorrelative',Titulo='$bookName',Autor='$bookAutor',Pais='$bookCountry',CodigoProveedor='$bookProvider',Year='$bookYear',Editorial='$bookEditorial',Edicion='$bookEdition',Existencias='$bookCopies',Ubicacion='$bookLocation',Cargo='$bookOffice',Estimado='$bookEstimated',Estado='$bookState'", "CodigoLibro='$bookCode'")){
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Datos del libro actualizados!", 
                text:"Los datos del libro se actualizaron correctamente", 
                type: "success", 
                confirmButtonText: "Aceptar" 
            },
            function(isConfirm){  
                if (isConfirm) {     
                   window.location="infobook.php?codeBook='.$bookCode.'";
                } else {    
                    window.location="infobook.php?codeBook='.$bookCode.'";;
                } 
            });
        </script>';
    }else{
        echo '<script type="text/javascript">
            swal({ 
                title:"¡Ocurrió un error inesperado!", 
                text:"No hemos podido actualizar los datos del libro, por favor intenta nuevamente", 
                type: "error", 
                confirmButtonText: "Aceptar" 
            });
        </script>';
    }
}else{
    echo '<script type="text/javascript">
        swal({ 
            title:"¡Ocurrió un error inesperado!", 
            text:"Este libro tiene préstamos o reservaciones vigentes, no puedes actualizar los datos", 
            type: "error", 
            confirmButtonText: "Aceptar" 
        });
    </script>';
}
mysqli_free_result($checkLoanBook);
mysqli_free_result($checkLoanBook1);