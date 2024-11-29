<?php
require('fpdf.php');
require('../rene/conexion4.php');

if (isset($_POST['consulta'])) {
    $idpost = $_POST['consulta'];
}

class PDF extends FPDF {
    function Header() {

        //$this->SetXY(47.3, 84);// Logo
        $this->Image('../img/Caja AYC-GDO-FR-18 top consu.jpg', 0, 0, 175);
    }

}

$sql = "SELECT * FROM Carpetas WHERE Caja = " . intval($idpost);
$FFinal="";
$fecha_actual = date('YYYY-MM-DD');
$FInicial=$fecha_actual;
$titulo_array = []; // Array to hold all Titulo values

if ($result = $conec->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $Caja = $row['Caja'];
        $Carpeta = $row['Carpeta'];
        $Serie = $row['Serie'];
        $Subs = $row['Subs'];
        $Titulo = $row['Titulo'];
        

        if ($FInicial>$row['FInicial']) {
            $FInicial=$row['FInicial']; 
        }

        if ($FFinal<$row['FFinal']) {
            $FFinal=$row['FFinal']; 
        }

     
        $Folios = $row['Folios'];

        // Add the Titulo to the array
        $titulo_array[] = $Titulo;
    }
    $result->free();
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P', 'mm', array(216, 330));

$pdf->SetTitle(utf8_decode($Caja." Caja"));

$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetFont('Arial', '', 9);
$pdf->SetXY(47.3, 84);
$pdf->MultiCell(87, 6.1, utf8_decode($Serie), 0); // Serie

$pdf->SetXY(47.3, 95);
$pdf->MultiCell(87, 6.8, utf8_decode($Subs), 0); // Sub-serie


$salto = 0;
$salto2 = 0;
$contador=1;
// Now process the Titulo array outside the while loop
foreach ($titulo_array as $titulo) {
    // Split Titulo into an array if necessary
    $titulo_lines = explode("\n", wordwrap($titulo, 50, "\n"));

    // Output each line
    
    foreach ($titulo_lines as $line) {
        $pdf->SetXY(45.5, 117+$salto);
        $pdf->MultiCell(103.4, 5, utf8_decode($line), 1, 1);
        $pdf->SetXY(149, 117+$salto);
        $pdf->MultiCell(17.8, 5, $contador++, 1, 'C');
        $salto += 5;
        if ($contador>9){
            $salto2+=5;
        }
    }
    //$pdf->Ln(20); // Add space between entries
}

$pdf->Image('../img/Caja AYC-GDO-FR-18 below.png', 0, $salto2-10, 175);

$pdf->SetXY(10.2, 117);
$pdf->MultiCell(30.8, $salto, "CONTENIDO", 1, 'C');

$pdf->SetFont('Arial', '', 14);
$pdf->SetXY(57.3, (117.8+$salto)+15);
$pdf->MultiCell(24.1, 6.6, utf8_decode($Caja), 0, 'C'); // Caja

$pdf->SetXY(42.3, (117.8+$salto)+25);
$pdf->MultiCell(24.1, 10, utf8_decode($Carpeta), 0, 'C'); // Numero carpeta

$pdf->SetFont('Arial', '', 9);

$fecha = $FInicial;
$fechaComoEntero = strtotime($fecha);
$Iano = date("Y", $fechaComoEntero);
$Imes = date("m", $fechaComoEntero);
$Idia = date("d", $fechaComoEntero);

// Fecha Inicial
$pdf->SetXY(62.2, (117.6+$salto)+7);
$pdf->MultiCell(14.4, 4.5, $Iano, 0, 'C'); // Año

$pdf->SetXY(74.7, (117.6+$salto)+7);
$pdf->MultiCell(14.4, 4.5, $Imes, 0, 'C'); // Mes

$pdf->SetXY(88.2, (117.6+$salto)+7);
$pdf->MultiCell(14.4, 4.5, $Idia, 0, 'C'); // Día

$fecha2 = $FFinal;
$fechaComoEntero2 = strtotime($fecha2);
$Fano = date("Y", $fechaComoEntero2);
$Fmes = date("m", $fechaComoEntero2);
$Fdia = date("d", $fechaComoEntero2);

// Fecha Final
$pdf->SetXY(125, (117.6+$salto)+7);
$pdf->MultiCell(12.8, 4.5, $Fano, 0, 'C'); // Año

$pdf->SetXY(138.9, (117.6+$salto)+7);
$pdf->MultiCell(12.8, 4.5, $Fmes, 0, 'C'); // Mes

$pdf->SetXY(151.7, (117.6+$salto)+7);
$pdf->MultiCell(12.8, 4.5, $Fdia, 0, 'C'); // Día

$pdf->Output('', "Caja " . $Caja . ".pdf");


