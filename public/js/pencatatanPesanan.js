$(document).ready(function() {
    
    // Ambil data produk dari Blade (via window object)
    const ALL_PRODUCTS = window.PRODUCT_DATA || [];
    
    // --- ELEMEN UTAMA ---
    const orderForm = $('#orderForm');
    const productListContainer = $('#product-order-list');
    const addProductButton = $('#add-product-row');
    const totalHargaEl = $('#total-harga');

    // --- ELEMEN MODAL ---
    const modal = $('#confirmationModal');
    const modalTitle = $('#modalTitleId');
    const modalBody = $('#modalBodyId');
    const confirmButton = $('#confirmSubmitButton');

    // --- FUNGSI FORMAT RUPIAH ---
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    // --- FUNGSI MEMBUAT BARIS PRODUK BARU ---
    function createNewProductRow() {
        const rowIndex = productListContainer.children('.product-row').length;

        // Buat opsi dropdown dari data produk
        let productOptions = '<option value="">-- Pilih Produk --</option>';
        ALL_PRODUCTS.forEach(product => {
            productOptions += `<option value="${product.id_product}" data-harga="${product.harga_product}">${product.nama_product}</option>`;
        });

        // Template HTML untuk baris baru
        const newRowHtml = `
            <div class="row product-row mb-3 p-3 border rounded" data-index="${rowIndex}">

                <!-- Grup 1: Dropdown Produk (Default) -->
                <div class="col-md-6 existing-product-group">
                    <label>Pilih Produk</label>
                    <select name="products[${rowIndex}][id]" class="form-control product-select">
                        ${productOptions}
                    </select>
                </div>

                <!-- Grup 3: Kuantitas (Selalu Ada) -->
                <div class="col-md-2">
                    <label>Kuantitas</label>
                    <input type="number" name="products[${rowIndex}][qty]" class="form-control product-quantity" min="1" value="1">
                </div>
                
                <!-- Grup 4: Tombol Hapus (Selalu Ada) -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-product-row">Hapus</button>
                </div>
            </div>
        `;

        productListContainer.append(newRowHtml);
    }

    // --- FUNGSI MENGHITUNG TOTAL HARGA ---
    function hitungTotal() {
        let grandTotal = 0;

        productListContainer.children('.product-row').each(function() {
            const row = $(this);
            const qty = parseInt(row.find('.product-quantity').val()) || 0;
            let harga = 0;

            if (row.find('.new-product-toggle').is(':checked')) {
                // Ambil harga dari input produk baru
                harga = parseFloat(row.find('.new-product-price').val()) || 0;
            } else {
                // Ambil harga dari dropdown
                const selectedOption = row.find('.product-select option:selected');
                harga = parseFloat(selectedOption.data('harga')) || 0;
            }

            grandTotal += (harga * qty);
        });

        totalHargaEl.text(formatRupiah(grandTotal));
    }

    // --- EVENT HANDLERS ---

    // 1. Tombol "Tambah Produk" diklik
    addProductButton.on('click', createNewProductRow);

    // 2. Tombol "Hapus" baris diklik
    productListContainer.on('click', '.remove-product-row', function() {
        $(this).closest('.product-row').remove();
        hitungTotal();
    });

    // 4. Kuantitas, harga, atau pilihan produk diubah
    productListContainer.on('input change', '.product-quantity, .product-select, .new-product-price', function() {
        hitungTotal();
    });

    // 5. Form disubmit (validasi modal)
    orderForm.on('submit', function(event) {
        event.preventDefault(); 

        let itemCount = 0;
        let valid = true;
        let errorMessage = '';
        let modalContent = 'Anda akan membuat pesanan untuk:<br><br>';

        if (productListContainer.children('.product-row').length === 0) {
            valid = false;
            errorMessage = 'Anda harus memesan setidaknya 1 produk.';
        }

        productListContainer.children('.product-row').each(function() {
            const row = $(this);
            const qty = parseInt(row.find('.product-quantity').val()) || 0;
            const isNew = row.find('.new-product-toggle').is(':checked');

            if (qty > 0) {
                if (isNew) {
                    const newName = row.find('.new-product-name').val();
                    const newPrice = parseFloat(row.find('.new-product-price').val()) || 0;
                    if (!newName || newPrice <= 0) {
                        valid = false;
                        errorMessage = 'Produk baru harus memiliki Nama dan Harga yang valid.';
                    } else {
                        itemCount++;
                        modalContent += `<strong>${newName}: ${qty} pcs</strong><br>`;
                    }
                } else {
                    const productId = row.find('.product-select').val();
                    const productName = row.find('option:selected').text();
                    if (!productId) {
                        valid = false;
                        errorMessage = 'Harap pilih produk dari dropdown untuk item yang ada.';
                    } else {
                        itemCount++;
                        modalContent += `<strong>${productName}: ${qty} pcs</strong><br>`;
                    }
                }
            }
        });

        if (!valid) {
            modalTitle.text('Validasi Gagal');
            modalBody.text(errorMessage);
            confirmButton.hide();
            modal.modal('show');
        } else if (itemCount === 0) {
            modalTitle.text('Validasi Gagal');
            modalBody.text('Pesanan tidak boleh kosong. Harap tambahkan produk.');
            confirmButton.hide();
            modal.modal('show');
        } else {
            // Sukses: Tampilkan konfirmasi
            const totalHargaText = totalHargaEl.text();
            modalContent += `<br><strong>Total Harga: ${totalHargaText}</strong><br><br>Lanjutkan?`;
            
            modalTitle.text('Konfirmasi Pesanan');
            modalBody.html(modalContent);
            confirmButton.show();
            modal.modal('show');
        }
    });

    // 6. Tombol "Buat" di dalam modal diklik
    confirmButton.on('click', function() {
        orderForm.get(0).submit();
    });

    // --- INISIALISASI ---
    // Buat satu baris pertama saat halaman dimuat
    createNewProductRow();
    hitungTotal(); 
});

