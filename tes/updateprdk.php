<?php
include "connect.php";
$kode = $_POST['kodepr'];
$nama = $_POST['namapr'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$diskon = $_POST['diskon'];
$gudang = $_POST['gudang'];

$sql = "update items
set namapr = '$nama', satuan = '$satuan', harga = '$harga', diskon = '$diskon', gudang = '$gudang' where kodepr = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses update";
} else {
    echo "error update";
}
?>