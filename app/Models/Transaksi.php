<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'transaksi';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'no_transaksi';

    /**
     * Menandakan apakah primary key auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Tipe data dari primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Menandakan apakah model memiliki timestamps.
     *
     * @var bool
     */
    public $timestamps = false; // Sesuai migrasi Anda, tidak ada timestamps

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_transaksi',
        'id_product',
        'qty',
        'total',
        'tanggal',
    ];

    /**
     * Relasi ke model Produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_product', 'id_product');
    }
}
