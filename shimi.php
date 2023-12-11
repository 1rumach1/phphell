<?php
require('fpdf.php');
$conn=new mysqli ('localhost','root','','dbnat');
$pdf= new FPDF('P','mm','Letter');
$pdf->SetAutoPageBreak(true, 5);
$pdf->Addpage();

$pdf->Image('lcc.jpg', 0,0,40);
$pdf->SetFont('Arial','B',16);

$pdf->setxy(60,20);
$pdf->SetFont('Arial','B',30);
$pdf->cell(100,5, "LIPA CITY COLLEGES",0 ,1,"C");

$pdf->setxy(60,40);
$pdf->SetFont('Arial','B',20);
$pdf->cell(100,5, "Student List",0 ,1,"C");

$pdf->setxy(10,50);
$result=$conn->query("select * from studlist");
$pdf->SetFont('Arial','B',17);
$pdf->cell(100,7, 'Name',1,0,"C");
$pdf->cell(100,7, 'Course',1,1,"C");
 while($row=$result->fetch_assoc()){
    $pdf->SetFont('Arial','B',10);
    $pdf->cell(100,7, $row['nName'], 1,0,"C");
    $pdf->cell(100,7, $row['Course'], 1,1,"C");
 }
$pdf->Output();
?>