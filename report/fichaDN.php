<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$loanCode=consultasSQL::CleanStringText($_GET['loanCode']);
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution, MYSQLI_ASSOC);
$selectLoan=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE CodigoPrestamo='".$loanCode."'");
$dataLoan=mysqli_fetch_array($selectLoan, MYSQLI_ASSOC);
$selectBook=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoLibro='".$dataLoan['CodigoLibro']."'");
$dataBook=mysqli_fetch_array($selectBook, MYSQLI_ASSOC);
$selectUserKey=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE CodigoPrestamo='".$loanCode."'");
$dataKey=mysqli_fetch_array($selectUserKey, MYSQLI_ASSOC);
$selectUser=ejecutarSQL::consultar("SELECT * FROM docente WHERE DUI='".$dataKey['DUI']."'");
$dataUser=mysqli_fetch_array($selectUser, MYSQLI_ASSOC);
if($dataLoan['FechaSalida']!=""){
    $SelectDayFS=date("d",strtotime($dataLoan['FechaSalida']));
    $SelectMonthFS=date("m",strtotime($dataLoan['FechaSalida']));
    $SelectYearFS=date("Y",strtotime($dataLoan['FechaSalida']));
    $SelectMontNameFS=CalMonth::CurrentMonth($SelectMonthFS);
    $SelectDateFS=$SelectDayFS.' de '.$SelectMontNameFS.' de '.$SelectYearFS;
    $SelectDayFE=date("d",strtotime($dataLoan['FechaEntrega']));
    $SelectMonthFE=date("m",strtotime($dataLoan['FechaEntrega']));
    $SelectYearFE=date("Y",strtotime($dataLoan['FechaEntrega']));
    $SelectMontNameFE=CalMonth::CurrentMonth($SelectMonthFE);
    $SelectDateFE=$SelectDayFE.' de '.$SelectMontNameFE.' de '.$SelectYearFE;
}else{
    $SelectDateFS="";
    $SelectDateFE="";
} 
if($loanCode!=""){ $CurrentYear=$SelectYearFE; }else{ $CurrentYear=$dataInstitution['Year']; }
class PDF extends FPDF{
}
ob_end_clean();
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont("Times","",20);
$pdf->SetMargins(25,20,25);
$pdf->SetFillColor(0,255,255);
$pdf->Image('../assets/img/slv.png',19,16,20,20);
$pdf->Image('../assets/img/ins.png',177,16,18,20);
$pdf->Ln(20);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Times","",14);
$pdf->Cell (0,5,utf8_decode('Registro de préstamos de libros de biblioteca a personal docente que laboran'),0,1,'C');
$pdf->Ln(7);
$pdf->Cell (0,5,utf8_decode('en el '.$dataInstitution['Nombre'].', durante el año '.$CurrentYear.''),0,1,'C');
$pdf->Ln(20);
$pdf->SetFont("Times","b",12);
$pdf->Cell (15,5,utf8_decode('Código: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (25,5,utf8_decode($dataInstitution['CodigoInfraestructura']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (31,5,utf8_decode('Firma director: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (30,5,utf8_decode(''),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (17,5,utf8_decode('Distrito: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (15,5,utf8_decode($dataInstitution['Distrito']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (22,5,utf8_decode('Sello'),0);
$pdf->Ln(12);
$pdf->SetFont("Times","b",12);
$pdf->Cell (42,5,utf8_decode('Nombre de solicitante: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (100,5,utf8_decode($dataUser['Nombre'].' '.$dataUser['Apellido']),0);
$pdf->Ln(12);
$pdf->SetFont("Times","b",12);
$pdf->Cell (26,5,utf8_decode('Especialidad: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (70,5,utf8_decode($dataUser['Especialidad']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (11,5,utf8_decode('DUI: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (50,5,utf8_decode($dataUser['DUI']),0);
$pdf->Ln(12);
$pdf->SetFont("Times","b",12);
$pdf->Cell (9,5,utf8_decode('Tel: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (90,5,utf8_decode($dataUser['Telefono']),0);
$pdf->SetFont("Times","b",12);
$pdf->Cell (19,5,utf8_decode('Jornada: '),0);
$pdf->SetFont("Times","",12);
$pdf->Cell (40,5,utf8_decode($dataUser['Jornada']),0);
$pdf->Ln(10);
$pdf->SetFont("Times","",12);
$pdf->Cell (0,10,utf8_decode('Título del libro: '.$dataBook['Titulo'].''),1);
$pdf->Ln(10);
$pdf->Cell (0,10,utf8_decode('Autor: '.$dataBook['Autor'].''),1);
$pdf->Ln(10);
$pdf->Cell (84,10,utf8_decode('Fecha de solicitud: '.$SelectDateFS.''),1);
$pdf->Cell (82,10,utf8_decode('F. '),1);
$pdf->Ln(10);
$pdf->Cell (84,10,utf8_decode('Fecha de entrega: '.$SelectDateFE.''),1);
$pdf->Cell (82,10,utf8_decode('F. '),1);
$pdf->Ln(10);
$pdf->SetFont("Times","b",12);
$pdf->Cell (0,10,utf8_decode('Cantidad de libros prestados: '.$dataKey['Cantidad'].', a continuación se muestran los códigos de los libros:'),0);
$pdf->SetFont("Times","",10);
$pdf->Ln(10);
$codesArray=explode(",", $dataLoan['CorrelativoLibro']);
$CC=1;
$N=1;
foreach($codesArray as $CDA){
    if($CDA!=""){
        $pdf->Cell (34,7,utf8_decode($N.')'.$CDA),0);
        $CC++;
        if($CC>5){
            $pdf->Ln(7);
            $CC=1;
        }
        $N++;
    } 
}
$pdf->Output('N-'.$loanCode,'I');
mysqli_free_result($selectLoan);
mysqli_free_result($selectBook);
mysqli_free_result($selectInstitution);
mysqli_free_result($selectUserKey);
mysqli_free_result($selectUser);