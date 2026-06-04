<?php
include "connect.php";
$kodepj = $_POST['kodepj'];
$tanggal = $_POST['tanggal'];
$konsumen = $_POST['konsumen'];
$telp = $_POST['telp'];
$ket = $_POST['ket'];
$total = $_POST['total'];
$diskon = $_POST['diskon'];
$grandtotal = $_POST['grandtotal'];

$sql = "insert into masterpenjualan
values('$kodepj','$tanggal','$konsumen','$telp','$ket','$total','$diskon','$grandtotal')";
if($conn->query($sql)===true) {
    echo "sukses insert";
} else {
    echo "error insert";
}
?>