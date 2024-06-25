<?php
require('fpdf/fpdf.php');

// Tabla simple
function BasicTable($pdf, $header, $data)
{
    // Cabecera
    foreach ($header as $col)
        $pdf->Cell(40, 7, $col, 1);
    $pdf->Ln();
    // Datos
    foreach ($data as $row) {
        foreach ($row as $col)
            $pdf->Cell(40, 6, $col, 1);
        $pdf->Ln();
    }
}

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('Banner completo.png',10,8,33);
        // Arial bold 30
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

// Datos de ejemplo
$header = array('Producto', 'Precio');
$data = array(
    array('Producto 1', '10.00'),
    array('Producto 2', '15.50'),
    array('Producto 3', '8.75')
);

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Nombre: ',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Aqui va el nombre del usuario',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Correo: ',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Aqui va el correo del usuario',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Fecha: ',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Aqui va la fecha',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Lugar de compra: ',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Multicell(0,10,'ESCOM IPN, Unidad Profesional Adolfo Lopez Mateos, Av. Juan de Dios Batiz, Nueva Industrial Vallejo, Gustavo A. Madero, 07320 Ciudad de Mexico, CDMX',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Informacion de la compra: ',0,1);
$pdf->SetFont('Arial','',12);

// Añadir la tabla de productos y precios
BasicTable($pdf, $header, $data);

// Calcular el total
$total = 0;
foreach ($data as $row) {
    $total += floatval($row[1]);
}

// Mostrar el total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 6, 'Total', 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 6, number_format($total, 2), 1);

$pdf->Output();
?>
