<?php
include 'connect.php';

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-d');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

/* --- Query total penjualan per tanggal --- */
$sqlPJ = "SELECT tanggal, SUM(grandtotal) AS total_penjualan
          FROM masterpenjualan
          WHERE tanggal BETWEEN ? AND ?
          GROUP BY tanggal ORDER BY tanggal ASC";
$stmtPJ = $conn->prepare($sqlPJ);
$stmtPJ->bind_param('ss', $tgl_awal, $tgl_akhir);
$stmtPJ->execute();
$resPJ = $stmtPJ->get_result();
$labelsPJ = [];
$valuesPJ = [];
while ($row = $resPJ->fetch_assoc()) {
    $labelsPJ[] = date('d-m', strtotime($row['tanggal']));
    $valuesPJ[] = (float)$row['total_penjualan'];
}

/* --- Query total pembelian per tanggal --- */
$sqlPB = "SELECT tanggal, SUM(grandtotal) AS total_pembelian
          FROM masterpembelian
          WHERE tanggal BETWEEN ? AND ?
          GROUP BY tanggal ORDER BY tanggal ASC";
$stmtPB = $conn->prepare($sqlPB);
$stmtPB->bind_param('ss', $tgl_awal, $tgl_akhir);
$stmtPB->execute();
$resPB = $stmtPB->get_result();
$labelsPB = [];
$valuesPB = [];
while ($row = $resPB->fetch_assoc()) {
    $labelsPB[] = date('d-m', strtotime($row['tanggal']));
    $valuesPB[] = (float)$row['total_pembelian'];
}
?>

<div class="container-fluid px-4 py-4">
  <h4 class="mb-4 fw-bold">Dashboard</h4>

  <form id="formFilterDashboard" class="d-flex align-items-end gap-3 mb-4 flex-wrap">
    <div>
      <label class="form-label mb-1 small fw-semibold">Tanggal Awal</label>
      <input type="date" id="dshTglAwal" class="form-control" value="<?= htmlspecialchars($tgl_awal) ?>">
    </div>
    <div>
      <label class="form-label mb-1 small fw-semibold">Tanggal Akhir</label>
      <input type="date" id="dshTglAkhir" class="form-control" value="<?= htmlspecialchars($tgl_akhir) ?>">
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-primary">Filter</button>
      <button type="button" class="btn btn-outline-secondary" id="btn-reset-dashboard">Reset</button>
    </div>
  </form>

  <div class="row">
    <div class="col-md-6">
      <canvas id="chartPenjualan" style="width:100%;"></canvas>
    </div>
    <div class="col-md-6">
      <canvas id="chartPembelian" style="width:100%;"></canvas>
    </div>
  </div>
</div>

<script>
var labelsPJ = <?= json_encode($labelsPJ) ?>;
var valuesPJ = <?= json_encode($valuesPJ) ?>;
var labelsPB = <?= json_encode($labelsPB) ?>;
var valuesPB = <?= json_encode($valuesPB) ?>;

new Chart("chartPenjualan", {
  type: "bar",
  data: {
    labels: labelsPJ,
    datasets: [{
      backgroundColor: "rgba(13,110,253,0.7)",
      data: valuesPJ
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      title: { display: true, text: "Penjualan", font: { size: 16 } }
    },
    scales: {
      y: { beginAtZero: true, ticks: { callback: function(v){ return 'Rp ' + v.toLocaleString('id-ID'); } } }
    }
  }
});

new Chart("chartPembelian", {
  type: "bar",
  data: {
    labels: labelsPB,
    datasets: [{
      backgroundColor: "rgba(220,53,69,0.7)",
      data: valuesPB
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      title: { display: true, text: "Pembelian", font: { size: 16 } }
    },
    scales: {
      y: { beginAtZero: true, ticks: { callback: function(v){ return 'Rp ' + v.toLocaleString('id-ID'); } } }
    }
  }
});

$('#formFilterDashboard').on('submit', function(e){
  e.preventDefault();
  var awal   = $('#dshTglAwal').val();
  var akhir  = $('#dshTglAkhir').val();
  var params = [];
  if (awal)  params.push('tgl_awal='  + encodeURIComponent(awal));
  if (akhir) params.push('tgl_akhir=' + encodeURIComponent(akhir));
  $('#isi').load('dashboard.php' + (params.length ? '?' + params.join('&') : ''));
});

$('#btn-reset-dashboard').on('click', function(){
  $('#isi').load('dashboard.php');
});
</script>
