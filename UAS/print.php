<?php
require_once __DIR__ . '/fpdf19/fpdf.php';

$jsonPayload = file_get_contents('php://input');

$data = is_string($jsonPayload) ? json_decode($jsonPayload, true) : $jsonPayload;

// print_r($data['datatable']);
// $data = json_decode($datajson, true);



$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(100, 10, 'Kode', 1);
$pdf->Cell(40, 10, 'Tanggal', 1);
$pdf->Cell(20, 10, 'Konsumen', 1);
$pdf->Cell(40, 10, 'Grandtotal', 1);
$pdf->Ln();
foreach ($data['datatable'] as $sdata) {
    $pdf->Cell(100, 10, $sdata['kode'], 1);
    $pdf->Cell(40, 10, $sdata['tanggal'], 1);
    $pdf->Cell(20, 10, $sdata['konsumen'], 1);
    $pdf->Cell(40, 10, $sdata['grandtotal'], 1);
    $pdf->Ln();

}


$pdf->Output();
?>
