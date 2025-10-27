<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PengolahanPesananController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi (READ).
     */
    public function index()
    {
        // Ambil data transaksi, gabung (JOIN) dengan tabel produk
        // untuk mendapatkan nama produk. Urutkan dari yang terbaru.
        $transaksis = Transaksi::join('produk', 'transaksi.id_product', '=', 'produk.id_product')
                        ->select('transaksi.*', 'produk.nama_product', 'produk.harga_product')
                        ->orderBy('transaksi.tanggal', 'desc')
                        ->get();

        // Tampilkan view dan kirim data $transaksis
        return view('pengolahanPesanan', compact('transaksis'));
    }

    /**
     * Mengupdate data transaksi (UPDATE).
     */
    public function update(Request $request, $no_transaksi)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'required|integer|min:0', // Validasi input 'qty'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Cari transaksi berdasarkan no_transaksi
            $transaksi = Transaksi::where('no_transaksi', $no_transaksi)->firstOrFail();
            
            // Dapatkan harga produk
            $produk = Produk::find($transaksi->id_product);
            if (!$produk) {
                throw new \Exception('Produk terkait tidak ditemukan.');
            }

            $newQty = (int)$request->input('qty');
            $newTotal = $produk->harga_product * $newQty;

            // Update transaksi
            $transaksi->qty = $newQty;
            $transaksi->total = $newTotal;
            $transaksi->save();

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi ' . $no_transaksi . ' berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data transaksi (DELETE).
     */
    public function destroy($no_transaksi)
    {
        try {
            // Cari dan hapus transaksi
            $transaksi = Transaksi::where('no_transaksi', $no_transaksi)->firstOrFail();
            $transaksi->delete();

            return redirect()->back()->with('success', 'Transaksi ' . $no_transaksi . ' berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
