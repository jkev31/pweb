<?php
include "koneksi.php";
$kode = $_POST['kode'];
$nama = $_POST['nama'];
$satuan = $_POST['satuan'];
$hbeli = $_POST['hbeli'];
$hjual = $_POST['hjual'];

$sql = "insert into items 
values('$kode','$nama','$satuan',$hbeli,$hjual)";
if($conn->query($sql)===true)
    {
        echo "sukses insert";
    }
    else
        {
           echo "gagal insert"; 
        }

?>
