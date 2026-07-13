<?php
include "connect.php";
$kode = $_POST['kodepr'];
$nama = $_POST['namapr'];
$satuan = $_POST['satuan'];
$harga = $_POST['harga'];
$diskon = $_POST['diskon'];
$gudang = $_POST['gudang'];

$sql = "delete from items
where kodepr = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses delete";
} else {
    echo "error delete";
}
?>