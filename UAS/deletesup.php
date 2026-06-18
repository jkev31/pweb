<?php
include "connect.php";
$kode = $_POST['kode-sup'];
$nama = $_POST['nama-sup'];
$alamat = $_POST['alamat-sup'];
$kota = $_POST['kota-sup'];
$ket = $_POST['ket-sup'];
$telp = $_POST['telp-sup'];

$sql = "delete from suppliers
where `kode-sup` = '$kode'";
if($conn->query($sql)===true) {
    echo "sukses delete";
} else {
    echo "error delete";
}
?>