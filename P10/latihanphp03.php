<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body>
<div class="container mt-3">
  <h2>Items</h2>
  <button class="btn btn-primary" id="tambah" data-bs-toggle="modal" data-bs-target="#myModaltambah">Tambah</button>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Action</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Satuan</th>
        <th>Beli</th>
        <th>Jual</th>
      </tr>
    </thead>
    <tbody>
      
<?php
include "koneksi.php";

$sql = "SELECT * FROM items";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>";
    echo '<button class="btn btn-danger" id="ubah" data-bs-toggle="modal" data-bs-target="#myModalubah">Ubah</button>';
    echo "</td><td>";
    echo $row["kode"];
     echo "</td><td>";
     echo $row["nama"];
     echo "</td><td>";
      echo $row["satuan"];
      echo "</td><td>";
       echo $row["hbeli"];
       echo "</td><td>";
        echo $row["hjual"];
        echo "</td></tr>";
  }
} 

$conn->close();
?>
</tbody>
</table>
</div>

<div class="modal" id="myModaltambah">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
     <div class="modal-body">
     <div class="mt-1">
     
     <input type="text" class="form-control" id="kode" placeholder="Enter Kode" name="kode">
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="nama" placeholder="Enter nama" name="nama">
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="satuan" placeholder="Enter Satuan" name="satuan">
     </div>
     <div class="mt-1">
     
     <input type="number" class="form-control" id="hbeli" placeholder="Enter Harga Beli" name="hbeli">
     </div>
     <div class="mt-1">
    
     <input type="number" class="form-control" id="hjual" placeholder="Enter Harga Jual" name="hjual">
     </div>




      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="save">Save</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


<div class="modal" id="myModalubah">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
     <div class="modal-body">
     <div class="mt-1">
     
     <input type="text" class="form-control" id="kode1" placeholder="Enter Kode" name="kode">
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="nama1" placeholder="Enter nama" name="nama">
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="satuan1" placeholder="Enter Satuan" name="satuan">
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
         <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="delete">Delete</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
   
$("#save").click(function(){
     var formdata = new FormData();
     formdata.append('kode',$("#kode").val());
     formdata.append('nama',$("#nama").val());
     formdata.append('satuan',$("#satuan").val());
     formdata.append('hbeli',$("#hbeli").val());
     formdata.append('hjual',$("#hjual").val());

     $.ajax({
        type: 'POST',
        url: 'latihanphp04.php',
        data: formdata, // Mengambil semua data form
        processData:false,
        contentType:false,
        success: function(response) {
            console.log('Sukses:', response);
            alert('Data berhasil dikirim!');
            window.location.href = "latihanphp03.php";
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });


});   

$("#update").click(function(){

});

$("#delete").click(function(){

});




</script>


</body>
</html>
