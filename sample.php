<?php
require('fpdf.php');
$conn=new mysqli ('localhost','root','','dbnat');
$pdf= new FPDF('P','mm','Letter');
$pdf->SetAutoPageBreak(true, 5);
$pdf->Addpage();

$pdf->Image('lcc.jpg', 50,50,50);
$pdf->SetFont('Arial','B',16);

$pdf->setxy(55,38);
$pdf->cell(100,5, "hello world", 1,1,"c");

$pdf->setxy(0,100);
$result=$conn->query("select * from tblstudents");
 while($row=$result->fetch_assoc()){
    $pdf->cell(20,5, $row['fldname'], 1,1,"C");
    $pdf->cell(20,5, $row['fldsno'], 1,1,"C");
 }
$pdf->Output();
?>