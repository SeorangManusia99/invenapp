<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    use HasFactory;

    protected $fillable = ['barang_masuk_detail_id', 'kode', 'kondisi_barang'];

    public function barangMasukDetail()
    {
        return $this->belongsTo(BarangMasukDetail::class);
    }

    public function inventarisRuang()
    {
        return $this->hasMany(InventarisRuang::class);
    }

}
