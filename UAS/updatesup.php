<?php
include "connect.php";
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$ket = $_POST['ket'];
$telp = $_POST['telp'];

$sql = "update suppliers
set nama = '$nama', alamat = '$alamat', kota = '$kota', ket = '$ket', telp = '$telp' where kode = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses update";
} else {
    echo "error update";
}
?>