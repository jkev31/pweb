<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>

</head>
<body>

<div class="container mt-3">
  <h2>Daftar Produk</h2>
  <button class="btn btn-primary" id="tambah" data-bs-toggle="modal" data-bs-target="#myModaltambah" >
    Tambah
  </button>
  <table id="myTable" class="table table-bordered table-striped mt-3 display nowrap">
    <thead>
      <tr>
        <th class="text-center">Action</th>
        <th class="text-center">Kode</th>
        <th class="text-center">Nama</th>
        <th class="text-center">Satuan</th>
        <th class="text-end">Harga Beli</th>
        <th class="text-end">Harga Jual</th>
      </tr>
    </thead>
    <tbody>
        <?php
include "connect.php";

$sql = "SELECT * FROM items";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr> <td class='text-center'>";
    echo '<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModalubah" onclick="setModalData(\''.$row['kode'].'\', \''.$row['nama'].'\', \''.$row['satuan'].'\', \''.$row['hbeli'].'\', \''.$row['hjual'].'\')">Ubah</button>';
    echo "</td> <td class='text-center'>";
    echo $row["kode"];
    echo "</td> <td class='text-center'>";
    echo $row["nama"];
    echo "</td> <td class='text-center'>";
    echo $row["satuan"];
    echo "</td> <td class='text-end'>";
    echo $row["hbeli"];
    echo "</td><td class='text-end'>";
    echo $row["hjual"];
    echo "</td></tr>";
    
  }
} else {
  echo "0 results";
}

$conn->close();
?>
</tbody>
</table>



<!-- The Modal -->
<div class="modal" id="myModaltambah">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Item</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">

        <div class="mt-1">
       
        <input type="text" class="form-control" id="kode" placeholder="Enter kode" name="kode">
        </div>

        <div class="mt-1">
        <input type="text" class="form-control" id="nama" placeholder="Enter nama" name="nama">
        </div>

        <div class="mt-1">
        <input type="text" class="form-control" id="satuan" placeholder="Enter satuan" name="satuan">
        </div>

        <div class="mt-1">
        
        <input type="number" class="form-control" id="hbeli" placeholder="Enter harga beli" name="hbeli">
        </div>

        <div class="mt-1">
        <input type="number" class="form-control" id="hjual" placeholder="Enter harga jual" name="hjual">
        </div>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="save" >Save</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Update -->


<div class="modal" id="myModalubah">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Ubah</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
     <div class="modal-body">
     <div class="mt-1">
     
     <input type="text" class="form-control" id="kode1" placeholder="Enter Kode" name="kode" readonly>
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="nama1" placeholder="Enter nama" name="nama">
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="satuan1" placeholder="Enter Satuan" name="satuan" >
     </div>
     <div class="mt-1">
     
     <input type="number" class="form-control" id="hbeli1" placeholder="Enter Harga Beli" name="hbeli">
     </div>
     <div class="mt-1">
    
     <input type="number" class="form-control" id="hjual1" placeholder="Enter Harga Jual" name="hjual">
     </div>




      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="update">Update</button>
         <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="delete">Delete</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<script>

$(document).ready(function() {
    $('#myTable').DataTable({
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      order: [[1, 'asc']],
      scrollX: true,
      scrollY: 200,
      responsive: true
    });
});

function setModalData(kode, nama, satuan, hbeli, hjual) {
    $("#kode1").val(kode);
    $("#nama1").val(nama);
    $("#satuan1").val(satuan);
    $("#hbeli1").val(hbeli);
    $("#hjual1").val(hjual);
}

$("#save").click(function(){
     var formdata = new FormData();
     formdata.append('kode',$("#kode").val());
     formdata.append('nama',$("#nama").val());
     formdata.append('satuan',$("#satuan").val());
     formdata.append('hbeli',$("#hbeli").val());
     formdata.append('hjual',$("#hjual").val());

     $.ajax({
        type: 'POST',
        url: 'insertprdk.php',
        data: formdata, // Mengambil semua data form
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

$("#update").click(function(){
    var formdata = new FormData();
     formdata.append('nama',$("#nama1").val());
     formdata.append('satuan',$("#satuan1").val());
     formdata.append('hbeli',$("#hbeli1").val());
     formdata.append('hjual',$("#hjual1").val());

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

$("#delete").click(function(){
    var formdata = new FormData();
     formdata.append('kode',$("#kode1").val());
     formdata.append('nama',$("#nama1").val());
     formdata.append('satuan',$("#satuan1").val());
     formdata.append('hbeli',$("#hbeli1").val());
     formdata.append('hjual',$("#hjual1").val());

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


</script>
</body>
</html>
