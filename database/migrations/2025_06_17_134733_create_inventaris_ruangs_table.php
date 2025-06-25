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
        Schema::create('inventaris_ruang', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ruang_id')->unsigned();
            $table->bigInteger('kode_id')->unsigned();
            $table->timestamps();

            $table->foreign('ruang_id')->references('id')->on('ruang')->onDelete('cascade');
            $table->foreign('kode_id')->references('id')->on('kode')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_ruang');
    }
};
