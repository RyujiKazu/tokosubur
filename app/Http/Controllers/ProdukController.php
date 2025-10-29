<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Tampilkan halaman Tambah Produk + tabel produk yang sudah ada.
     * (mirip pola create() di PencatatanPesananController)
     */
    public function create()
    {
        $products = Produk::orderBy('created_at', 'desc')->get();
        return view('TambahProduk', compact('products'));
    }

    /**
     * Simpan banyak produk sekaligus (bulk add).
     * Struktur input mengikuti form: products[0][nama_product], products[0][harga_product], dst.
     */
    public function store(Request $request)
    {
        // Validasi mirip pola di contoh pencatatan (array, min item, dll)
        $validator = Validator::make($request->all(), [
            'products'                         => 'required|array|min:1',
            'products.*.nama_product'          => 'required|string|max:120',
            'products.*.harga_product'         => 'required|numeric|min:0',
        ], [
            'products.required'                => 'Minimal tambahkan 1 produk.',
            'products.*.nama_product.required' => 'Nama produk wajib diisi.',
            'products.*.harga_product.required'=> 'Harga produk wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $rows = $request->input('products', []);

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                // Trim dan normalisasi sederhana
                $nama  = trim($row['nama_product']);
                $harga = (float) $row['harga_product'];

                // Lewati jika baris kosong (jaga-jaga)
                if ($nama === '' || $harga < 0) {
                    continue;
                }

                Produk::create([
                    'nama_product'  => $nama,
                    'harga_product' => $harga,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan produk: '.$e->getMessage())->withInput();
        }
    }
}
