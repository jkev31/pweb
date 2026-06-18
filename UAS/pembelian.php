<?php
include 'connect.php';
 
// Ambil daftar item dari tabel items untuk master item modal
$items_result = $conn->query("SELECT kodepr AS kode, namapr AS nama, satuan, hbeli FROM items ORDER BY kodepr");
$db_items = [];
while ($row = $items_result->fetch_assoc()) {
    $db_items[] = $row;
}

// Ambil daftar supplier dari tabel suppliers untuk master supplier modal
$sup_result = $conn->query("SELECT `kode-sup`, `nama-sup`, `kota-sup`, `telp-sup` FROM suppliers ORDER BY `kode-sup`");
$db_suppliers = [];
while ($row = $sup_result->fetch_assoc()) {
    $db_suppliers[] = $row;
}
?>

  <div class="container-fluid mt-3" id="trans">
    <!-- Header -->
    <div class="mb-3">

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">Tanggal:</label>
        <div class="col-sm-2">
          <input type="date" class="form-control" id="tanggal" value="<?= date('Y-m-d') ?>">
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">Kode Supplier:</label>
        <div class="col-sm-2">
          <!-- Input readonly, klik membuka modal #mastersupplier -->
          <input type="text" class="form-control" id="supplier" placeholder="Pilih Supplier..."
            data-bs-toggle="modal" data-bs-target="#mastersupplier" readonly>
          <!-- Hidden input menyimpan kode supplier yang dipilih -->
          <input type="hidden" id="kodesup">
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">Nama Supplier:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="namasup" placeholder="Nama Supplier..." readonly>
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">Kota Supplier:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="kota" placeholder="Kota Supplier..." readonly>
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">No. Telp:</label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="notelp" placeholder="08..." readonly>
        </div>
      </div>

      <div class="d-flex align-items-start mb-2">
        <label class="col-sm-1 col-form-label">Keterangan:</label>
        <div class="col-sm-2">
          <textarea class="form-control" id="keterangan" placeholder="Masukkan keterangan"></textarea>
        </div>
      </div>

    </div><br>


    <!-- Input Row -->
    <div class="row mb-3 mt-3">
      <div class="col-sm-1">
        <label class="mb-1">kode</label>
        <input type="text" class="form-control" id="kode" data-bs-toggle="modal" data-bs-target="#masteritem" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">nama</label>
        <input type="text" class="form-control" id="nama" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">satuan</label>
        <input type="text" class="form-control" id="satuan" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">harga beli</label>
        <input type="text" class="form-control" id="harga" readonly>
        <input type="hidden" id="harga_val">
      </div>
      <div class="col-sm-2">
        <label class="mb-1">qty</label>
        <input type="number" class="form-control" id="qty" placeholder="Qty" min="1" value="">
      </div>
      <div class="col-sm-2">
        <label class="mb-1">subtotal</label>
        <input type="text" class="form-control bg-body-secondary" id="subtotal_preview" placeholder="Subtotal" readonly>
      </div>
      <div class="col-sm-1 d-flex align-items-end">
        <button id="tambah" class="btn btn-primary w-100">tambah</button>
      </div>
    </div>


    <!-- Table keranjang -->
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
      <tbody></tbody>
      <tfoot>
        <tr>
          <td colspan="5"></td>
          <td>Total</td>
          <td>Rp <span id="tot">0</span></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>
            Diskon
            <input type="number" id="diskon_persen" class="form-control form-control-sm mt-1" placeholder="0" min="0"
              max="100" style="width:70px; display:inline-block;">
            <span class="text-muted">%</span>
          </td>
          <td>Rp <span id="diskon_nominal">0</span></td>
        </tr>
        <tr>
          <td colspan="5"></td>
          <td>Grandtotal</td>
          <td>Rp <span id="grandtotal">0</span></td>
        </tr>
      </tfoot>
    </table>
    <button type="button" id="save" class="btn btn-success">Save</button>
    <button type="button" id="close" class="btn btn-danger">Close</button>
  </div>



  <!-- Modal Master Item -->
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
              <th>Harga Beli</th>
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
                        '<?= htmlspecialchars($item['kode'],  ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($item['nama'],  ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($item['satuan'],ENT_QUOTES) ?>',
                        '<?= (float)$item['hbeli'] ?>'
                      )">Pilih</button>
                  </td>
                  <td><?= htmlspecialchars($item['kode'])   ?></td>
                  <td><?= htmlspecialchars($item['nama'])   ?></td>
                  <td><?= htmlspecialchars($item['satuan']) ?></td>
                  <td>Rp <?= number_format((float)$item['hbeli'], 0, ',', '.') ?></td>
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


  <!-- Modal Master Supplier -->
  <!-- Ditampilkan saat input #supplier diklik, menampilkan daftar supplier -->
  <div class="modal fade" id="mastersupplier">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Master Supplier</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <th>Pilih</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Kota</th>
              <th>No. Telp</th>
            </thead>
            <tbody>
              <?php if (empty($db_suppliers)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted">
                  Tidak ada supplier tersedia.
                </td>
              </tr>
              <?php else: ?>
                <?php foreach ($db_suppliers as $sup): ?>
                <tr>
                  <td>
                    <button class="btn btn-success btn-sm" data-bs-dismiss="modal"
                      onclick="pilihsupplier(
                        '<?= htmlspecialchars($sup['kode-sup'],  ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($sup['nama-sup'],  ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($sup['kota-sup'],  ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($sup['telp-sup'],  ENT_QUOTES) ?>'
                      )">Pilih</button>
                  </td>
                  <td><?= htmlspecialchars($sup['kode-sup']) ?></td>
                  <td><?= htmlspecialchars($sup['nama-sup']) ?></td>
                  <td><?= htmlspecialchars($sup['kota-sup']) ?></td>
                  <td><?= htmlspecialchars($sup['telp-sup']) ?></td>
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

    /* Helper: muat halaman ke #isi (SPA) atau navigasi langsung */
    function loadPage(url) {
      if ($('#isi').length) {
        $('#isi').load(url);
      } else {
        window.location.href = url;
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

    /* Dipanggil saat pengguna klik Pilih di modal Master Supplier */
    function pilihsupplier(kode, nama, kota, telp) {
      $("#supplier").val(kode);
      $("#namasup").val(nama);
      $("#kota").val(kota);
      $("#notelp").val(telp);
    }
 
    /* Hitung ulang seluruh total keranjang */
    function hitungtotal() {
      var total = 0;
 
      $("#tbldata tbody tr").each(function () {
        var harga    = parseFloat($(this).find(".harga").data('value'))  || 0;
        var qty      = parseInt($(this).find(".qty").text())             || 1;
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
    }
 
    /* Preview subtotal sebelum item ditambahkan ke tabel */
    function updateSubtotalPreview() {
      var harga = parseFloat($("#harga_val").val()) || 0;
      var qty   = parseInt($("#qty").val())         || 0;
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
        var q = parseInt($("#qty").val())         || 0;
 
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
 
      /* Hitung ulang saat diskon berubah */
      $("#diskon_persen").on("input", function () {
        hitungtotal();
      });
 
      /* Tombol Close: kembali ke savepembelian.php tanpa menyimpan */
      $("#close").click(function () {
        loadPage('savepembelian.php');
      });
 
      /* Tombol Save: validasi → kumpulkan data → AJAX POST → kembali */
      $("#save").click(function () {
        let tanggal  = $("#tanggal").val();
        let supplier = $("#supplier").val().trim();
        let telp     = $("#notelp").val().trim();
        let ket      = $("#keterangan").val().trim();
 
        // Validasi field wajib
        if (!tanggal)  { alert("Isi tanggal terlebih dahulu!");          return; }
        if (!supplier) { alert("Pilih supplier terlebih dahulu!");        return; }
 
        // Kumpulkan item dari keranjang
        let items = [];
        $("#tbldata tbody tr").each(function () {
          let row = $(this);
          items.push({
            kode    : row.find("td:eq(1)").text().trim(),
            nama    : row.find("td:eq(2)").text().trim(),
            satuan  : row.find("td:eq(3)").text().trim(),
            harga   : parseFloat(row.find(".harga").data('value'))   || 0,
            qty     : parseInt(row.find(".qty").text())              || 0,
            subtotal: parseFloat(row.find(".subtotal").data('value')) || 0
          });
        });
 
        if (items.length === 0) {
          alert("Tambahkan item terlebih dahulu!");
          return;
        }
 
        // Ambil total, diskon, grandtotal
        let total      = parseFloat($("#tot").data('value'))           || 0;
        let diskon     = parseFloat($("#diskon_nominal").data('value')) || 0;
        let grandtotal = parseFloat($("#grandtotal").data('value'))     || 0;
 
        // Kirim ke savepembelian.php via AJAX POST
        $.ajax({
          url    : 'savepembelian.php',
          method : 'POST',
          data   : {
            action     : 'save',
            tanggal    : tanggal,
            'nama-sup' : supplier,
            'telp-sup' : telp,
            'ket-sup'  : ket,
            total      : total,
            diskon     : diskon,
            grandtotal : grandtotal,
            items      : JSON.stringify(items)
          },
          dataType: 'json',
          beforeSend: function () {
            $("#save").prop('disabled', true).text('Menyimpan...');
          },
          success: function (res) {
            if (res.success) {
              alert('Data berhasil disimpan!\nKode: ' + res.kodepb);
              loadPage('savepembelian.php');
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