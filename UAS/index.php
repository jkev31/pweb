<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0"></script>
  <link href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css" rel="stylesheet">

  <script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script> 
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/chart.js"></script>
  <link href="DataTables/datatables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="DataTables/dataTables.min.js"></script> -->
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="nav-produk">produk</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="nav-supplier">supplier</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="pembelian">pembelian</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="penjualan">penjualan</a>
                    </li>
                </ul>
      
            </div>
        </div>
    </nav>


    <!-- Container -->
    <div class="container-fluid">
        <div id="isi">
            
        </div>
    </div>



<script>
    $(document).ready(function(){
        $("#isi").load("dashboard.php");
        $("#dashboard").click(function(){
            $("#isi").load("dashboard.php");
        });
        $("#pembelian").click(function(){
            $("#isi").load("savepembelian.php");
        });
        $("#penjualan").click(function(){
            $("#isi").load("savepenjualan.php");
        });
        $("#nav-produk").click(function(){
            $("#isi").load("produk.php");
        });
        $("#nav-supplier").click(function(){
            $("#isi").load("supplier.php");
        });
    });
</script>


</body>

</html>