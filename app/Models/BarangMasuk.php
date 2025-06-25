<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'sumber_dana', 'pemasok_id', 'karyawan_id'];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function detail()
    {
        return $this->hasMany(BarangMasukDetail::class);
    }

}
