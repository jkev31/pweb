

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


    <!-- Input Row: Menampung input data barang sebelum dimasukkan ke keranjang belanja -->
    <!-- Input-input ini memiliki ID unik yang digunakan oleh JavaScript untuk mengambil nilainya. -->
    <div class="row mb-3 mt-3">
      <div class="col-sm-1">
        <label class="mb-1">kode</label>
        <!-- Input kode bersifat readonly (tidak bisa diketik manual). -->
        <!-- Atribut data-bs-toggle="modal" dan data-bs-target="#masteritem" memicu modal Bootstrap terbuka saat input ini diklik -->
        <input type="text" class="form-control" id="kode" data-bs-toggle="modal" data-bs-target="#masteritem" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">nama</label>
        <!-- Field otomatis terisi oleh fungsi tambahtabel() di JavaScript saat item dipilih dari modal -->
        <input type="text" class="form-control" id="nama" readonly>
      </div>
      <div class="col-sm-1">
        <label class="mb-1">satuan</label>
        <input type="text" class="form-control" id="satuan" readonly>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">harga</label>
        <!-- Input number untuk harga dasar item (otomatis terisi) -->
        <input type="number" class="form-control" id="harga" readonly>
      </div>
      <div class="col-sm-1">
        <label class="mb-1">tipe</label>
        <!-- Elemen Select untuk memilih ukuran. Perubahan nilai (event 'change') akan ditangkap JS untuk update subtotal -->
        <select class="form-select" id="tipe">
          <option value="" disabled selected>tipe</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
        </select>
      </div>
      <div class="col-sm-2">
        <label class="mb-1">qty</label>
        <!-- Input untuk jumlah barang. Perubahan (event 'input') ditangkap JS untuk update subtotal preview -->
        <input type="number" class="form-control" id="qty" placeholder="Qty" min="1" value="">
      </div>
      <div class="col-sm-2">
        <label class="mb-1">subtotal</label>
        <!-- Field readonly untuk menampilkan estimasi subtotal dari item yang sedang diinput sebelum ditambahkan -->
        <input type="number" class="form-control bg-body-secondary" id="subtotal_preview" placeholder="Subtotal"
          readonly>
      </div>
      <div class="col-sm-1 d-flex align-items-end">
        <!-- Tombol tambah dengan ID 'tambah'. JS mendengarkan event klik tombol ini untuk memasukkan data ke dalam tabel -->
        <button id="tambah" class="btn btn-primary w-100">tambah</button>
      </div>
    </div>


    <!-- Table: Digunakan sebagai wadah daftar keranjang belanja -->
    <!-- JS menggunakan ID 'tbldata' untuk menargetkan tabel ini. -->
    <table class="table table-bordered border-dark table-hover table-striped" id="tbldata">
      <thead class="table-dark text-light">
        <tr>
          <th>Action</th>
          <th>kode</th>
          <th>nama</th>
          <th>satuan</th>
          <th>harga</th>
          <th>tipe</th>
          <th>qty</th>
          <th>subtotal</th>
        </tr>
      </thead>
      <!-- Elemen <tbody> dibiarkan kosong di HTML. JavaScript akan menambahkan elemen <tr> (baris) ke dalam tbody ini secara dinamis melalui tombol 'tambah' -->
      <tbody></tbody>
      <tfoot>
        <!-- Bagian footer tabel untuk menampilkan kalkulasi akhir transaksi -->
        <tr>
          <td colspan="6"></td>
          <td>Total</td>
          <!-- Elemen <span> digunakan karena merupakan wadah teks inline. ID 'tot' dipakai JS untuk menampilkan nilai akumulasi subtotal -->
          <td>Rp <span id="tot">0</span></td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>
            Diskon
            <!-- Input diskon langsung memicu event di JS untuk menghitung ulang kalkulasi saat nilainya diubah -->
            <input type="number" id="diskon_persen" class="form-control form-control-sm mt-1" placeholder="0" min="0"
              max="100" style="width:70px; display:inline-block;">
            <span class="text-muted">%</span>
          </td>
          <!-- Span ID 'diskon_nominal' dipakai JS untuk menampilkan konversi diskon persen ke nominal Rupiah -->
          <td>Rp <span id="diskon_nominal">0</span></td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Grandtotal</td>
          <!-- Span ID 'grandtotal' dipakai JS untuk menampilkan Total dikurangi Diskon Nominal -->
          <td>Rp <span id="grandtotal">0</span></td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Bayar</td>
          <td class="d-flex align-items-center gap-2">
            <span>Rp</span>
            <!-- Input nominal bayar dari kasir. JS mendengarkan perubahan ini untuk menghitung uang kembali -->
            <input type="number" id="bayar" class="form-control">
          </td>
        </tr>
        <tr>
          <td colspan="6"></td>
          <td>Kembalian</td>
          <!-- Span ID 'kembali' untuk hasil output penghitungan (Bayar - Grandtotal) oleh JS -->
          <td>Rp <span id="kembali">0</span></td>
        </tr>
      </tfoot>
    </table>
  </div>



  <!-- The Modal: Komponen pop-up (Bootstrap Modal) untuk menampung daftar referensi barang -->
  <!-- Ditampilkan ketika input dengan data-bs-target="#masteritem" diklik -->
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
              <!-- Daftar barang statis di dalam modal -->
              <tr>
                <!-- Tombol pilih mengeksekusi dua aksi: 1) data-bs-dismiss="modal" untuk menutup pop-up. 2) onclick="tambahtabel(...)" untuk melempar parameter data barang ke fungsi JS -->
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
    // Fungsi ini dipanggil ketika pengguna mengklik tombol "pilih" pada modal Master Item.
    // Alur: Menerima data dari parameter -> Mengisi field input di form atas -> Menyiapkan qty default -> Mengkalkulasi preview.
    function tambahtabel(kode, nama, satuan, harga) { 
      // Mengisi field input dengan data parameter
      $("#kode").val(kode);
      $("#nama").val(nama);
      $("#satuan").val(satuan);
      $("#harga").val(harga);
      $("#tipe").val(tipe);
      // Mengisi nilai default qty = 1 dan memindahkan kursor (fokus) ke input qty
      $("#qty").val(1).focus();
      // Memperbarui nilai subtotal preview berdasarkan data yang baru masuk
      updateSubtotalPreview();
      $("#subtotal_preview").val("");
    }

    // Fungsi utama untuk menghitung ulang semua rincian harga pada tabel keranjang belanja.
    // Alur keseluruhan: Menghitung subtotal tiap baris -> Menjumlahkan total -> Mengurangi diskon -> Menentukan grandtotal -> Menghitung uang kembalian.
    function hitungtotal() {
      let total = 0;

      // Melakukan iterasi (perulangan) pada setiap baris item yang ada di tabel keranjang
      $("#tbldata tbody tr").each(function () {
        let row = $(this);
        
        // Mengambil nilai dari kolom-kolom terkait di baris saat ini
        let harga = parseFloat(row.find(".harga").text()) || 0;
        let qty = parseInt(row.find(".qty").text()) || 1;
        let tipe = row.find(".tipe").text() || "";
        let tambahan = 0;
        
        // Menentukan tambahan harga berdasarkan tipe/ukuran
        if (tipe != "") {
          if (tipe === "S") {
            tambahan = 1000;
          } else if (tipe === "M") {
            tambahan = 2000;
          } else if (tipe === "L") {
            tambahan = 3000;
          } else if (tipe === "XL") {
            tambahan = 4000;
          }
        } else {
          tambahan = 0;
        }
        // Menghitung subtotal per baris: (harga dasar + biaya tambahan) dikali jumlah barang
        let subtotal = (harga + tambahan) * qty;
        
        // Menampilkan subtotal ke kolom subtotal di baris tersebut
        $(this).find(".subtotal").text("Rp " + subtotal);
        
        // Menambahkan subtotal baris ke total akumulasi seluruh belanjaan
        total += subtotal;
        console.log(total);
      });

      // Menampilkan total keseluruhan (sebelum diskon) ke tampilan
      $("#tot").html("<b>" + total + "</b>");

      // --- Alur Diskon ---
      // Menghitung potongan harga berdasarkan persentase yang dimasukkan pengguna
      let persen = parseFloat($("#diskon_persen").val()) || 0;
      let nominal = Math.round(total * persen / 100); // Nominal potongan dalam Rupiah
      $("#diskon_nominal").text(nominal);

      // --- Alur Grandtotal ---
      // Menghitung harga akhir setelah dikurangi nominal diskon
      let grandtotal = total - nominal;
      // Memastikan agar grandtotal tidak minus jika diskon terlalu besar
      if (grandtotal < 0) grandtotal = 0;
      $("#grandtotal").text(grandtotal);

      // --- Alur Kembalian ---
      // Menghitung uang kembali jika nominal bayar lebih besar atau sama dengan grandtotal
      let bayar = parseFloat($("#bayar").val()) || 0;
      let kembali = bayar >= grandtotal ? bayar - grandtotal : 0;
      $("#kembali").text(kembali);
    }

    // Fungsi untuk memproyeksikan (preview) subtotal pada form input sebelum item ditambahkan ke keranjang.
    // Alur: Mengambil input harga, qty, dan tipe dari form -> Menghitung tambahan biaya -> Menampilkan kalkulasi di kotak subtotal.
    function updateSubtotalPreview() {
      // Mengambil data inputan sementara dari form (bukan tabel)
      let harga = parseFloat($("#harga").val()) || 0;
      let qty = parseInt($("#qty").val()) || 0;
      let tipe = $("#tipe").val().trim();
      let tambahan = 0;
      
      // Menentukan biaya tambahan sesuai tipe/ukuran
      if (tipe != "") {
        if (tipe === "S") {
          tambahan = 1000;
        } else if (tipe === "M") {
          tambahan = 2000;
        } else if (tipe === "L") {
          tambahan = 3000;
        } else if (tipe === "XL") {
          tambahan = 4000;
        }
      } else {
        tambahan = 0;
      }
      
      // Menampilkan hasil kalkulasi pratinjau ke field subtotal, jika qty valid (>0)
      $("#subtotal_preview").val(qty > 0 ? (harga + tambahan) * qty : "");
    }

    // Blok kode utama yang dijalankan saat struktur HTML dokumen selesai dimuat (DOM Ready)
    // Berisi pendaftaran event listener (pemantau aksi pengguna)
    $(document).ready(function () {

      // Event listener: Memperbarui nilai subtotal preview secara langsung saat nilai input qty diketik / diubah
      $("#qty").on("input", function () {
        updateSubtotalPreview();
      });

      // Event listener: Memperbarui nilai subtotal preview saat pengguna memilih opsi tipe yang berbeda
      $("#tipe").on("change", function () {
        updateSubtotalPreview();
      });

      // Event listener: Aksi utama ketika tombol "tambah" diklik.
      // Alur: Ambil semua data dari form input -> Validasi kelengkapan data -> Buat elemen HTML baris (<tr>) baru -> Sisipkan ke tabel -> Hitung ulang keranjang -> Reset form input.
      $("#tambah").click(function () {
        let x = $("#kode").val().trim();
        let y = $("#nama").val().trim();
        let s = $("#satuan").val().trim();
        let z = parseFloat($("#harga").val()) || 0;
        let q = parseInt($("#qty").val()) || 0;
        let t = $("#tipe").val().trim();
        let tambahan = 0;
        if (t != "") {
          if (t === "S") {
            tambahan = 1000;
          } else if (t === "M") {
            tambahan = 2000;
          } else if (t === "L") {
            tambahan = 3000;
          } else if (t === "XL") {
            tambahan = 4000;
          }
        } else {
          tambahan = 0;
        }

        // Validasi data: Mencegah item ditambahkan jika ada informasi krusial yang kosong
        if (x === "") { alert("Pilih item dulu!"); return; } // Item belum dipilih dari master item
        if (q <= 0) { alert("Isi Qty terlebih dahulu!"); return; } // Jumlah harus lebih besar dari 0
        if (t === "") { alert("Pilih tipe terlebih dahulu!"); return; } // Tipe wajib dipilih

        // Menghitung subtotal riil untuk baris yang akan ditambahkan ke tabel
        let subtotal = (z + tambahan) * q;

        // Membuat struktur elemen baris tabel (HTML) baru yang berisi data input dengan template literal
        let tbltr = `<tr>
          <td><button class="btn btn-danger hapus">X</button></td>
          <td>${x}</td>
          <td>${y}</td>
          <td>${s}</td>
          <td class="harga">${z}</td>
          <td class="tipe">${t}</td>
          <td class="qty">${q}</td>
          <td class="subtotal">Rp ${subtotal}</td>
        </tr>`;

        // Menyisipkan baris HTML baru tersebut ke bagian bawah tabel daftar keranjang (tbody)
        $("#tbldata tbody").append(tbltr);
        
        // Memanggil fungsi hitung total untuk memperbarui semua nominal transaksi (termasuk grandtotal)
        hitungtotal();

        // Reset: Mengosongkan form input persiapan agar siap untuk menambah item selanjutnya
        $("#kode, #nama, #satuan, #harga, #tipe, #qty, #subtotal_preview").val("");
      });

      // Event listener: Aksi untuk tombol "X" (hapus baris) pada item di tabel keranjang.
      // Dicatat pada elemen tabel induk ("#tbldata") karena tombol ".hapus" ditambahkan secara dinamis.
      // Alur: Mengidentifikasi tombol mana yang diklik -> Mencari baris <tr> pembungkus terdekat -> Menghapus elemen baris tersebut dari HTML -> Hitung ulang total.
      $("#tbldata").on("click", ".hapus", function () {
        $(this).closest('tr').remove();
        hitungtotal(); // Penting: karena ada baris yang dihapus, total harus dihitung ulang
      });

      // Event listener: Memperbarui hitungan total dan kembalian seketika pengguna mengubah nilai persen diskon
      $("#diskon_persen").on("input", function () {
        hitungtotal();
      });

      // Event listener: Memperbarui nilai kembalian seketika pengguna mengetikkan/mengubah nominal uang pembayaran
      $("#bayar").on("input", function () {
        hitungtotal();
      });

    });
  </script>

