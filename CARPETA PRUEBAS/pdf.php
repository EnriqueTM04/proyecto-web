<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('Banner completo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',30);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Datos de compra',0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Nombre: ',0,1);
$pdf->Cell(0,10,'Correo: ',0,1);
$pdf->Cell(0,10,'Fecha: ',0,1);
$pdf->Cell(0,10,'Informacion de la compra: ',0,1);
$pdf->Cell(0,10,'Nombre de los productos: ',0,1);
$pdf->Cell(0,10,'Total a pagar: ',0,1);

$pdf->Output();
?>