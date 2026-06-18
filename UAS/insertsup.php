<?php
include "connect.php";
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$kota = $_POST['kota'];
$ket = $_POST['ket'];
$telp = $_POST['telp'];

$sql = "insert into suppliers
values('$kode','$nama','$alamat','$kota','$ket','$telp')";
if($conn->query($sql)===true) {
    echo "sukses insert";
} else {
    echo "error insert";
}
?>