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
      <select class="form-select" id="gudang">
      <option value="" disabled selected>Pilih Gudang</option>
      <option value="A">Gudang A</option>
      <option value="B">Gudang B</option>
      <option value="C">Gudang C</option>
      </select>
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

  $("#btn-save").click(function(){
     var formdata = new FormData();
     formdata.append('kodepr',$("#kodepr").val());
     formdata.append('namapr',$("#namapr").val());
     formdata.append('satuan',$("#satuan").val());
     formdata.append('harga',$("#harga").val());
     formdata.append('diskon',$("#diskon").val());
     formdata.append('gudang',$("#gudang").val());

     if ($("#kodepr").val() == '') {
        alert ('kode masih kosong!');
        return;
     }

     $.ajax({
        type: 'POST',
        url: 'insertprdk.php',
        data: formdata,
        processData:false,
        contentType:false,
        success: function(response) {
            console.log('Sukses:', response);
            alert('Data berhasil dikirim!');
            window.location.href = "index.php";
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });


});

});
</script>
