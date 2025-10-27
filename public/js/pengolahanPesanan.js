$(document).ready(function() {
    const HARGA_GALON = 7000;
    const HARGA_GAS = 20000;

    const detailModal = $('#detailModal');
    const deleteModal = $('#deleteModal');
    
    const detailForm = $('#detailForm');
    const detailLabel = $('#detailModalLabel');
    const detailGalonInput = $('#detailJumlahGalon');
    const detailGasInput = $('#detailJumlahGas');
    const detailTotalHargaEl = $('#detailTotalHarga');

    const deleteForm = $('#deleteForm');
    const deleteModalText = $('#deleteModalText');

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function hitungTotalModal() {
        const jumlahGalon = parseInt(detailGalonInput.val()) || 0;
        const jumlahGas = parseInt(detailGasInput.val()) || 0;
        const total = (jumlahGalon * HARGA_GALON) + (jumlahGas * HARGA_GAS);
        
        detailTotalHargaEl.text(formatRupiah(total));
    }

    $('#dataTable tbody').on('click', '.button-detail', function(event) {
        event.preventDefault(); 

        const transactionId = $(this).data('id');
        const galon = $(this).data('galon');
        const gas = $(this).data('gas');

        const updateUrl = "/pesanan/" + transactionId; 
        detailForm.attr('action', updateUrl);

        detailLabel.text('Detail Transaksi: ' + transactionId);

        detailGalonInput.val(galon);
        detailGasInput.val(gas);

        hitungTotalModal();

        detailModal.modal('show');
    });

    detailGalonInput.on('input', hitungTotalModal);
    detailGasInput.on('input', hitungTotalModal);

    $('#dataTable tbody').on('click', '.button-delete', function(event) {
        event.preventDefault(); 

        const transactionId = $(this).data('id');

        const deleteUrl = "/pesanan/" + transactionId;
        deleteForm.attr('action', deleteUrl);

        deleteModalText.text('Apakah Anda yakin ingin menghapus transaksi ' + transactionId + '?');

        deleteModal.modal('show');
    });

});
