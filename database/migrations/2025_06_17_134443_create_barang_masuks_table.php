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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_masuk');
            $table->string('sumber_dana');
            $table->bigInteger('pemasok_id')->unsigned();
            $table->bigInteger('karyawan_id')->unsigned();
            $table->timestamps();

            $table->foreign('pemasok_id')->references('id')->on('pemasok');
            $table->foreign('karyawan_id')->references('id')->on('karyawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
