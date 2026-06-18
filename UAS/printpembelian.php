<?php
require_once __DIR__ . '/fpdf19/fpdf.php';

$data = json_decode($_GET['data'] ?? '[]', true) ?: [];
$rows = is_array($data) ? $data : [];


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(55, 10, 'Kode', 1, 0, 'C');
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(60, 10, 'Supplier', 1, 0, 'C');
$pdf->Cell(40, 10, 'Grandtotal', 1, 0, 'C');
$pdf->Ln();
foreach ($rows as $sdata) {
    $pdf->Cell(55, 10, $sdata['kode'], 1, 0, 'C');
    $tgl = date('d-m-Y', strtotime($sdata['tanggal']));
    $pdf->Cell(40, 10, $tgl, 1, 0, 'C');
    $pdf->Cell(60, 10, $sdata['supplier'], 1, 0, 'C');
    $pdf->Cell(40, 10, $sdata['grandtotal'], 1, 0, 'R');
    $pdf->Ln();

}


$pdf->Output('penjualan.pdf', 'I');
?>
