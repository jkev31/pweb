<?php
include 'connect.php';

header('Content-Type: application/json');

$kodepj = $_POST['kodepj'] ?? '';

if ($kodepj === '') {
    echo json_encode(['error' => 'kodepj tidak boleh kosong']);
    exit;
}

// ── Ambil header dari masterpenjualan ──────────────────────────
$stmt = $conn->prepare("SELECT * FROM masterpenjualan WHERE kodepj = ?");
$stmt->bind_param('s', $kodepj);
$stmt->execute();
$master = $stmt->get_result()->fetch_assoc();

if (!$master) {
    echo json_encode(['error' => 'Data penjualan tidak ditemukan']);
    exit;
}

// ── Ambil baris detail + nama/satuan dari tabel items ──────────
$stmt2 = $conn->prepare(
    "SELECT d.kodepr AS kode,
            COALESCE(i.namapr,   '') AS nama,
            COALESCE(i.satuan, '') AS satuan,
            d.hjual,
            d.qty,
            d.subtotal
     FROM   detailpenjualan d
     LEFT JOIN items i ON d.kodepr = i.kodepr
     WHERE  d.kodepj = ?"
);
$stmt2->bind_param('s', $kodepj);
$stmt2->execute();
$res = $stmt2->get_result();

$details = [];
while ($row = $res->fetch_assoc()) {
    $details[] = $row;
}

echo json_encode(['master' => $master, 'details' => $details]);
