<?php

$pdf->Image(ROOTDIR.'/images/logo.jpg',20,20);

$pdf->SetFont('freesans','',10);
foreach ($companyaddress AS $addressline) {
	$pdf->Cell(0,4,trim($addressline),0,1,'R');
}

$pdf->Ln(10);

$pdf->SetFont('freesans','B',10);
$pdf->SetX($pdf->GetX()+10);
$pdf->Cell(20,6,"Quote #",1,0,'C');
$pdf->Cell(60,6,"Subject",1,0,'C');
$pdf->Cell(35,6,"Date Created",1,0,'C');
$pdf->Cell(35,6,"Valid Until",1,1,'C');

$pdf->SetFont('freesans','',9);
$pdf->SetX($pdf->GetX()+10);
$rowcount = $pdf->getNumLines($subject, 60);
$height = $rowcount * 5;
$pdf->MultiCell(20,$height,$quotenumber,1,'C',0,0);
$pdf->MultiCell(60,$height,$subject,1,'C',0,0);
$pdf->MultiCell(35,$height,$datecreated,1,'C',0,0);
$pdf->MultiCell(35,$height,$validuntil,1,'C',0,1);

$pdf->Ln(10);

$pdf->Cell(0,4,"Bill To",0,1);
if ($clientsdetails["companyname"]) {
	$pdf->Cell(0,4,$clientsdetails["companyname"],0,1,'L');
	$pdf->Cell(0,4,$_LANG["invoicesattn"].": ".$clientsdetails["firstname"]." ".$clientsdetails["lastname"],0,1,'L'); } else {
	$pdf->Cell(0,4,$clientsdetails["firstname"]." ".$clientsdetails["lastname"],0,1,'L');
}
$pdf->Cell(0,4,$clientsdetails["address1"],0,1,'L');
if ($clientsdetails["address2"]) {
	$pdf->Cell(0,4,$clientsdetails["address2"],0,1,'L');
}
$pdf->Cell(0,4,$clientsdetails["city"].', '.$clientsdetails["state"].', '.$clientsdetails["postcode"],0,1,'L');
$pdf->Cell(0,4,$clientsdetails["country"],0,1,'L');

$pdf->Ln(10);

$pdf->SetDrawColor(200);
$pdf->SetFillColor(239);

$pdf->SetFont('freesans','B',8);

$pdf->Cell(15,6,"Qty",1,0,'C','1');
$pdf->Cell(80,6,"Description",1,0,'C','1');
$pdf->Cell(25,6,"Unit Price",1,0,'C','1');
$pdf->Cell(25,6,"Discount %",1,0,'C','1');
$pdf->Cell(25,6,"Total",1,0,'C','1');

$pdf->Ln();

$pdf->SetFont('freesans','',8);

foreach ($lineitems AS $item) {

	$rowcount = $pdf->getNumLines($item['description'], 80);
    $height = $rowcount * 5;

    $itemlines = explode("\n",$item['description']);
    $desc = '';
    foreach ($itemlines AS $itemline) $desc .= trim($itemline)."\n";

    $pdf->MultiCell(15,$height,$item['qty'],1,'C',0,0);
    $pdf->MultiCell(80,$height,$desc,1,'L',0,0);
    $pdf->MultiCell(25,$height,$item['unitprice'],1,'C',0,0);
    $pdf->MultiCell(25,$height,$item['discount'],1,'C',0,0);
    $pdf->MultiCell(25,$height,$item['total'],1,'C',0,0);

	$pdf->Ln();

}

$pdf->SetFont('freesans','B',8);

$pdf->Cell(145,6,"Subtotal",1,0,'R','1');
$pdf->Cell(25,6,$subtotal,1,0,'C','1');
$pdf->Ln();

if ($taxlevel1["rate"]>0) {
    $pdf->Cell(145,6,$taxlevel1["name"]." @ ".$taxlevel1["rate"]."%",1,0,'R','1');
    $pdf->Cell(25,6,$tax1,1,0,'C','1');
    $pdf->Ln();
}

if ($taxlevel2["rate"]>0) {
    $pdf->Cell(145,6,$taxlevel2["name"]." @ ".$taxlevel2["rate"]."%",1,0,'R','1');
    $pdf->Cell(25,6,$tax2,1,0,'C','1');
    $pdf->Ln();
}

$pdf->Cell(145,6,"Total",1,0,'R','1');
$pdf->Cell(25,6,$total,1,0,'C','1');
$pdf->Ln();

if ($notes) {
	$pdf->Ln(10);
    $pdf->SetFont('freesans','',8);
	$pdf->MultiCell(170,5,$_LANG["invoicesnotes"].": $notes");
}

?>