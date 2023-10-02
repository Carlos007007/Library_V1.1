<div class="div-table">
<div class="div-table-row div-table-head">
    <div class="div-table-cell">Nombre de libro</div>
    <div class="div-table-cell">Fecha Solicitud</div>
    <div class="div-table-cell">Fecha Entrega</div>
    <div class="div-table-cell">Estado</div>
    <div class="div-table-cell">Acción</div>
</div>
<?php
    $key=$_SESSION['primaryKey'];
    if($_SESSION['UserPrivilege']=='Student'){
        $table="prestamoestudiante";
        $primaryKey="NIE";
    }
    if($_SESSION['UserPrivilege']=='Teacher'){
        $table="prestamodocente";
        $primaryKey="DUI";
    }
    if($_SESSION['UserPrivilege']=='Personal'){
        $table="prestamopersonal";
        $primaryKey="DUI";
    }
    $checkResSt=ejecutarSQL::consultar("SELECT * FROM ".$table." WHERE ".$primaryKey."='".$key."'");
    while ($conySt=mysqli_fetch_array($checkResSt, MYSQLI_ASSOC)){
        $checkResStP=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$conySt['CodigoPrestamo']."' AND Estado='Reservacion'");
        while($conySt2=mysqli_fetch_array($checkResStP, MYSQLI_ASSOC)){
            $dataBooks=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$conySt2['CodigoLibro']."'");
            $contB=mysqli_fetch_array($dataBooks, MYSQLI_ASSOC);
            echo ' 
            <div class="div-table-row">
                <div class="div-table-cell">'.$contB['Titulo'].'</div>
                <div class="div-table-cell">'.$conySt2['FechaSalida'].'</div>
                <div class="div-table-cell">'.$conySt2['FechaEntrega'].'</div>
                <div class="div-table-cell">'.$conySt2['Estado'].'</div>
                <form class="div-table-cell form_SRCB" action="process/DeleteReservation.php" method="post" data-type-form="deleteReservation">
                    <input type="hidden" value="'.$conySt2['CodigoPrestamo'].'" name="loanCode">
                    <input type="hidden" value="'.$table.'" name="userTable">
                        <input type="hidden" value="catalog.php" name="urlRefresh">
                    <button type="submit" class="btn btn-danger btn-xs"><i class="zmdi zmdi-delete"></i> &nbsp;&nbsp; Eliminar</button>
                </form>     
            </div>
            ';
            mysqli_free_result($dataBooks);
        }
        mysqli_free_result($checkResStP); 
    }
    mysqli_free_result($checkResSt);
?>
</div>