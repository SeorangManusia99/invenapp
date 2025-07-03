<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel secara eksplisit.
     * Ini wajib ada jika nama tabel Anda 'pemasok' (singular).
     *
     * @var string
     */
    protected $table = 'pemasok';

    /**
     * Atribut yang bisa diisi.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pemasok',
        'alamat',
        'telepon',
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model BarangMasuk.
     * Satu pemasok bisa memiliki banyak transaksi barang masuk.
     */
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'pemasok_id');
    }
}
