<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukDetail extends Model
{
    use HasFactory;

    protected $fillable = ['barang_masuk_id', 'barang_id', 'jumlah', 'status_kode'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class);
    }

    public function kode()
    {
        return $this->hasMany(Kode::class);
    }
}
