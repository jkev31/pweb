<?php
include 'connect.php';

header('Content-Type: application/json');

$kodepb = $_POST['kodepb'] ?? '';

if ($kodepb === '') {
    echo json_encode(['error' => 'kodepb tidak boleh kosong']);
    exit;
}

// ── Ambil header dari masterpembelian ──────────────────────────
$stmt = $conn->prepare("SELECT * FROM masterpembelian WHERE kodepb = ?");
$stmt->bind_param('s', $kodepb);
$stmt->execute();
$master = $stmt->get_result()->fetch_assoc();

if (!$master) {
    echo json_encode(['error' => 'Data pembelian tidak ditemukan']);
    exit;
}

// ── Ambil baris detail + nama/satuan dari tabel items ──────────
$stmt2 = $conn->prepare(
    "SELECT d.kodepr AS kode,
            COALESCE(i.namapr,   '') AS nama,
            COALESCE(i.satuan, '') AS satuan,
            d.hbeli,
            d.qty,
            d.subtotal
     FROM   detailpembelian d
     LEFT JOIN items i ON d.kodepr = i.kodepr
     WHERE  d.kodepb = ?"
);
$stmt2->bind_param('s', $kodepb);
$stmt2->execute();
$res = $stmt2->get_result();

$details = [];
while ($row = $res->fetch_assoc()) {
    $details[] = $row;
}

echo json_encode(['master' => $master, 'details' => $details]);
