<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisRuang extends Model
{
    use HasFactory;

    protected $fillable = ['ruang_id', 'kode_id'];

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function kode()
    {
        return $this->belongsTo(Kode::class);
    }
}
