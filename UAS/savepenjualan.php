<?php
include 'connect.php';

/* 
   HANDLER: AJAX Save (POST action=save)
   Dipanggil oleh penjualan.php saat klik Save
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save') {
    header('Content-Type: application/json');
    // $_POST adalah array asosiatif yang berisi data yang dikirim melalui metode POST
    // $_GET adalah array asosiatif yang berisi data yang dikirim melalui metode GET
    

    // Generate kode penjualan unik
    $kodepj     = 'pj' . date('YmdHis') . rand(10, 99);
    $tanggal    = $_POST['tanggal']    ?? date('Y-m-d');
    $konsumen   = $_POST['konsumen']   ?? '';
    $telp       = $_POST['telp-kn']       ?? '';
    $ket        = $_POST['ket-kn']        ?? '';
    $total      = (float)($_POST['total']      ?? 0);
    $diskon     = (float)($_POST['diskon']     ?? 0);
    $grandtotal = (float)($_POST['grandtotal'] ?? 0);
    $items      = json_decode($_POST['items']  ?? '[]', true) ?: [];

    // Insert ke masterpenjualan
    $stmt = $conn->prepare(
        "INSERT INTO masterpenjualan (kodepj, tanggal, konsumen, `telp-kn`, `ket-kn`, total, diskon, grandtotal)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)" 
    );
    $stmt->bind_param('sssssddd', $kodepj, $tanggal, $konsumen, $telp, $ket, $total, $diskon, $grandtotal);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }

    // Insert ke detailpenjualan
    if (!empty($items)) {
        $stmt2 = $conn->prepare(
            "INSERT INTO detailpenjualan (kodepj, kodepr, hjual, qty, subtotal) VALUES (?, ?, ?, ?, ?)"
        );
        foreach ($items as $it) {
            $kode  = $it['kode']     ?? '';
            $hjual = (float)($it['hjual']    ?? 0);
            $qty   = (float)($it['qty']      ?? 0);
            $sub   = (float)($it['subtotal'] ?? 0);
            $stmt2->bind_param('ssddd', $kodepj, $kode, $hjual, $qty, $sub);
            $stmt2->execute();
        }
    }

    echo json_encode(['success' => true, 'kodepj' => $kodepj]); //json_encode = mengubah data menjadi json, agar bisa dikirim ke javascript
    exit;
}

/* 
   Query data penjualan (dengan filter tanggal opsional)
*/
$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-d');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

$sql    = "SELECT * FROM masterpenjualan WHERE 1=1";
$params = [];
$types  = '';
if ($tgl_awal  !== '') { $sql .= " AND tanggal >= ?"; $types .= 's'; $params[] = $tgl_awal;  }
if ($tgl_akhir !== '') { $sql .= " AND tanggal <= ?"; $types .= 's'; $params[] = $tgl_akhir; }
$sql .= " ORDER BY tanggal DESC, kodepj DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result   = $stmt->get_result();
$rows     = [];
$sumGrand = 0;
while ($r = $result->fetch_assoc()) {
    $rows[]    = $r;
    $sumGrand += $r['grandtotal'];
}
?>

<div class="container-fluid px-4 py-4" id="sp-wrapper">
  <h4 class="mb-4 fw-bold">Penjualan</h4>

  <!-- ── Toolbar ── -->
  <div class="d-flex align-items-end gap-3 mb-3 flex-wrap">

    <div>
      <button class="btn btn-primary" id="btn-tambah-penjualan">
        Tambah Penjualan
      </button>
    </div>

    <!-- Filter Tanggal -->
    <form id="formFilter" class="d-flex align-items-end gap-3 flex-wrap">
      <div>
        <label class="form-label mb-1 small fw-semibold">Tanggal Awal</label>
        <input type="date" name="tgl_awal" id="spTglAwal" class="form-control"
               value="<?= htmlspecialchars($tgl_awal) ?>">
      </div>
      <div>
        <label class="form-label mb-1 small fw-semibold">Tanggal Akhir</label>
        <input type="date" name="tgl_akhir" id="spTglAkhir" class="form-control"
               value="<?= htmlspecialchars($tgl_akhir) ?>">
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Filter</button>
        <button type="button" class="btn btn-outline-secondary" id="btn-reset-filter">Reset</button>
        <button type="button" class="btn btn-dark" id="printpenjualan">Print</button>
      </div>
    </form>

  </div>

  <!-- ── Tabel Penjualan ── -->
  <div class="table-responsive">
    <table id="myTable" class="table table-bordered table-hover bg-white align-middle">
      <thead class="table-light">
        <tr>
          <th class="text-center sticky-column">Action</th>
          <th class="text-center">Kode</th>
          <th class="text-center">Tanggal</th>
          <th class="text-center">Konsumen</th>
          <th class="text-end">Grand Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td class='text-center'>
              <button class="btn btn-info btn-sm btn-view-penjualan"
                      data-kodepj="<?= htmlspecialchars($row['kodepj']) ?>">
                View
              </button>
            </td>
            <td class="text-center"><?= htmlspecialchars($row['kodepj']) ?></td>
            <td class="text-center"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['konsumen']) ?></td>
            <td class="text-end">Rp <?= number_format($row['grandtotal'], 0, ',', '.') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr class="table-light fw-bold">
          <td colspan="4" class="text-end">Total</td>
          <td class="text-end">Rp <?= number_format($sumGrand, 0, ',', '.') ?></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>


