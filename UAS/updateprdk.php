<?php
include "connect.php";
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$satuan = $_POST['satuan'];
$hbeli = $_POST['hbeli'];
$hjual = $_POST['hjual'];

$sql = "update items
set nama = '$nama', satuan = '$satuan', hbeli = '$hbeli', hjual = '$hjual' where kode = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses update";
} else {
    echo "error update";
}
?>