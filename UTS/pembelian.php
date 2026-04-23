

  <div class="container-fluid mt-3">
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
        <label class="col-sm-1 col-form-label">Supplier:</label> <!-- label untuk konsumen -->
        <div class="col-sm-2">
          <input type="text" class="form-control" id="supplier" placeholder="Nama supplier"> <!-- input konsumen -->
        </div>
      </div>

      <div class="d-flex align-items-center mb-2">
        <label class="col-sm-1 col-form-label">Alamat:</label> <!-- label untuk konsumen -->
        <div class="col-sm-2">
          <input type="text" class="form-control" id="alamat" placeholder="Alamat Supplier"> <!-- input konsumen -->
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
        <label class="mb-1">harga</label>
        <input type="number" class="form-control" id="harga" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">qty</label>
        <input type="number" class="form-control" id="qty" placeholder="Qty" min="1" value="">
      </div>
      <div class="col-sm-2">
        <label class="mb-1">subtotal</label>
        <input type="number" class="form-control bg-body-secondary" id="subtotal_preview" placeholder="Subtotal"
          readonly>
      </div>
      <div class="col-sm-1 d-flex align-items-end">
        <button id="tambah" class="btn btn-primary w-100">tambah</button>
      </div>
    </div>


    <!-- Table -->
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
  </div>



  <!-- The Modal -->
  <div class="modal" id="masteritem">
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
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m001','produk 01', 'pcs', '59000')">pilih</button></td>
                <td>m001</td>
                <td>produk 01</td>
                <td>pcs</td>
                <td>59000</td>
              </tr>
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m002','produk 02', 'pcs', '19000')">pilih</button></td>
                <td>m002</td>
                <td>produk 02</td>
                <td>pcs</td>
                <td>19000</td>
              </tr>
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m003','produk 03', 'pcs', '91000')">pilih</button></td>
                <td>m003</td>
                <td>produk 03</td>
                <td>pcs</td>
                <td>91000</td>
              </tr>
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m004','produk 04', 'pcs', '39000')">pilih</button></td>
                <td>m004</td>
                <td>produk 04</td>
                <td>pcs</td>
                <td>39000</td>
              </tr>
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
    function tambahtabel(kode, nama, satuan, harga) {
      $("#kode").val(kode);
      $("#nama").val(nama);
      $("#satuan").val(satuan);
      $("#harga").val(harga);
      $("#qty").val("").focus();
      $("#subtotal_preview").val("");
    }

    function hitungtotal() {
      let total = 0;

      $("#tbldata tbody tr").each(function () {
        let harga = parseFloat($(this).find(".harga").text()) || 0;
        let qty = parseInt($(this).find(".qty").text()) || 1;
        let subtotal = harga * qty;
        $(this).find(".subtotal").text("Rp " + subtotal);
        total += subtotal;
        console.log(total);
      });

      $("#tot").html("<b>" + total + "</b>");

      // diskon
      let persen = parseFloat($("#diskon_persen").val()) || 0;
      let nominal = Math.round(total * persen / 100);
      $("#diskon_nominal").text(nominal);

      // grandtotal
      let grandtotal = total - nominal;
      if (grandtotal < 0) grandtotal = 0;
      $("#grandtotal").text(grandtotal);

    }

    // update subtotal preview 
    function updateSubtotalPreview() {
      let harga = parseFloat($("#harga").val()) || 0;
      let qty = parseInt($("#qty").val()) || 0;
      $("#subtotal_preview").val(qty > 0 ? harga * qty : "");
    }

    $(document).ready(function () {

      // update preview saat qty diketik 
      $("#qty").on("input", function () {
        updateSubtotalPreview();
      });

      // tombol tambah
      $("#tambah").click(function () {
        let x = $("#kode").val().trim();
        let y = $("#nama").val().trim();
        let s = $("#satuan").val().trim();
        let z = parseFloat($("#harga").val()) || 0;
        let q = parseInt($("#qty").val()) || 0;

        if (x === "") { alert("Pilih item dulu!"); return; }
        if (q <= 0) { alert("Isi Qty terlebih dahulu!"); return; }

        let subtotal = z * q;

        let tbltr = `<tr>
          <td><button class="btn btn-danger hapus">X</button></td>
          <td>${x}</td>
          <td>${y}</td>
          <td>${s}</td>
          <td class="harga">${z}</td>
          <td class="qty">${q}</td>
          <td class="subtotal">Rp ${subtotal}</td>
        </tr>`;

        $("#tbldata tbody").append(tbltr);
        hitungtotal();

        // reset input row
        $("#kode, #nama, #satuan, #harga, #qty, #subtotal_preview").val("");
      });

      // tombol hapus
      $("#tbldata").on("click", ".hapus", function () {
        $(this).closest('tr').remove();
        hitungtotal();
      });


      $("#diskon_persen").on("input", function () {
        hitungtotal();
      });

    });
  </script>

