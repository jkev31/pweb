

<div class="container mt-3">
  <h2>Daftar Supplier</h2>
  <button class="btn btn-primary" id="tambah" data-bs-toggle="modal" data-bs-target="#myModaltambah" >
    Tambah
  </button>
  <table id="myTable" class="table table-bordered table-striped mt-3 display nowrap">
    <thead>
      <tr>
        <th class="text-center">Action</th>
        <th class="text-center">Kode</th>
        <th class="text-center">Nama</th>
        <th class="text-center">Alamat</th>
        <th class="text-center">Kota</th>
        <th class="text-center">Ket</th>
        <th class="text-center">Telp</th>
      </tr>
    </thead>
    <tbody>
        <?php
include "connect.php";

$sql = "SELECT * FROM suppliers";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr> <td class='text-center'>";
    echo '<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModalubah" onclick="setModalData(\''.$row['kode-sup'].'\', \''.$row['nama-sup'].'\', \''.$row['alamat-sup'].'\', \''.$row['kota-sup'].'\', \''.$row['ket-sup'].'\', \''.$row['telp-sup'].'\')">Ubah</button>';
    echo "</td> <td class='text-center'>";
    echo $row["kode-sup"];
    echo "</td> <td class='text-center'>";
    echo $row["nama-sup"];
    echo "</td> <td class='text-center'>";
    echo $row["alamat-sup"];
    echo "</td> <td class='text-center'>";
    echo $row["kota-sup"];
    echo "</td><td class='text-center'>";
    echo $row["ket-sup"];
    echo "</td><td class='text-center'>";
    echo $row["telp-sup"];
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
        <h4 class="modal-title">Tambah Supplier</h4>
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
        <input type="text" class="form-control" id="alamat" placeholder="Enter alamat" name="alamat">
        </div>

        <div class="mt-1">
        
        <input type="text" class="form-control" id="kota" placeholder="Enter kota" name="kota">
        </div>

        <div class="mt-1">
        <input type="text" class="form-control" id="ket" placeholder="Enter ket" name="ket">
        </div>
        <div class="mt-1">
        <input type="text" class="form-control" id="telp" placeholder="Enter telp" name="telp">
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
     
     <input type="text" class="form-control" id="alamat1" placeholder="Enter alamat" name="alamat" >
     </div>
     <div class="mt-1">
     
     <input type="text" class="form-control" id="kota1" placeholder="Enter kota" name="kota">
     </div>
     <div class="mt-1">
    
     <input type="text" class="form-control" id="ket1" placeholder="Enter ket" name="ket">
     </div>
     <div class="mt-1">
     <input type="text" class="form-control" id="telp1" placeholder="Enter telp" name="telp">
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

function setModalData(kode, nama, alamat, kota, ket, telp) {
    $("#kode1").val(kode);
    $("#nama1").val(nama);
    $("#alamat1").val(alamat);
    $("#kota1").val(kota);
    $("#ket1").val(ket);
    $("#telp1").val(telp);
}

$("#save").click(function(){
     var formdata = new FormData();
     formdata.append('kode-sup',$("#kode").val());
     formdata.append('nama-sup',$("#nama").val());
     formdata.append('alamat-sup',$("#alamat").val());
     formdata.append('kota-sup',$("#kota").val());
     formdata.append('ket-sup',$("#ket").val());
     formdata.append('telp-sup',$("#telp").val());

     $.ajax({
        type: 'POST',
        url: 'insertsup.php',
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
    formdata.append('kode-sup',$("#kode1").val());
    formdata.append('nama-sup',$("#nama1").val());
    formdata.append('alamat-sup',$("#alamat1").val());
    formdata.append('kota-sup',$("#kota1").val());
    formdata.append('ket-sup',$("#ket1").val());
    formdata.append('telp-sup',$("#telp1").val());

     $.ajax({
        type: 'POST',
        url: 'updatesup.php',
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
     formdata.append('kode-sup',$("#kode1").val());
     formdata.append('nama-sup',$("#nama1").val());
     formdata.append('alamat-sup',$("#alamat1").val());
     formdata.append('kota-sup',$("#kota1").val());
     formdata.append('ket-sup',$("#ket1").val());
     formdata.append('telp-sup',$("#telp1").val());

     $.ajax({
        type: 'POST',
        url: 'deletesup.php',
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