<!-- 
     MODAL VIEW DETAIL PENJUALAN
     Menampilkan detail transaksi dalam mode readonly,
     dengan tampilan yang sama seperti penjualan.php
-->
<div class="modal fade" id="modalViewPenjualan" tabindex="-1" aria-labelledby="modalViewLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalViewLabel">
          Detail Penjualan &mdash;
          <span id="view-kodepj" class="text-primary fw-bold"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <!-- Header fields (readonly) -->
        <div class="mb-3">
          <div class="d-flex align-items-center mb-2">
            <label class="col-sm-1 col-form-label">Tanggal:</label>
            <div class="col-sm-2">
              <input type="date" class="form-control" id="view-tanggal" readonly>
            </div>
          </div>
          <div class="d-flex align-items-center mb-2">
            <label class="col-sm-1 col-form-label">Konsumen:</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="view-konsumen" readonly>
            </div>
          </div>
          <div class="d-flex align-items-center mb-2">
            <label class="col-sm-1 col-form-label">No. Telp:</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="view-telp" readonly>
            </div>
          </div>
          <div class="d-flex align-items-start mb-2">
            <label class="col-sm-1 col-form-label">Keterangan:</label>
            <div class="col-sm-2">
              <textarea class="form-control" id="view-ket" rows="2" readonly></textarea>
            </div>
          </div>
        </div>

        <!-- Detail Table (readonly) -->
        <table class="table table-bordered border-dark table-hover table-striped">
          <thead class="table-dark text-light">
            <tr>
              <th>Kode</th>
              <th>Nama</th>
              <th>Satuan</th>
              <th class="text-end">Harga</th>
              <th class="text-center">Qty</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody id="view-tbl-body"></tbody>
          <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class='text-end'>Total</td>
              <td class='text-end'>Rp <span id="view-total">0</span></td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td class='text-end'>
                Diskon
                <input type="number" id="view-diskon-persen"
                       class="form-control form-control-sm mt-1"
                       style="width:70px; display:inline-block;" readonly>
                <span class="text-muted">%</span>
              </td>
              <td class='text-end'>Rp <span id="view-diskon-nominal">0</span></td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td class='text-end'>Grandtotal</td>
              <td class='text-end'>Rp <span id="view-grandtotal">0</span></td>
            </tr>
          </tfoot>
        </table>

      </div><!-- /modal-body -->

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-dark" id="printdetail">Print</button>
      </div>

    </div>
  </div>
</div>


