<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException; 

class ProdukController extends Controller
{
    public function create()
    {
        $products = Produk::all();
        return view('TambahProduk', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products'                      => 'required|array|min:1',
            'products.*.nama_product'       => 'required|string|max:120',
            'products.*.harga_product'      => 'required|numeric|min:0',
        ], [
            'products.required'                 => 'Minimal tambahkan 1 produk.',
            'products.*.nama_product.required'  => 'Nama produk wajib diisi.',
            'products.*.harga_product.required' => 'Harga produk wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $rows = $request->input('products', []);

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $nama  = trim($row['nama_product']);
                $harga = (float) $row['harga_product'];

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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_product'  => 'required|string|max:120',
            'harga_product' => 'required|numeric|min:0',
        ], [
            'nama_product.required'  => 'Nama produk wajib diisi.',
            'harga_product.required' => 'Harga produk wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'edit_error')->withInput()->with('error_modal_id', $id);
        }

        try {
            $product = Produk::findOrFail($id);
            $product->update([
                'nama_product'  => $request->nama_product,
                'harga_product' => $request->harga_product,
            ]);

            return back()->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui produk: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Produk::findOrFail($id);
            $product->delete();

            return back()->with('success', 'Produk berhasil dihapus.');
        } catch (QueryException $e) {
            if ($e->getCode() == "23000" || $e->getCode() == 1451) {
                return back()->with('error', 'Gagal menghapus! Produk ini sudah digunakan di data transaksi.');
            }
            return back()->with('error', 'Gagal menghapus produk: '.$e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus produk: '.$e->getMessage());
        }
    }
}