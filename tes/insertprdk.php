<?php
include "connect.php";
$kode = $_POST['kodepr'];
$nama = $_POST['namapr'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$diskon = $_POST['diskon'];
$gudang = $_POST['gudang'];

$sql = "insert into items (kodepr, namapr, satuan, harga, diskon, gudang)
values('$kode','$nama','$satuan','$harga','$diskon','$gudang')";
if($conn->query($sql)===true) {
    echo "sukses insert";
} else {
    echo "error insert";
}

?>