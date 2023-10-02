<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution, MYSQLI_ASSOC);
class PDF extends FPDF{
}
ob_end_clean();
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont("Times","",20);
$pdf->SetMargins(25,20,25);
$pdf->Image('../assets/img/slv.png',19,16,20,20);
$pdf->Image('../assets/img/ins.png',177,16,18,20);
$pdf->Ln(10);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Times","",14);
$pdf->Cell (0,5,utf8_decode('Control de bibliografía de biblioteca prestada y entregada'),0,1,'C');
$pdf->Ln(5);
$pdf->Cell (0,5,utf8_decode('durante el año '.$dataInstitution['Year'].''),0,1,'C');
$pdf->Ln(20);
$pdf->SetFont("Times","b",10);
$pdf->SetFillColor(255,204,188);
$pdf->Cell (53,6,utf8_decode('TIPO DE USUARIO'),1,0,'C',true);
$pdf->Cell (53,6,utf8_decode('NÚMERO DE PRÉSTAMOS'),1,0,'C',true);
$pdf->Cell (53,6,utf8_decode('PORCENTAJE'),1,0,'C',true);
$pdf->Ln(6);
function Cporcent($NT,$CT,$DC){
    $Res=number_format($NT/$CT ,$DC)*100;
    return $Res;
}
$selectallLoans=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Entregado'");
$totalSelected=0;
while($dat=mysqli_fetch_array($selectallLoans, MYSQLI_ASSOC)){
    $SYear=date("Y",strtotime($dat['FechaSalida']));
    if($dataInstitution['Year']==$SYear){
        $totalSelected++;
    }
}
$totalLoansStudents=0;
$totalLoansTeacher=0;
$totalLoansVisitor=0;
$totalLoansPersonal=0;
$selectallLoans2=ejecutarSQL::consultar("SELECT * FROM prestamo WHERE Estado='Entregado'");
while($filaD=mysqli_fetch_array($selectallLoans2, MYSQLI_ASSOC)){
    $SelectYear=date("Y",strtotime($filaD['FechaSalida']));
    if($dataInstitution['Year']==$SelectYear){
        $checkingUser1=ejecutarSQL::consultar("SELECT * FROM prestamoestudiante WHERE CodigoPrestamo='".$filaD['CodigoPrestamo']."'");
        if(mysqli_num_rows($checkingUser1)>=1){
            $totalLoansStudents++;
        }
        $checkingUser2=ejecutarSQL::consultar("SELECT * FROM prestamodocente WHERE CodigoPrestamo='".$filaD['CodigoPrestamo']."'");
        if(mysqli_num_rows($checkingUser2)>=1){
            $totalLoansTeacher++;
        }
        $checkingUser3=ejecutarSQL::consultar("SELECT * FROM prestamovisitante WHERE CodigoPrestamo='".$filaD['CodigoPrestamo']."'");
        if(mysqli_num_rows($checkingUser3)>=1){
            $totalLoansVisitor++;
        }
        $checkingUser4=ejecutarSQL::consultar("SELECT * FROM prestamopersonal WHERE CodigoPrestamo='".$filaD['CodigoPrestamo']."'");
        if(mysqli_num_rows($checkingUser4)>=1){
            $totalLoansPersonal++;
        }
        mysqli_free_result($checkingUser1);
        mysqli_free_result($checkingUser2);
        mysqli_free_result($checkingUser3);
        mysqli_free_result($checkingUser4);
    }
}
$pdf->SetFont("Times","",10);
$pdf->Cell (53,6,utf8_decode('Estudiantes'),1,0,'C');
$pdf->Cell (53,6,utf8_decode($totalLoansStudents),1,0,'C');
$pdf->Cell (53,6,utf8_decode($TEP=Cporcent($totalLoansStudents, $totalSelected, 2).'%'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell (53,6,utf8_decode('Docentes'),1,0,'C');
$pdf->Cell (53,6,utf8_decode($totalLoansTeacher),1,0,'C');
$pdf->Cell (53,6,utf8_decode($TTP=Cporcent($totalLoansTeacher, $totalSelected, 2).'%'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell (53,6,utf8_decode('Personal Administrativo'),1,0,'C');
$pdf->Cell (53,6,utf8_decode($totalLoansPersonal),1,0,'C');
$pdf->Cell (53,6,utf8_decode($TPP=Cporcent($totalLoansPersonal, $totalSelected, 2).'%'),1,0,'C');
$pdf->Ln(6);
$pdf->Cell (53,6,utf8_decode('Visitantes'),1,0,'C');
$pdf->Cell (53,6,utf8_decode($totalLoansVisitor),1,0,'C');
$pdf->Cell (53,6,utf8_decode($TVP=Cporcent($totalLoansVisitor, $totalSelected, 2).'%'),1,0,'C');
$pdf->Ln(6);
$pdf->SetFillColor(179,229,252);
$pdf->SetFont("Times","b",10);
$pdf->Cell (53,6,utf8_decode('TOTAL'),1,0,'C',true);
$pdf->Cell (53,6,utf8_decode($totalSelected),1,0,'C',true);
$pdf->Cell (53,6,utf8_decode($TEP+$TTP+$TVP+$TPP.'%'),1,0,'C',true);
$pdf->Output('Prestamos_entregados_'.$dataInstitution['Year'],'I');
mysqli_free_result($selectInstitution);
mysqli_free_result($selectallLoans);
mysqli_free_result($selectallLoans2);