<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nomor_hp', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barangMasuk()
    {
        return $this->hasOne(BarangMasuk::class);
    }


}
