// DATA ITEM
        let items = [
            { kode: "Item1", nama: "Pensil", satuan: "PCS", harga: 2000 },
            { kode: "Item2", nama: "Buku", satuan: "PCS", harga: 5000 },
            { kode: "Item3", nama: "Penghapus", satuan: "PCS", harga: 1500 },
            { kode: "Item4", nama: "Pulpen", satuan: "PCS", harga: 3000 }
        ];

        function hitungtotal() {
            let total = 0;

            $("#tbldata tbody tr").each(function () {
                let harga    = parseFloat($(this).find(".harga").text()) || 0;
                let qty      = parseInt($(this).find(".qty").text()) || 1;
                let subtotal = harga * qty;
                $(this).find(".subtotal").text("Rp " + subtotal);
                total += subtotal;
            });

            $("#total").text("Rp " + total);

            // diskon input user (%)
            let persen     = parseFloat($("#diskon_persen").val()) || 0;
            let nominal    = Math.round(total * persen / 100);
            $("#diskon_nominal").text("Rp " + nominal);

            let grandtotal = total - nominal;
            if (grandtotal < 0) grandtotal = 0;
            $("#grandtotal").text("Rp " + grandtotal);

            let bayar    = parseFloat($("#bayar").val()) || 0;
            let kembali  = bayar >= grandtotal ? bayar - grandtotal : 0;
            $("#kembali").text("Rp " + kembali);
        }

        function updateSubtotalPreview() {
            let harga = parseFloat($("#harga").val()) || 0;
            let qty   = parseInt($("#qty").val()) || 0;
            $("#subtotal_preview").val(qty > 0 ? harga * qty : "");
        }

        $(document).ready(function () {

            // buka modal saat klik input kode
            $("#kode").on("click", function () {
                let html = "";
                items.forEach(item => {
                    html += `<tr>
                        <td>${item.kode}</td>
                        <td>${item.nama}</td>
                        <td>${item.harga}</td>
                        <td>
                            <button class="btn btn-success pilih"
                                data-kode="${item.kode}"
                                data-nama="${item.nama}"
                                data-satuan="${item.satuan}"
                                data-harga="${item.harga}">
                                Pilih
                            </button>
                        </td>
                    </tr>`;
                });
                $("#listItem").html(html);
                new bootstrap.Modal(document.getElementById('modalItem')).show();
            });

            // pilih item dari modal
            $("#listItem").on("click", ".pilih", function () {
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
            $("#tambah").on("click", function () {
                let kode    = $("#kode").val().trim();
                let nama    = $("#nama").val().trim();
                let satuan  = $("#satuan").val().trim();
                let harga   = parseFloat($("#harga").val()) || 0;
                let qty     = parseInt($("#qty").val()) || 0;

                if (kode === "") { alert("Pilih item dulu!"); return; }
                if (qty <= 0)   { alert("Isi Qty terlebih dahulu!"); return; }

                let subtotal = harga * qty;

                let row = `<tr>
                    <td><button class="btn btn-danger hapus">X</button></td>
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${satuan}</td>
                    <td class="harga">${harga}</td>
                    <td class="qty">${qty}</td>
                    <td class="subtotal">${subtotal}</td>
                </tr>`;

                $("#tbldata tbody").append(row);
                hitungtotal();

                // reset input row
                $("#kode, #nama, #satuan, #harga, #qty, #subtotal_preview").val("");
            });

            // delete row
            $("#tbldata").on("click", ".hapus", function () {
                $(this).closest("tr").remove();
                hitungtotal();
            });

            // ubah diskon %
            $("#diskon_persen").on("input", function () {
                hitungtotal();
            });

            // bayar berubah
            $("#bayar").on("input", function () {
                hitungtotal();
            });

        });