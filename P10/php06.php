<?php
include "connect.php";
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$satuan = $_POST['satuan'];
$hbeli = $_POST['hbeli'];
$hjual = $_POST['hjual'];

$sql = "delete from items
where kode = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses delete";
} else {
    echo "error delete";
}
?>