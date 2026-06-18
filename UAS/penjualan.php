<?php
include 'connect.php';
 
// Ambil daftar item dari tabel items untuk master item modal
$items_result = $conn->query("SELECT kode, nama, satuan, hjual FROM items ORDER BY kode");
$db_items = [];
while ($row = $items_result->fetch_assoc()) { // fetch_assoc() = mengambil data dari database dalam bentuk array asosiatif
    $db_items[] = $row;
}
?>

  <div class="container-fluid mt-3" id="trans">
    <!-- Header -->
    <div class="mb-3"> <!-- div untuk header elements, mb-3 = margin bottom 3 -->

      <div class="d-flex align-items-center mb-2">
        <!-- div untuk header elements, d-flex = display flex, mb-2 = margin bottom 2 -->
        <label class="col-sm-1 col-form-label">Tanggal:</label> <!-- label untuk tanggal -->
        <div class="col-sm-2">
          <input type="date" class="form-control" id="tanggal"> <!-- input tanggal -->
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">Konsumen:</label> <!-- label untuk konsumen -->
        <div class="col-sm-2">
          <input type="text" class="form-control" id="konsumen" placeholder="Nama konsumen"> <!-- input konsumen -->
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">No. Telp:</label> <!-- label untuk no telepon -->
        <div class="col-sm-2">
          <input type="text" class="form-control" id="notelp" placeholder="08..."> <!-- input no telepon -->
        </div>
      </div>

      <div class="d-flex align-items-start mb-2">
        <label class="col-sm-1 col-form-label">Keterangan:</label> <!-- label untuk keterangan -->
        <div class="col-sm-2">
          <textarea class="form-control" id="keterangan" placeholder="Masukkan keterangan"></textarea>
          <!-- input keterangan -->
        </div>
      </div>

    </div><br> <!-- Header form selesai -->


    <!-- Input Row: Menampung input data barang sebelum dimasukkan ke keranjang belanja -->
    <!-- Input-input ini memiliki ID unik yang digunakan oleh JavaScript untuk mengambil nilainya. -->
    <div class="row mb-3 mt-3">
      <div class="col-sm-1">
        <label class="mb-1">kode</label>
        <!-- Input kode bersifat readonly (tidak bisa diketik manual). -->
        <!-- Atribut data-bs-toggle="modal" dan data-bs-target="#masteritem" memicu modal Bootstrap terbuka saat input ini diklik -->
        <input type="text" class="form-control" id="kode" data-bs-toggle="modal" data-bs-target="#masteritem" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">nama</label>
        <!-- Field otomatis terisi oleh fungsi tambahtabel() di JavaScript saat item dipilih dari modal -->
        <input type="text" class="form-control" id="nama" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">satuan</label>
        <input type="text" class="form-control" id="satuan" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">harga</label>
        <!-- Input untuk harga dasar item (otomatis terisi, format Rupiah) -->
        <input type="text" class="form-control" id="harga" readonly>
        <input type="hidden" id="harga_val">
      </div>
      <div class="col-sm-2">
        <label class="mb-1">qty</label>
        <!-- Input untuk jumlah barang. Perubahan (event 'input') ditangkap JS untuk update subtotal preview -->
        <input type="number" class="form-control" id="qty" placeholder="Qty" min="1" value="">
      </div>
      <div class="col-sm-2">
        <label class="mb-1">subtotal</label>
        <!-- Field readonly untuk menampilkan estimasi subtotal dari item yang sedang diinput sebelum ditambahkan -->
        <input type="text" class="form-control bg-body-secondary" id="subtotal_preview" placeholder="Subtotal"
          readonly>
      </div>
      <div class="col-sm-1 d-flex align-items-end">
        <!-- Tombol tambah dengan ID 'tambah'. JS mendengarkan event klik tombol ini untuk memasukkan data ke dalam tabel -->
        <button id="tambah" class="btn btn-primary w-100">tambah</button>
      </div>
    </div>


    <!-- Table: Digunakan sebagai wadah daftar keranjang belanja -->
    <!-- JS menggunakan ID 'tbldata' untuk menargetkan tabel ini. -->
    <table class="table table-bordered border-dark table-hover table-striped" id="tbldata">
      <thead class="table-dark text-light">
        <tr>
          <th>Action</th>
          <th>kode</th>
          <th>nama</th>
          <th>satuan</th>
          <th>harga</th>
          <th>qty</th>
          <th>subtotal</th>
        </tr>
      </thead>
      <!-- Elemen <tbody> dibiarkan kosong di HTML. JavaScript akan menambahkan elemen <tr> (baris) ke dalam tbody ini secara dinamis melalui tombol 'tambah' -->
      <tbody></tbody>
      <tfoot>
        <!-- Bagian footer tabel untuk menampilkan kalkulasi akhir transaksi -->
        <tr>
          <td colspan="5"></td>
          <td>Total</td>
          <!-- Elemen <span> digunakan karena merupakan wadah teks inline. ID 'tot' dipakai JS untuk menampilkan nilai akumulasi subtotal -->
          <td>Rp <span id="tot">0</span></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>
            Diskon
            <!-- Input diskon langsung memicu event di JS untuk menghitung ulang kalkulasi saat nilainya diubah -->
            <input type="number" id="diskon_persen" class="form-control form-control-sm mt-1" placeholder="0" min="0"
              max="100" style="width:70px; display:inline-block;">
            <span class="text-muted">%</span>
          </td>
          <!-- Span ID 'diskon_nominal' dipakai JS untuk menampilkan konversi diskon persen ke nominal Rupiah -->
          <td>Rp <span id="diskon_nominal">0</span></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>Grandtotal</td>
          <!-- Span ID 'grandtotal' dipakai JS untuk menampilkan Total dikurangi Diskon Nominal -->
          <td>Rp <span id="grandtotal">0</span></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>Bayar</td>
          <td class="d-flex align-items-center gap-2">
            <span>Rp</span>
            <!-- Input nominal bayar dari kasir. JS mendengarkan perubahan ini untuk menghitung uang kembali -->
            <input type="number" id="bayar" class="form-control">
          </td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>Kembalian</td>
          <!-- Span ID 'kembali' untuk hasil output penghitungan (Bayar - Grandtotal) oleh JS -->
          <td>Rp <span id="kembali">0</span></td>
        </tr>
      </tfoot>
    </table>
    <button type="button" id="save" class="btn btn-success" data-bs-dismiss="modal">Save</button>
    <button type="button" id="close" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
  </div>



  <!-- The Modal: Komponen pop-up (Bootstrap Modal) untuk menampung daftar referensi barang -->
  <!-- Ditampilkan ketika input dengan data-bs-target="#masteritem" diklik -->
  <div class="modal fade" id="masteritem">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Master Item</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <th>Pilih</th>
              <th>kode</th>
              <th>Nama</th>
              <th>satuan</th>
              <th>Harga</th>
            </thead>
            <tbody>
              <?php if (empty($db_items)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted">
                  Tidak ada item tersedia.
                </td>
              </tr>
              <?php else: ?>
                <?php foreach ($db_items as $item): ?>
                <tr>
                  <td>
                    <button class="btn btn-success btn-sm" data-bs-dismiss="modal"
                      onclick="tambahtabel(
                        '<?= htmlspecialchars($item['kode'],  ENT_QUOTES) ?>', // htmlspecialchars = membersihkan karakter khusus agar tidak terjadi kesalahan saat dimasukkan ke dalam kode javascript (seperti tanda kutip)
                        '<?= htmlspecialchars($item['nama'],  ENT_QUOTES) ?>', // ENT_QUOTES = mengubah tanda kutip menjadi entity html
                        '<?= htmlspecialchars($item['satuan'],ENT_QUOTES) ?>',
                        '<?= (float)$item['hjual'] ?>'
                      )">Pilih</button>
                  </td>
                  <td><?= htmlspecialchars($item['kode'])   ?></td>
                  <td><?= htmlspecialchars($item['nama'])   ?></td>
                  <td><?= htmlspecialchars($item['satuan']) ?></td>
                  <td>Rp <?= number_format((float)$item['hjual'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>



  <script>
    /* Helper: format angka ke format Rupiah Indonesia */
    function formatRupiah(angka) {
      return 'Rp ' + angka.toLocaleString('id-ID');
    }

    /* 
    Helper: muat halaman ke #isi (SPA) atau navigasi langsung
    SPA (Single Page Application) = halaman yang memuat konten tanpa me-refresh seluruh halaman
    */
    function loadPage(url) {
      if ($('#isi').length) {
        $('#isi').load(url); // load = memuat halaman
      } else {
        window.location.href = url; // window.location.href = mengarahkan ke halaman
      }
    }
 
    /* Dipanggil saat pengguna klik Pilih di modal Master Item */
    function tambahtabel(kode, nama, satuan, harga) {
      $("#kode").val(kode);
      $("#nama").val(nama);
      $("#satuan").val(satuan);
      $("#harga_val").val(harga);
      $("#harga").val(formatRupiah(parseFloat(harga)));
      $("#qty").val(1).focus();
      updateSubtotalPreview();
    }
 
    /* Hitung ulang seluruh total keranjang belanja */
    function hitungtotal() {
      var total = 0;
 
      $("#tbldata tbody tr").each(function () {
        var harga    = parseFloat($(this).find(".harga").data('value'))    || 0;
        var qty      = parseInt($(this).find(".qty").text())         || 1;
        var subtotal = harga * qty;
        $(this).find(".subtotal").data('value', subtotal).text(formatRupiah(subtotal));
        total += subtotal;
      });
 
      $("#tot").data('value', total).html("<b>" + total.toLocaleString('id-ID') + "</b>");
 
      var persen  = parseFloat($("#diskon_persen").val()) || 0;
      var nominal = Math.round(total * persen / 100);
      $("#diskon_nominal").data('value', nominal).text(nominal.toLocaleString('id-ID'));
 
      var grandtotal = total - nominal;
      if (grandtotal < 0) grandtotal = 0;
      $("#grandtotal").data('value', grandtotal).text(grandtotal.toLocaleString('id-ID'));
 
      var bayar   = parseFloat($("#bayar").val()) || 0;
      var kembali = bayar >= grandtotal ? bayar - grandtotal : 0;
      $("#kembali").text(kembali.toLocaleString('id-ID'));
    }
 
    /* Preview subtotal sebelum item ditambahkan ke tabel */
    function updateSubtotalPreview() {
      var harga = parseFloat($("#harga_val").val()) || 0;
      var qty   = parseInt($("#qty").val())     || 0;
      $("#subtotal_preview").val(qty > 0 ? formatRupiah(harga * qty) : "");
    }
 
    $(document).ready(function () {
 
      /* Preview subtotal saat qty berubah */
      $("#qty").on("input", function () {
        updateSubtotalPreview();
      });
 
      /* Tombol Tambah: masukkan item ke keranjang */
      $("#tambah").click(function () {
        var x = $("#kode").val().trim();
        var y = $("#nama").val().trim();
        var s = $("#satuan").val().trim();
        var z = parseFloat($("#harga_val").val()) || 0;
        var q = parseInt($("#qty").val())     || 0;
 
        if (x === "") { alert("Pilih item dulu!"); return; }
        if (q <= 0)   { alert("Isi Qty terlebih dahulu!"); return; }
 
        var subtotal = z * q;
 
        var tbltr = '<tr>'
          + '<td><button class="btn btn-danger btn-sm hapus">X</button></td>'
          + '<td>'  + x + '</td>'
          + '<td>'  + y + '</td>'
          + '<td>'  + s + '</td>'
          + '<td class="harga" data-value="' + z + '">' + formatRupiah(z) + '</td>'
          + '<td class="qty">'   + q + '</td>'
          + '<td class="subtotal" data-value="' + subtotal + '">' + formatRupiah(subtotal) + '</td>'
          + '</tr>';
 
        $("#tbldata tbody").append(tbltr);
        hitungtotal();
        $("#kode, #nama, #satuan, #harga, #harga_val, #qty, #subtotal_preview").val("");
      });
 
      /* Hapus baris dari keranjang */
      $("#tbldata").on("click", ".hapus", function () {
        $(this).closest('tr').remove();
        hitungtotal();
      });
 
      /* Hitung ulang saat diskon/bayar berubah */
      $("#diskon_persen, #bayar").on("input", function () {
        hitungtotal();
      });
 
      /* Tombol Close: kembali ke savepenjualan.php tanpa menyimpan */
      $("#close").click(function () {
        loadPage('savepenjualan.php');
      });
 
      /* Tombol Save: validasi → kumpulkan data → AJAX POST → kembali */
      $("#save").click(function () {
        let tanggal  = $("#tanggal").val();
        let konsumen = $("#konsumen").val().trim();
        let telp     = $("#notelp").val().trim();
        let ket      = $("#keterangan").val().trim();
 
        // Validasi field wajib
        if (!tanggal)  { alert("Isi tanggal terlebih dahulu!");        return; }
        if (!konsumen) { alert("Isi nama konsumen terlebih dahulu!");   return; }
 
        // Validasi ada item di keranjang
        let items = [];
        $("#tbldata tbody tr").each(function () {
          let row          = $(this);
          items.push({
            kode    : row.find("td:eq(1)").text().trim(),
            nama    : row.find("td:eq(2)").text().trim(),
            satuan  : row.find("td:eq(3)").text().trim(),
            harga   : parseFloat(row.find(".harga").data('value'))   || 0,
            qty     : parseInt(row.find(".qty").text())        || 0,
            subtotal: parseFloat(row.find(".subtotal").data('value')) || 0
          });
        });
 
        if (items.length === 0) {
          alert("Tambahkan item terlebih dahulu!");
          return;
        }
 
        // Ambil nilai total, diskon, grandtotal dari footer tabel
        let total      = parseFloat($("#tot").data('value'))          || 0;
        let diskon     = parseFloat($("#diskon_nominal").data('value')) || 0;
        let grandtotal = parseFloat($("#grandtotal").data('value'))   || 0;
 
        // Kirim ke savepenjualan.php via AJAX POST
        $.ajax({
          url     : 'savepenjualan.php',
          method  : 'POST',
          data    : {
            action    : 'save',
            tanggal   : tanggal,
            konsumen  : konsumen,
            telp      : telp,
            ket       : ket,
            total     : total,
            diskon    : diskon,
            grandtotal: grandtotal,
            items     : JSON.stringify(items)
          },
          dataType: 'json',
          beforeSend: function () {
            $("#save").prop('disabled', true).text('Menyimpan...');
          },
          success: function (res) {
            if (res.success) {
              alert('Data berhasil disimpan!\nKode: ' + res.kodepj);
              loadPage('savepenjualan.php');
            } else {
              alert('Gagal menyimpan: ' + (res.error || 'Unknown error'));
              $("#save").prop('disabled', false).text('Save');
            }
          },
          error: function () {
            alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
            $("#save").prop('disabled', false).text('Save');
          }
        });
      });
 
    }); // end document.ready

    
      

  </script>

