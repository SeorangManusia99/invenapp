<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'barang_masuk';

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'tgl_masuk',
        'sumber_dana',
        'pemasok_id',
        'karyawan_id',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Pemasok.
     * Ini memberitahu Laravel bahwa setiap BarangMasuk dimiliki oleh satu Pemasok.
     */
    public function pemasok()
    {
        // 'pemasok_id' adalah foreign key di tabel 'barang_masuk'
        return $this->belongsTo(Pemasok::class, 'pemasok_id');
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model User (sebagai karyawan).
     * Ini memberitahu Laravel bahwa setiap BarangMasuk dicatat oleh satu Karyawan.
     */
    public function karyawan()
    {
        // 'karyawan_id' adalah foreign key di tabel 'barang_masuk'
        return $this->belongsTo(User::class, 'karyawan_id');
    }
}
