

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
        <input type="hidden" id="harga_dasar">
      </div>
      <div class="col-sm-1">
        <label class="mb-1">tipe</label>
        <select class="form-select" id="tipe">
          <option value="" disabled selected>Pilih Tipe</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
        </select>
      </div>
      <div class="col-sm-1">
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
          <th>tipe</th>
          <th>harga</th>
          <th>qty</th>
          <th>subtotal</th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <td colspan="6"></td>
          <td>Total</td>
          <td>Rp <span id="tot">0</span></td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>
            Diskon
            <input type="number" id="diskon_persen" class="form-control form-control-sm mt-1" placeholder="0" min="0"
              max="100" style="width:70px; display:inline-block;">
            <span class="text-muted">%</span>
          </td>
          <td>Rp <span id="diskon_nominal">0</span></td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Grandtotal</td>
          <td>Rp <span id="grandtotal">0</span></td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Bayar</td>
          <td class="d-flex align-items-center gap-2">
            <span>Rp</span>
            <input type="number" id="bayar" class="form-control">
          </td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Kembalian</td>
          <td>Rp <span id="kembali">0</span></td>
        </tr>
      </tfoot>
    </table>
  </div>



  <!-- The Modal -->
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
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m001','baju 01', 'pcs', '59000')">pilih</button></td>
                <td>m001</td>
                <td>baju 01</td>
                <td>pcs</td>
                <td>59000</td>
              </tr>
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m002','baju 02', 'pcs', '19000')">pilih</button></td>
                <td>m002</td>
                <td>baju 02</td>
                <td>pcs</td>
                <td>19000</td>
              </tr>
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m003','baju 03', 'pcs', '91000')">pilih</button></td>
                <td>m003</td>
                <td>baju 03</td>
                <td>pcs</td>
                <td>91000</td>
              </tr>
              <tr>
                <td><button class="btn btn-success" data-bs-dismiss="modal"
                    onclick="tambahtabel('m004','baju 04', 'pcs', '39000')">pilih</button></td>
                <td>m004</td>
                <td>baju 04</td>
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
    // Tambahan harga per tipe
    

    function tambahtabel(kode, nama, satuan, harga) { // tambah data ke row input stlh btn pilih diklik
      $("#kode").val(kode);
      $("#nama").val(nama);
      $("#satuan").val(satuan);
      $("#harga_dasar").val(harga);   // simpan harga asli
      $("#tipe").val(""); 
      $("#harga").val(harga);         // tampilkan harga awal dulu
      $("#qty").val(1).focus();
      $("#subtotal_preview").val("");
    }

    function hitungtotal() {
      let total = 0;

      $("#tbldata tbody tr").each(function () {
        let harga = parseFloat($(this).find(".harga").data('val')) || 0;
        let qty = parseInt($(this).find(".qty").data('val')) || 1;
        let subtotal = harga * qty;
        $(this).find(".subtotal").text("Rp " + subtotal);
        total += subtotal;
      });

      $("#tot").html("<b>" + total + "</b>");

      let persen = parseFloat($("#diskon_persen").val()) || 0;
      let nominal = Math.round(total * persen / 100);
      $("#diskon_nominal").text(nominal);

      
      let grandtotal = total - nominal;
      if (grandtotal < 0) grandtotal = 0;
      $("#grandtotal").text(grandtotal);

      
      let bayar = parseFloat($("#bayar").val()) || 0;
      let kembali = bayar >= grandtotal ? bayar - grandtotal : 0;
      $("#kembali").text(kembali);
    }

    // update subtotal preview
    function updateSubtotalPreview() {
      let harga = parseFloat($("#harga").val()) || 0;
      let qty = parseInt($("#qty").val()) || 0;
      $("#subtotal_preview").val(qty > 0 ? harga * qty : "");
    }

    $(document).ready(function () {

      
      $(document).on("change", "#tipe", function () {
        let hargaDasar = parseFloat($("#harga_dasar").val()) || 0;
        let tipe = $(this).val();
        let tambahan = 0;

        if (tipe === "S") {
          tambahan = 1000;
        } else if (tipe === "M") {
          tambahan = 2000;
        } else if (tipe === "L") {
          tambahan = 3000;
        } else if (tipe === "XL") {
          tambahan = 4000;
        }

        let hargaBaru = hargaDasar + tambahan;
        $("#harga").val(hargaBaru);
        updateSubtotalPreview();
      });

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
        let t = $("#tipe").val() || "";
        let q = parseInt($("#qty").val()) || 0;

        if (x === "") { alert("Pilih item dulu!"); return; }
        if (t === "" || t === "") { alert("Pilih tipe terlebih dahulu!"); return; }
        if (q <= 0) { alert("Isi Qty terlebih dahulu!"); return; }

        let subtotal = z * q;

        let tbltr = `<tr>
          <td><button class="btn btn-danger hapus">X</button></td>
          <td>${x}</td>
          <td>${y}</td>
          <td>${s}</td>
          <td class="harga" data-val="${z}">${z}</td>
          <td>${t}</td>
          <td class="qty" data-val="${q}">${q}</td>
          <td class="subtotal">Rp ${subtotal}</td>
        </tr>`;

        $("#tbldata tbody").append(tbltr);
        hitungtotal();

        // reset input row
        $("#kode, #nama, #satuan, #harga, #tipe, #qty, #subtotal_preview, #harga_dasar").val("");
      });

      // tombol hapus
      $("#tbldata").on("click", ".hapus", function () {
        $(this).closest('tr').remove();
        hitungtotal();
      });

      $("#diskon_persen").on("input", function () {
        hitungtotal();
      });

      $("#bayar").on("input", function () {
        hitungtotal();
      });

    });
  </script>

