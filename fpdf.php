<?php

if (!isset($_SESSION)) {
    session_start();
}

$id_usuario = $_SESSION['user_id'];
$query = "SELECT id_cliente FROM usuarios WHERE id='$id_usuario'";
$resultado = $conexion->query($query);
$resultado = $resultado->fetch_assoc();
$id_cliente = $resultado['id_cliente'];

$query = "SELECT email FROM clientes WHERE id = $id_cliente";
$resultado = $conexion->query($query);
$email = $resultado->fetch_assoc()['email'];
$lista_carrito = [];

// $db = new Database();
// $conexion = $db->conectarDB();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = [];
$total = 0;

if ($productos != null) {
    foreach ($productos as $key => $cantidad) {
        $id = $key;
        $query = "SELECT title, price, discountPercentage, '$cantidad' AS cantidad FROM productos WHERE id='$id'";

        $resultado = $conexion->query($query);

        $lista_carrito[] = $resultado->fetch_assoc();
    }
}

$data = [];

foreach ($lista_carrito as $producto) {
    $title = $producto['title'];
    $price = $producto['price'];
    $cantidad = $producto['cantidad'];
    $discountPercentage = $producto['discountPercentage'];
    $precio_desc = $price - (($price * $discountPercentage) / 100);
    $subtotal = $cantidad * $precio_desc;
    $total += $subtotal;

    $data[] = array($title, number_format($subtotal, 2));
}

require('fpdf/fpdf.php');

// Tabla simple
function BasicTable($pdf, $header, $data)
{
    // Definir anchos de columnas
    $w = array(80, 40); // 80 para la primera columna, 40 para la segunda
    // Cabecera
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($w[$i], 7, $header[$i], 1);
    }
    $pdf->Ln();
    // Datos
    foreach ($data as $row) {
        $pdf->Cell($w[0], 6, $row[0], 1); // Primera columna
        $pdf->Cell($w[1], 6, $row[1], 1); // Segunda columna
        $pdf->Ln();
    }
}

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('src/images/logo/Banner completo.png', 10, 8, 33);
        // Arial bold 30
        $this->SetFont('Arial', 'B', 30);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Datos de compra', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Datos de ejemplo
$header = array('Producto', 'Subtotal');

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Nombre: ', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $_SESSION['user_name'], 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Correo: ', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $email, 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Fecha: ', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, date('Y-m-d'), 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Lugar de compra: ', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Multicell(0, 10, 'ESCOM IPN, Unidad Profesional Adolfo Lopez Mateos, Av. Juan de Dios Batiz, Nueva Industrial Vallejo, Gustavo A. Madero, 07320 Ciudad de Mexico, CDMX', 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informacion de la compra: ', 0, 1);
$pdf->SetFont('Arial', '', 12);

// Añadir la tabla de productos y precios
BasicTable($pdf, $header, $data);

// Mostrar el total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 6, 'Total', 1); // Ajustar el ancho de la primera columna en el total
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 6, number_format($total, 2), 1);

$pdf->Output();
?>
