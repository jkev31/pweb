<?php

$total_belanja = 150000; 
$diskon = 0;

if ($total_belanja > 100000) {
    $diskon = 0.1 * $total_belanja;
} 
$harga_akhir = $total_belanja - $diskon;

echo "Harga Sebelum Diskon: Rp " . number_format($total_belanja, 0, ',', '.') . "<br>";
echo "Besar Diskon: Rp " . number_format($diskon, 0, ',', '.') . "<br>";
echo "Harga Akhir yang Harus Dibayar: Rp " . number_format($harga_akhir, 0, ',', '.');
?>
