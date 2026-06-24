<?php
$data = json_decode($_GET['data'] ?? '[]', true) ?: [];
$rows = is_array($data) ? $data : [];

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="rekap_penjualan.csv"');

$output = fopen('php://output', 'w');
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, ['Kode', 'Tanggal', 'Konsumen', 'Grandtotal'], ';');

foreach ($rows as $row) {
    fputcsv($output, [
        $row['kode'],
        date('d-m-Y', strtotime($row['tanggal'])),
        $row['konsumen'],
        $row['grandtotal']
    ], ';');
}

fclose($output);
exit;
