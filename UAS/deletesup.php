<?php
include "connect.php";
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$ket = $_POST['ket'];
$telp = $_POST['telp'];

$sql = "delete from suppliers
where kode = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses delete";
} else {
    echo "error delete";
}
?>