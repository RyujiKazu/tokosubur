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
    $q = request('q'); // keyword pencarian no_transaksi

    $transaksis = DB::table('transaksi as t')
        ->join('produk as p', 'p.id_product', '=', 't.id_product')
        ->select('t.no_transaksi', 'p.nama_product', 't.qty', 't.total', 't.tanggal', 'p.harga_product')
        ->when($q, function ($query) use ($q) {
            $query->where('t.no_transaksi', 'like', "%{$q}%");
        })
        ->orderBy('t.tanggal', 'desc')
        ->paginate(25)
        ->withQueryString();

    // Pastikan nama view konsisten (pakai satu nama saja)
    return view('pengolahanPesanan', compact('transaksis', 'q'));
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
