<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel produk
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id_product');
            $table->string('nama_product', 120);
            $table->decimal('harga_product', 12, 2)->default(0);
            // kalau mau tanpa timestamps, hapus baris di bawah ini
            $table->timestamps();
        });

        // Tabel transaksi (hanya catatan penjualan)
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('no_transaksi', 30)->primary();
            $table->unsignedBigInteger('id_product');      // FK ke produk.id_product
            $table->decimal('qty', 10, 2);
            $table->decimal('total', 12, 2);
            $table->dateTime('tanggal');

            // Relasi
            $table->foreign('id_product')
                  ->references('id_product')->on('produk')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete(); // cegah hapus produk yang masih dipakai transaksi

            // Index yang berguna
            $table->index('tanggal');
            $table->index('id_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop child dulu baru parent
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('produk');
    }
};
