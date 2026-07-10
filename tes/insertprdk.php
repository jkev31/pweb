<?php
include "connect.php";
$kode = $_POST['kodepr'];
$nama = $_POST['namapr'];
$satuan = $_POST['satuan'];
$hbeli = $_POST['hbeli'];
$hjual = $_POST['hjual'];

$sql = "insert into items
values('$kode','$nama','$satuan','$hbeli','$hjual')";
if($conn->query($sql)===true) {
    echo "sukses insert";
} else {
    echo "error insert";
}
?>