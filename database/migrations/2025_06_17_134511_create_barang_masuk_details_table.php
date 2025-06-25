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
        Schema::create('barang_masuk_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barang_masuk_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->integer('jumlah');
            $table->enum('status_kode', ['sudah', 'belum'])->default('belum');
            $table->timestamps();

            $table->foreign('barang_masuk_id')->references('id')->on('barang_masuk')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_detail');
    }
};
