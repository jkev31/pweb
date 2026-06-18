<?php
include "connect.php";
$kode = $_POST['kode-sup'];
$nama = $_POST['nama-sup'];
$alamat = $_POST['alamat-sup'];
$kota = $_POST['kota-sup'];
$ket = $_POST['ket-sup'];
$telp = $_POST['telp-sup'];

$sql = "update suppliers
set `nama-sup` = '$nama', `alamat-sup` = '$alamat', `kota-sup` = '$kota', `ket-sup` = '$ket', `telp-sup` = '$telp' where `kode-sup` = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses update";
} else {
    echo "error update";
}
?>