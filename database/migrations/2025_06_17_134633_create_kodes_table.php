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
        Schema::create('kode', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('barang_masuk_detail_id')->unsigned();
            $table->string('kode');
            $table->enum('kondisi_barang', ['baik', 'rusak', 'hilang']);
            $table->timestamps();

            $table->foreign('barang_masuk_detail_id')->references('id')->on('barang_masuk_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode');
    }
};
