<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save') {
    header('Content-Type: application/json');

    $kode   = $_POST['kodepr'] ?? '';
    $nama   = $_POST['namapr'] ?? '';
    $satuan = $_POST['satuan'] ?? '';
    $harga  = (float)($_POST['harga']    ?? 0);
    $diskon = (float)($_POST['diskon']   ?? 0);
    $gudang = $_POST['gudang'] ?? '';

    $stmt = $conn->prepare("INSERT INTO items (kodepr, namapr, satuan, harga, diskon, gudang) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssdds', $kode, $nama, $satuan, $harga, $diskon, $gudang);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }
    echo json_encode(['success' => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    header('Content-Type: application/json');

    $kode   = $_POST['kodepr'] ?? '';
    $nama   = $_POST['namapr'] ?? '';
    $satuan = $_POST['satuan'] ?? '';
    $harga  = (float)($_POST['harga']    ?? 0);
    $diskon = (float)($_POST['diskon']   ?? 0);
    $gudang = $_POST['gudang'] ?? '';

    $stmt = $conn->prepare("UPDATE items SET namapr=?, satuan=?, harga=?, diskon=?, gudang=? WHERE kodepr=?");
    $stmt->bind_param('ssddss', $nama, $satuan, $harga, $diskon, $gudang, $kode);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }
    echo json_encode(['success' => true]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    header('Content-Type: application/json');

    $kode = $_POST['kodepr'] ?? '';

    $stmt = $conn->prepare("DELETE FROM items WHERE kodepr=?");
    $stmt->bind_param('s', $kode);

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
        exit;
    }
    echo json_encode(['success' => true]);
    exit;
}

$sql = "SELECT * FROM items ORDER BY kodepr";
$result = $conn->query($sql);
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TblItem</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <link href="DataTables/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="DataTables/dataTables.min.js"></script>
</head>
<body>
  <div id="isi">
    <div class="container-fluid px-4 py-4">
      <h4 class="mb-4 fw-bold">Daftar Produk</h4>

      <div class="mb-3">
        <button class="btn btn-primary" id="btn-tambah">Tambah</button>
      </div>

      <div class="table-responsive">
        <table id="myTable" class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th class="text-center col-1">Action</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Satuan</th>
              <th class="text-end">Harga</th>
              <th class="text-end">Diskon</th>
              <th class="text-center">Gudang</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>
              <tr>
                <td class="text-center">
                  <button class="btn btn-warning btn-sm btn-edit"
                    data-kodepr="<?= htmlspecialchars($row['kodepr']) ?>"
                    data-namapr="<?= htmlspecialchars($row['namapr']) ?>"
                    data-satuan="<?= htmlspecialchars($row['satuan']) ?>"
                    data-harga="<?= htmlspecialchars($row['harga']) ?>"
                    data-diskon="<?= htmlspecialchars($row['diskon']) ?>"
                    data-gudang="<?= htmlspecialchars($row['gudang']) ?>">
                    Edit
                  </button>
                  
                </td>
                <td class="text-center"><?= htmlspecialchars($row['kodepr']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['namapr']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['satuan']) ?></td>
                <td class="text-end">Rp <?= number_format((float)$row['harga'], 0, ',', '.') ?></td>
                <td class="text-end">Rp <?= number_format((float)$row['diskon'], 0, ',', '.') ?></td>
                <td class="text-center"><?= htmlspecialchars($row['gudang']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script>
$(document).ready(function () {

  function loadPage(url) {
    $('#isi').load(url);
  }

  $('#btn-tambah').on('click', function () {
    loadPage('input.php');
  });

  $(document).on('click', '.btn-edit', function () {
    var d = $(this).data();
    var params = $.param({
      kodepr: d.kodepr, namapr: d.namapr, satuan: d.satuan,
      harga: d.harga, diskon: d.diskon, gudang: d.gudang
    });
    loadPage('edit.php?' + params);
  });
});
</script>
</body>
</html>
