<?php
require './fpdf/fpdf.php';
include '../library/configServer.php';
include '../library/consulSQL.php';
include '../library/SelectMonth.php';
$selectInstitution=ejecutarSQL::consultar("SELECT * FROM institucion");
$dataInstitution=mysqli_fetch_array($selectInstitution, MYSQLI_ASSOC);
class PDF extends FPDF{
}
ob_end_clean();
$pdf=new PDF('L','mm',array(216,330));
$pdf->AddPage();
$pdf->SetFont("Times","",20);
$pdf->SetMargins(25,20,25);
$pdf->Image('../assets/img/slv.png',40,20,20,20);
$pdf->Image('../assets/img/ins.png',270,20,18,20);
$pdf->Ln(20);
$pdf->Cell (0,5,utf8_decode($dataInstitution['Nombre']),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont("Times","",14);
$pdf->Cell (0,5,utf8_decode('Inventario general de libros del año '.$dataInstitution['Year'].''),0,1,'C');
$pdf->Ln(12);
$SAC=ejecutarSQL::consultar("SELECT * FROM categoria ORDER BY CodigoCategoria ASC");
$CountTotal=0;
$CountTotalUnits=0;
while($DSAC=mysqli_fetch_array($SAC, MYSQLI_ASSOC)){
    $SABC=ejecutarSQL::consultar("SELECT * FROM libro WHERE CodigoCategoria='".$DSAC['CodigoCategoria']."' ORDER BY Titulo ASC");
    if(mysqli_num_rows($SABC)>=1){
        $pdf->SetFillColor(255,204,188);
        $pdf->SetFont("Times","b",10);
        $pdf->Cell (0,6,utf8_decode($DSAC['CodigoCategoria'].' biblioteca de '.$DSAC['Nombre']),1,0,'C',true);
        $pdf->Ln(6);
        $pdf->SetFillColor(179,229,252);
        $pdf->Cell (29,6,utf8_decode('CÓDIGO'),1,0,'C',true);
        $pdf->Cell (120,6,utf8_decode('TÍTULO'),1,0,'C',true);
        $pdf->Cell (60,6,utf8_decode('AUTOR'),1,0,'C',true);
        $pdf->Cell (25,6,utf8_decode('Editorial'),1,0,'C',true);
        $pdf->Cell (16,6,utf8_decode('Edición'),1,0,'C',true);
        $pdf->Cell (30,6,utf8_decode('Año'),1,0,'C',true);
        //$pdf->Cell (29,6,utf8_decode('Escuela'),1,0,'C',true);
        //$pdf->Cell (16,6,utf8_decode('TOTAL'),1,0,'C',true);
        $pdf->Ln(6);
        $pdf->SetFont("Times","",7);
        while($DSABC=mysqli_fetch_array($SABC, MYSQLI_ASSOC)){
            $bookCode=$DSABC['Nombre'].'-'.$DSABC['CodigoCategoria'].'-'.$DSABC['CodigoCorrelativo'].'1/'.$DSABC['Existencias'];
            $PriceT=$DSABC['Estimado']*$DSABC['Existencias'];
            //$pdf->Cell (29,6,utf8_decode($bookCode),1,0,'C');
            $pdf->Cell (29,6,utf8_decode($DSABC['CodigoCorrelativo']),1,0,'C');
            $pdf->Cell (120,6,utf8_decode($DSABC['Titulo']),1,0,'C');
            $pdf->Cell (60,6,utf8_decode($DSABC['Autor']),1,0,'C');
            $pdf->Cell (25,6,utf8_decode($DSABC['Editorial']),1,0,'C');
            $pdf->Cell (16,6,utf8_decode($DSABC['Edicion']),1,0,'C');
            $pdf->Cell (30,6,utf8_decode($DSABC['Year']),1,0,'C');
            //$pdf->Cell (29,6,utf8_decode($bookCode),1,0,'C');
            //$pdf->Cell (16,6,utf8_decode('$'.$PriceT),1,0,'C');
            $pdf->Ln(6);
            $CountTotal=$CountTotal+$PriceT;
            $CountTotalUnits=$CountTotalUnits+$DSABC['Existencias'];
        }
    }
    mysqli_free_result($SABC);
}
mysqli_free_result($SAC);
$pdf->SetFillColor(255,229,127);
$pdf->SetFont("Times","b",10);
$pdf->Cell (6,6,utf8_decode(''),0,0);
$pdf->Cell (80,6,utf8_decode(''),0,0);
$pdf->Cell (194,6,utf8_decode('TOTAL LIBROS:  '.$CountTotalUnits),1,0,'C',true);
//$pdf->Cell (97,6,utf8_decode('TOTAL INVENTARIO:  '.'$'.$CountTotal),1,0,'C',true);
$pdf->Output('Reporte_Inventario_General_'.$dataInstitution['Year'],'I');
mysqli_free_result($selectInstitution);