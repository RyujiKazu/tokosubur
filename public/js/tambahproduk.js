$(document).ready(function() {
    const container = $('#product-add-list');
    const addButton = $('#add-product-row');
    const form = $('#addProductForm');

    // Buat baris produk baru
    function createNewRow() {
        const rowIndex = container.children('.product-row').length;
        const newRow = `
            <div class="row product-row mb-3 p-3 border rounded" data-index="${rowIndex}">
                <div class="col-md-6">
                    <label>Nama Produk</label>
                    <input type="text" name="products[${rowIndex}][nama_product]" class="form-control" placeholder="Masukkan nama produk" required>
                </div>
                <div class="col-md-4">
                    <label>Harga Produk</label>
                    <input type="number" name="products[${rowIndex}][harga_product]" class="form-control" placeholder="Masukkan harga" min="0" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-product-row">Hapus</button>
                </div>
            </div>
        `;
        container.append(newRow);
    }

    // Tambah baris baru
    addButton.on('click', createNewRow);

    // Hapus baris
    container.on('click', '.remove-product-row', function() {
        $(this).closest('.product-row').remove();
    });

    // Tambahkan satu baris default saat pertama kali
    createNewRow();
});