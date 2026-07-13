<?php
$kodepr = $_GET['kodepr'] ?? '';
$namapr = $_GET['namapr'] ?? '';
$satuan = $_GET['satuan'] ?? '';
$harga  = $_GET['harga']  ?? '';
$diskon = $_GET['diskon'] ?? '';
$gudang = $_GET['gudang'] ?? '';
?>

<div class="container-fluid px-4 py-4">
  <h4 class="mb-4 fw-bold">Edit Produk</h4>

  <div class="row">
    <div class="col-sm-3">
      <div class="mb-3">
        <label class="form-label">Kode Produk</label>
        <input type="text" class="form-control" id="kodepr" value="<?= htmlspecialchars($kodepr) ?>" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="namapr" value="<?= htmlspecialchars($namapr) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Satuan</label>
        <input type="text" class="form-control" id="satuan" value="<?= htmlspecialchars($satuan) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" value="<?= htmlspecialchars($harga) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Diskon</label>
        <input type="number" class="form-control" id="diskon" value="<?= htmlspecialchars($diskon) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Gudang</label>
        <select class="form-select" id="gudang">
          <option value="<?= htmlspecialchars($gudang) ?>" disabled selected>Gudang <?= htmlspecialchars($gudang) ?></option>
          <option value="A">Gudang A</option>
          <option value="B">Gudang B</option>
          <option value="C">Gudang C</option>
        </select>
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-success" id="btn-update">Update</button>
        <button class="btn btn-danger" id="btn-delete">Delete</button>
        <button class="btn btn-secondary" id="btn-back">Back</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {

  function loadPage(url) {
    $('#isi').load(url);
  }

  $('#btn-back').on('click', function () {
    loadPage('index.php');
  });

  $("#btn-update").click(function(){
    var formdata = new FormData();
    formdata.append('kodepr',$("#kodepr").val());
    formdata.append('namapr',$("#namapr").val());
    formdata.append('satuan',$("#satuan").val());
    formdata.append('harga',$("#harga").val());
    formdata.append('diskon',$("#diskon").val());
    formdata.append('gudang',$("#gudang").val());

      $.ajax({
        type: 'POST',
        url: 'updateprdk.php',
        data: formdata, // Mengambil semua data form
        processData:false,
        contentType:false,
        success: function(response) {
            console.log('Sukses:', response);
            alert('Data berhasil diupdate!');
            window.location.href = "index.php";
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
      });
  });

  $("#btn-delete").click(function(){
      var formdata = new FormData();
      formdata.append('kodepr',$("#kodepr").val());
      formdata.append('namapr',$("#namapr").val());
      formdata.append('satuan',$("#satuan").val());
      formdata.append('harga',$("#harga").val());
      formdata.append('diskon',$("#diskon").val());
      formdata.append('gudang',$("#gudang").val());

    $.ajax({
        type: 'POST',
        url: 'deleteprdk.php',
        data: formdata, // Mengambil semua data form
        processData:false,
        contentType:false,
        success: function(response) {
            console.log('Sukses:', response);
            alert('Data berhasil dihapus!');
            window.location.href = "index.php";
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
  });
});
</script>
