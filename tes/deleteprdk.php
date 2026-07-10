<?php
include "connect.php";
$kode = $_POST['kodepr'];
$nama = $_POST['namapr'];
$satuan = $_POST['satuan'];
$hbeli = $_POST['hbeli'];
$hjual = $_POST['hjual'];

$sql = "delete from items
where kodepr = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses delete";
} else {
    echo "error delete";
}
?>