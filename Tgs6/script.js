// DATA ITEM
        let items = [
            { kode: "Item1", nama: "Pensil", satuan: "PCS", harga: 2000 },
            { kode: "Item2", nama: "Buku", satuan: "PCS", harga: 5000 },
            { kode: "Item3", nama: "Penghapus", satuan: "PCS", harga: 1500 },
            { kode: "Item4", nama: "Pulpen", satuan: "PCS", harga: 3000 }
        ]; // daftar item di Modal



        function hitungtotal() { // fungsi untuk menghitung total
            let total = 0;

            $("#tbldata tbody tr").each(function () { // loop setiap baris di tabel
                let harga    = parseFloat($(this).find(".harga").text()) || 0; // ambil harga dari kolom harga
                let qty      = parseInt($(this).find(".qty").text()) || 1; // ambil qty dari kolom qty

                let subtotal = harga * qty; // hitung subtotal
                $(this).find(".subtotal").text("Rp " + subtotal);

                total += subtotal; // hitung total
            });

            $("#total").text("Rp " + total); // tampilkan total

            // diskon input user (%)
            let persen     = parseFloat($("#diskon_persen").val()) || 0; // ambil nilai diskon dari input diskon persen
            let nominal    = Math.round(total * persen / 100); 
            $("#diskon_nominal").text("Rp " + nominal); // tampilkan nominal diskon

            let grandtotal = total - nominal; // hitung grandtotal, jika negatif maka grandtotal = 0
            if (grandtotal < 0) grandtotal = 0; 
            $("#grandtotal").text("Rp " + grandtotal);

            let bayar    = parseFloat($("#bayar").val()) || 0; // ambil nilai bayar dari input bayar
            let kembali  = bayar >= grandtotal ? bayar - grandtotal : 0; // hitung kembalian
            $("#kembali").text("Rp " + kembali);
        }


        // fungsi untuk update subtotal preview
        function updateSubtotalPreview() {
            let harga = parseFloat($("#harga").val()) || 0; // ambil harga dari kolom harga
            let qty   = parseInt($("#qty").val()) || 0; // ambil qty dari kolom qty

            $("#subtotal_preview").val(qty > 0 ? harga * qty : ""); // tampilkan update subtotal preview
        }


        // EVENT HANDLER
        $(document).ready(function () {

            // buka modal saat klik input kode
            $("#kode").on("click", function () { // click input kode, modal muncul

                let html = ""; // html untuk tabel 

                items.forEach(item => { // loop setiap item
                    html += `<tr>
                        <td>${item.kode}</td>
                        <td>${item.nama}</td>
                        <td>${item.harga}</td>

                        <td>
                            <button class="btn btn-success pilih" 
                                data-kode="${item.kode}"
                                data-nama="${item.nama}"
                                data-satuan="${item.satuan}"
                                data-harga="${item.harga}"> <!-- menampilkan button Pilih, dan list items -->
                                Pilih
                            </button> 
                        </td> 

                    </tr>`; 
                });

                $("#listItem").html(html); // menampilkan list items
                new bootstrap.Modal(document.getElementById('modalItem')).show(); // menampilkan modal

            });

            // pilih item dari modal
            $("#listItem").on("click", ".pilih", function () { // klik button pilih utk menampilkan data items di input form, dan modal akan tertutup
                $("#kode").val($(this).data("kode")); 
                $("#nama").val($(this).data("nama"));
                $("#satuan").val($(this).data("satuan"));
                $("#harga").val($(this).data("harga"));
                $("#qty").val("").focus();
                $("#subtotal_preview").val("");
                $("#modalItem").modal("hide");
            });

            // update subtotal preview
            $("#qty").on("input", function () {
                updateSubtotalPreview();
            });

            // tambah ke tabel
            $("#tambah").on("click", function () { // klik button tambah utk menambahkan data item ke tabel
                let kode    = $("#kode").val().trim(); // trim untuk menghapus blank space di awal dan akhir input
                let nama    = $("#nama").val().trim();
                let satuan  = $("#satuan").val().trim();
                let harga   = parseFloat($("#harga").val()) || 0;
                let qty     = parseInt($("#qty").val()) || 0;

                if (kode === "") { alert("Pilih item dulu!"); return; } // alert saat input kode blank
                if (qty <= 0)   { alert("Isi Qty terlebih dahulu!"); return; } // alert saat input qty <= 0

                let subtotal = harga * qty;

                let row = `<tr> <!-- tambah item setelah klik button tambah -->
                    <td><button class="btn btn-danger hapus">X</button></td> 
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${satuan}</td>
                    <td class="harga">${harga}</td>
                    <td class="qty">${qty}</td>
                    <td class="subtotal">${subtotal}</td>
                </tr>`;

                $("#tbldata tbody").append(row); // append untuk menambahkan row ke tabel
                hitungtotal();

                // reset input row
                $("#kode, #nama, #satuan, #harga, #qty, #subtotal_preview").val(""); 
            });

            // delete row
            $("#tbldata").on("click", ".hapus", function () { // saat klik button hapus, maka row akan dihapus dan run fungsi hitungtotal
                $(this).closest("tr").remove(); // remove() = fungsi hapus element di tabel row terdekat dulu
                hitungtotal();
            });

            // ubah diskon %
            $("#diskon_persen").on("input", function () { // saat update diskon %, maka run fungsi hitungtotal
                hitungtotal();
            });

            // bayar berubah
            $("#bayar").on("input", function () { // saat update input bayar, maka run fungsi hitungtotal
                hitungtotal();
            });

        });