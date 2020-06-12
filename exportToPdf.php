<?php
require('libs/fpdf.php');
require('functions/statsSales.php');


class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('img/logo_drivncook.png',10,6,30);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    $title = "Rapport des ventes par rapport aux temps";
    // Décalage à droite
    $this->Cell((21 + strlen($title)));
    // Titre
    $this->Cell(strlen($title)*3,10,$title,1,0,'C');
    // Saut de ligne
    $this->Ln(20);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->AddFont('Helvetica','','helvetica.php');
$pdf->SetFont('Helvetica','B',9);

$truckStats = getTrucksStats();
$pdf->Ln(30);
$pdf->Cell(45,10,"Truck Name",1,0,'C');
$pdf->Cell(45,10,utf8_decode("Franchisé"),1,0,'C');
$pdf->Cell(25,10,"Appro D&C",1,0,'C');
$pdf->Cell(25,10,"Appro autre",1,0,'C');
$pdf->Cell(15,10,"Achat",1,0,'C');
$pdf->Cell(20,10,"Ventes ",1,0,'C');
$pdf->Cell(20,10,"Benef",1,0,'C');


$pdf->SetFont('Arial','',10);
foreach ($truckStats as $value){
    $percentBuyWarehouse = round(intVal($value["buyWarehouse"], 10)/ (intVal($value["buyWarehouse"], 10) + intval($value["buyExtern"],10)) *100, 2);
    $benef =  intVal($value["client"], 10) - (intVal($value["buyWarehouse"], 10)+  intVal($value["buyExtern"], 10));
    $pdf->Ln(10);
    $pdf->Cell(45,10, utf8_decode($value["truckName"]),1,0,'C');
    $pdf->Cell(45,10, utf8_decode($value["firstname"].' '.$value["lastname"]),1,0,'C');
    $pdf->Cell(25,10, utf8_decode($value["buyWarehouse"]),1,0,'C');
    $pdf->Cell(25,10, utf8_decode($value["buyExtern"]),1,0,'C');
    if($percentBuyWarehouse<80)$pdf->SetTextColor(255, 0, 0);
    $pdf->Cell(15,10, utf8_decode($percentBuyWarehouse.'%'),1,0,'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(20,10, utf8_decode($value["client"]),1,0,'C');
    if($benef<0)$pdf->SetTextColor(255, 0, 0);
    $pdf->Cell(20,10, utf8_decode($benef),1,0,'C');
    $pdf->SetTextColor(0, 0, 0);




}
$pdf->Output();
