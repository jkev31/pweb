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
        <input type="text" class="form-control" id="gudang" value="<?= htmlspecialchars($gudang) ?>">
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

  $('#btn-update').on('click', function () {
    var namapr = $('#namapr').val().trim();
    var satuan = $('#satuan').val().trim();
    var harga  = $('#harga').val();
    var diskon = $('#diskon').val();
    var gudang = $('#gudang').val().trim();

    if (!namapr) { alert('Nama harus diisi!'); return; }

    $.ajax({
      url: 'index.php',
      method: 'POST',
      data: {
        action: 'update', kodepr: $('#kodepr').val(),
        namapr: namapr, satuan: satuan, harga: harga,
        diskon: diskon, gudang: gudang
      },
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          alert('Produk berhasil diupdate!');
          loadPage('index.php');
        } else {
          alert('Gagal: ' + (res.error || 'Unknown'));
        }
      },
      error: function () {
        alert('Terjadi kesalahan koneksi.');
      }
    });
  });

  $('#btn-delete').on ('click', function () {
    var kodepr = $('#kodepr').val();
    if (!confirm('Yakin hapus "' + kodepr + '"?')) return;

    $.ajax({
      url: 'index.php',
      method: 'POST',
      data: { action: 'delete', kodepr: kodepr },
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          alert('Produk berhasil dihapus!');
          loadPage('index.php');
        } else {
          alert('Gagal: ' + (res.error || 'Unknown'));
        }
      },
      error: function () {
        alert('Terjadi kesalahan koneksi.');
      }
    });
  });

});
</script>
