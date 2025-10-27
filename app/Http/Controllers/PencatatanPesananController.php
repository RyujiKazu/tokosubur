<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator; // <-- TAMBAHKAN USE INI

class PencatatanPesananController extends Controller
{
    /**
     * Menampilkan halaman form pencatatan pesanan.
     */
    public function create()
    {
        // Ambil semua produk dari database
        $products = Produk::orderBy('nama_product', 'asc')->get();
        
        // Tampilkan view dan kirim data products
        return view('pencatatanPesanan', compact('products'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     * Logika diperbarui untuk menangani produk baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'products' => 'required|array|min:1',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.id' => 'required_without_all:products.*.new_name,products.*.new_price|nullable|exists:produk,id_product',
            'products.*.new_name' => 'required_without:products.*.id|nullable|string|max:120',
            'products.*.new_price' => 'required_with:products.*.new_name|nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $items = $request->input('products');
        $waktuSekarang = Carbon::now();
        // $baseTransaksiId = 'TRX-' . $waktuSekarang->timestamp; // Format lama (Unix Timestamp)
        
        // [PERUBAHAN] Menggunakan format HHIISS (JamMenitDetik)
        $baseTransaksiId = 'TRX-' . $waktuSekarang->format('His');

        DB::beginTransaction();
        try {
            $itemCounter = 1;
            foreach ($items as $item) {
                
                $product = null;
                $qty = (int)$item['qty'];

                if ($qty <= 0) {
                    continue;
                }

                // Cek apakah ini produk baru atau produk lama
                if (!empty($item['new_name']) && !empty($item['new_price'])) {
                    // Ini produk BARU. Buat di database.
                    $product = Produk::create([
                        'nama_product' => $item['new_name'],
                        'harga_product' => (float)$item['new_price']
                    ]);

                } else if (!empty($item['id'])) {
                    // Ini produk LAMA. Cari di database.
                    $product = Produk::find($item['id']);
                }

                // Jika produk valid (ditemukan atau berhasil dibuat)
                if ($product) {
                    $totalItem = $product->harga_product * $qty;

                    // Buat data transaksi baru
                    Transaksi::create([
                        'no_transaksi' => $baseTransaksiId . '-' . $itemCounter, 
                        'id_product' => $product->id_product,
                        'qty' => $qty,
                        'total' => $totalItem,
                        'tanggal' => $waktuSekarang
                    ]);

                    $itemCounter++;
                }
            }

            DB::commit();
            return redirect('/PengolahanPesanan')->with('success', 'Pesanan berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                        ->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage())
                        ->withInput();
        }
    }
}