<script>
$(document).ready(function () {

  $("#printpenjualan").click(function () {
    const table = $("#myTable").DataTable();
    let datatable = [];

    table.rows().every(function () {
        const sel = $(this.node()).find("td");
        datatable.push({
            kode: sel.eq(1).text(),
            tanggal: sel.eq(2).text(),
            konsumen: sel.eq(3).text(),
            grandtotal: sel.eq(4).text()
        });
    });

    const url = 'printpenjualan.php?data=' + encodeURIComponent(JSON.stringify(datatable));
    window.open(url, '_blank');
});

$("#printdetail").click(function () {
    var header = {
      kodepj:      $('#view-kodepj').text(),
      tanggal:     $('#view-tanggal').val(),
      konsumen:    $('#view-konsumen').val(),
      telp:        $('#view-telp').val(),
      keterangan:  $('#view-ket').val()
    };

    var items = [];
    $('#view-tbl-body tr').each(function () {
      var td = $(this).find('td');
      items.push({
        kode:     td.eq(0).text(),
        nama:     td.eq(1).text(),
        satuan:   td.eq(2).text(),
        hjual:    td.eq(3).text().replace('Rp ', ''),
        qty:      td.eq(4).text(),
        subtotal: td.eq(5).text().replace('Rp ', '')
      });
    });

    var footer = {
      total:         $('#view-total').text(),
      diskon_persen:  $('#view-diskon-persen').val(),
      diskon_nominal: $('#view-diskon-nominal').text(),
      grandtotal:     $('#view-grandtotal').text()
    };

    var payload = { header: header, items: items, footer: footer };

    const url = 'printdetailjual.php?data=' + encodeURIComponent(JSON.stringify(payload));
    window.open(url, '_blank');
});

  $('#myTable').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      order: [[1, 'asc']],
      scrollX: true,
      scrollY: 200,
      responsive: true,
      language: {
        emptyTable: 'Tidak ada data penjualan.'
      }
    });

  /* ── Helper: muat halaman ke #isi (SPA) atau navigasi langsung ── */
  function loadPage(url) {
    if ($('#isi').length) {
      $('#isi').load(url);
    } else {
      window.location.href = url;
    }
  }

  /* ── Tombol Tambah Penjualan → navigasi ke penjualan.php ── */
  $('#btn-tambah-penjualan').on('click', function () {
    loadPage('penjualan.php');
  });

  /* ── Filter tanggal: cegah full-page submit, gunakan AJAX load ── */
  $('#formFilter').on('submit', function (e) {
    e.preventDefault();
    var tglAwal  = $('#spTglAwal').val();
    var tglAkhir = $('#spTglAkhir').val();
    var params   = [];
    if (tglAwal)  params.push('tgl_awal='  + encodeURIComponent(tglAwal));
    if (tglAkhir) params.push('tgl_akhir=' + encodeURIComponent(tglAkhir));
    var url = 'savepenjualan.php' + (params.length ? '?' + params.join('&') : '');
    loadPage(url);
  });

  /* ── Tombol Reset filter ── */
  $('#btn-reset-filter').on('click', function () {
    loadPage('savepenjualan.php');
  });

  /* ── Tombol View → fetch detail & tampilkan modal ── */
  $(document).on('click', '.btn-view-penjualan', function () {
    var kodepj = $(this).data('kodepj');

    // Kosongkan modal sebelum diisi
    $('#view-kodepj').text('');
    $('#view-tanggal, #view-konsumen, #view-telp').val('');
    $('#view-ket').val('');
    $('#view-tbl-body').empty();
    $('#view-total, #view-diskon-nominal, #view-grandtotal').text('0');
    $('#view-diskon-persen').val('');


    // AJAX load get_detail_penjualan.php

    $.ajax({
      url: 'get_detail_penjualan.php',
      method: 'POST',
      data: { kodepj: kodepj },
      dataType: 'json',
      success: function (data) {
        if (data.error) {
          alert('Error: ' + data.error);
          return;
        }

        var m = data.master;

        // Isi header
        $('#view-kodepj').text(m.kodepj);
        $('#view-tanggal').val(m.tanggal);
        $('#view-konsumen').val(m.konsumen);
        $('#view-telp').val(m['telp-kn']);
        $('#view-ket').val(m['ket-kn']);

        // Isi baris detail tabel
        var rows = '';
        $.each(data.details, function (i, d) {
          rows += '<tr>'
            + '<td>' + d.kode    + '</td>'
            + '<td>' + (d.nama   || '') + '</td>'
            + '<td>' + (d.satuan || '') + '</td>'
            + '<td class="text-end">Rp ' + parseFloat(d.hjual).toLocaleString('id-ID')    + '</td>'
            + '<td class="text-center">' + d.qty     + '</td>'
            + '<td class="text-end">Rp ' + parseFloat(d.subtotal).toLocaleString('id-ID') + '</td>'
            + '</tr>';
        });
        $('#view-tbl-body').html(rows);

        // Isi footer (total, diskon, grandtotal)
        var total     = parseFloat(m.total)      || 0;
        var diskon    = parseFloat(m.diskon)      || 0;
        var grandtotal= parseFloat(m.grandtotal)  || 0;
        var persen    = total > 0 ? Math.round(diskon / total * 100) : 0;

        $('#view-total').text(total.toLocaleString('id-ID'));
        $('#view-diskon-persen').val(persen);
        $('#view-diskon-nominal').text(diskon.toLocaleString('id-ID'));
        $('#view-grandtotal').text(grandtotal.toLocaleString('id-ID'));

        // Tampilkan modal Bootstrap
        var modalEl = document.getElementById('modalViewPenjualan');
        var modal   = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
      },
      error: function () {
        alert('Gagal mengambil data detail penjualan!');
      }
    });
  });

});
</script>