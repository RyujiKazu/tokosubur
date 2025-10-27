$(document).ready(function() {
    
    // Variabel global untuk menyimpan harga produk saat modal dibuka
    let currentProductPrice = 0;

    // --- ELEMEN MODAL DETAIL ---
    const detailModal = $('#detailModal');
    const detailForm = $('#detailForm');
    const detailLabel = $('#detailModalLabel');
    const detailNamaProdukInput = $('#detailNamaProduk');
    const detailQtyInput = $('#detailJumlahProduk');
    const detailTotalHargaEl = $('#detailTotalHarga');

    // --- ELEMEN MODAL DELETE ---
    const deleteModal = $('#deleteModal');
    const deleteForm = $('#deleteForm');
    const deleteModalText = $('#deleteModalText');

    // --- FUNGSI ---
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function hitungTotalModal() {
        // Ambil Qty dari input modal
        const jumlahProduk = parseInt(detailQtyInput.val()) || 0;
        
        // Hitung total baru menggunakan harga yang disimpan
        const total = (jumlahProduk * currentProductPrice);
        
        detailTotalHargaEl.text(formatRupiah(total));
    }

    // --- EVENT HANDLER: Klik Tombol Detail ---
    $('#dataTable tbody').on('click', '.button-detail', function(event) {
        event.preventDefault(); 

        // Ambil data dari tombol yang diklik
        const transactionId = $(this).data('id');
        const namaProduk = $(this).data('nama-produk');
        const qty = $(this).data('qty');
        const hargaProduk = $(this).data('harga-produk');

        // Simpan harga produk di variabel global
        currentProductPrice = parseFloat(hargaProduk) || 0;

        // Set URL action untuk form update
        const updateUrl = "/pesanan/" + transactionId; 
        detailForm.attr('action', updateUrl);

        // Isi field-field di dalam modal
        detailLabel.text('Detail Transaksi: ' + transactionId);
        detailNamaProdukInput.val(namaProduk);
        detailQtyInput.val(qty);

        // Hitung total harga awal
        hitungTotalModal();

        // Tampilkan modal
        detailModal.modal('show');
    });

    // --- EVENT HANDLER: Input Qty di Modal Detail ---
    detailQtyInput.on('input', hitungTotalModal);


    // --- EVENT HANDLER: Klik Tombol Delete ---
    $('#dataTable tbody').on('click', '.button-delete', function(event) {
        event.preventDefault(); 

        const transactionId = $(this).data('id');

        // Set URL action untuk form delete
        const deleteUrl = "/pesanan/" + transactionId;
        deleteForm.attr('action', deleteUrl);

        // Set teks konfirmasi
        deleteModalText.text('Apakah Anda yakin ingin menghapus transaksi ' + transactionId + '?');

        // Tampilkan modal
        deleteModal.modal('show');
    });

});
