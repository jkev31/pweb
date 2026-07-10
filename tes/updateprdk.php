<?php
include "connect.php";
$kode = $_POST['kodepr'];
$nama = $_POST['namapr'];
$satuan = $_POST['satuan'];
$hbeli = $_POST['hbeli'];
$hjual = $_POST['hjual'];

$sql = "update items
set namapr = '$nama', satuan = '$satuan', hbeli = '$hbeli', hjual = '$hjual' where kodepr = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses update";
} else {
    echo "error update";
}
?>