<div class="container-fluid px-4 py-4">
  <h4 class="mb-4 fw-bold">Tambah Produk</h4>

  <div class="row">
    <div class="col-sm-3">
      <div class="mb-3">
        <input type="text" class="form-control" id="kodepr" placeholder="Enter kode">
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="namapr" placeholder="Enter nama">
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="satuan" placeholder="Enter satuan">
      </div>
      <div class="mb-3">
        <input type="number" class="form-control" id="harga" placeholder="Enter harga">
      </div>
      <div class="mb-3">
        <input type="number" class="form-control" id="diskon" placeholder="Enter diskon">
      </div>
      <div class="mb-3">
        <input type="text" class="form-control" id="gudang" placeholder="Enter gudang">
      </div>
      <div class="d-flex gap-2">
        <button class="btn btn-success" id="btn-save">Save</button>
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

  $('#btn-save').on('click', function () {
    var kodepr = $('#kodepr').val().trim();
    var namapr = $('#namapr').val().trim();
    var satuan = $('#satuan').val().trim();
    var harga  = $('#harga').val();
    var diskon = $('#diskon').val();
    var gudang = $('#gudang').val().trim();

    if (!kodepr) { alert('Kode harus diisi!'); return; }
    if (!namapr) { alert('Nama harus diisi!'); return; }

    $.ajax({
      url: 'index.php',
      method: 'POST',
      data: {
        action: 'save', kodepr: kodepr, namapr: namapr,
        satuan: satuan, harga: harga, diskon: diskon, gudang: gudang
      },
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          alert('Produk berhasil ditambahkan!');
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
