$(document).ready(function() {
    
    // Variabel global untuk menyimpan harga produk saat modal dibuka
    let currentProductPrice = 0;

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
