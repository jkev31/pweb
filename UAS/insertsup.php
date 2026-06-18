<?php
include "connect.php";
$kode = $_POST['kode-sup'];
$nama = $_POST['nama-sup'];
$alamat = $_POST['alamat-sup'];
$kota = $_POST['kota-sup'];
$ket = $_POST['ket-sup'];
$telp = $_POST['telp-sup'];

$sql = "insert into suppliers
values('$kode','$nama','$alamat','$kota','$ket','$telp')";
if($conn->query($sql)===true) {
    echo "sukses insert";
} else {
    echo "error insert";
}
?>