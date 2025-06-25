<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pemasok', 'nama_kontak', 'nomor_hp', 'alamat'];

    public function barangMasuk()
    {
        return $this->hasOne(BarangMasuk::class, 'pemasok_id', 'id');
    }
}
