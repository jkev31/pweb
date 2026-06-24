<?php
require_once __DIR__ . '/fpdf19/fpdf.php';

$raw    = json_decode($_GET['data'] ?? '{}', true) ?: [];
$header = $raw['header'] ?? [];
$items  = $raw['items']  ?? [];
$footer = $raw['footer'] ?? [];

$pdf = new FPDF();
$pdf->AddPage();

// --- Judul ---
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Detail Penjualan', 0, 1, 'C');
$pdf->Ln(2);

// --- Info Header ---
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, 'Kode', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, $header['kodepj'] ?? '', 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, 'Tanggal', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->SetFont('Arial', '', 11);
$tgl = date('d-m-Y', strtotime($header['tanggal'] ?? ''));
$pdf->Cell(0, 8, $tgl, 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, 'Konsumen', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, $header['konsumen'] ?? '', 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, 'No. Telp', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, $header['telp'] ?? '', 0, 1);

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, 'Keterangan', 0, 0);
$pdf->Cell(5, 8, ':', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, $header['keterangan'] ?? '', 0, 1);

$pdf->Ln(4);

// --- Tabel Detail ---
$colW = [15, 50, 25, 30, 15, 55];
$headers = ['No', 'Nama', 'Satuan', 'Harga', 'Qty', 'Subtotal'];

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(50, 50, 50);
$pdf->SetTextColor(255);
foreach ($headers as $i => $h) {
    $pdf->Cell($colW[$i], 8, $h, 1, 0, 'C', true);
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
foreach ($items as $idx => $item) {
    $pdf->Cell($colW[0], 8, $idx + 1, 1, 0, 'C');
    $pdf->Cell($colW[1], 8, $item['nama'] ?? '', 1, 0, 'L');
    $pdf->Cell($colW[2], 8, $item['satuan'] ?? '', 1, 0, 'C');
    $pdf->Cell($colW[3], 8, 'Rp ' . number_format((float)preg_replace('/[^0-9]/', '', $item['hjual'] ?? '0'), 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell($colW[4], 8, $item['qty'] ?? '', 1, 0, 'C');
    $pdf->Cell($colW[5], 8, 'Rp ' . number_format((float)preg_replace('/[^0-9]/', '', $item['subtotal'] ?? '0'), 0, ',', '.'), 1, 0, 'R');
    $pdf->Ln();
}

// --- Footer ---
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);

// Total
$pdf->Cell(135, 8, '', 0, 0);
$pdf->Cell(20, 8, 'Total', 1, 0, 'R');
$pdf->Cell(35, 8, 'Rp ' . ($footer['total'] ?? '0'), 1, 1, 'R');

// Diskon
$pdf->Cell(135, 8, '', 0, 0);
$pdf->Cell(20, 8, 'Diskon', 1, 0, 'R');
$diskonText = ($footer['diskon_persen'] ?? '0') . '%  Rp ' . ($footer['diskon_nominal'] ?? '0');
$pdf->Cell(35, 8, $diskonText, 1, 1, 'R');

// Grandtotal
$pdf->SetFillColor(50, 50, 50);
$pdf->SetTextColor(255);
$pdf->Cell(135, 8, '', 0, 0);
$pdf->Cell(20, 8, 'Grandtotal', 1, 0, 'R', true);
$pdf->Cell(35, 8, 'Rp ' . ($footer['grandtotal'] ?? '0'), 1, 1, 'R', true);

$pdf->Output('detail_penjualan.pdf', 'I');
?>
