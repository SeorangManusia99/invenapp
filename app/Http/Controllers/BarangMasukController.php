<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Pemasok;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class BarangMasukController extends Controller
{
    /**
     * Menampilkan halaman utama (index) untuk Barang Masuk.
     */
    public function index()
    {
        return view('barang-masuk.index');
    }

    /**
     * Menampilkan form untuk membuat data barang masuk baru.
     */
    public function create()
    {
        // Mengambil data pemasok dan karyawan untuk dropdown
        // UBAH BARIS INI
        $pemasok = Pemasok::orderBy('nama_pemasok', 'asc')->get(); 
        $karyawan = User::orderBy('name', 'asc')->get();

        return view('barang-masuk.create', compact('pemasok', 'karyawan'));
    }

    /**
     * Menyimpan data barang masuk baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk' => 'required|date',
            'sumber_dana' => 'required|string|max:200',
            'pemasok_id' => 'required|exists:pemasok,id',
            'karyawan_id' => 'required|exists:users,id',
        ]);

        BarangMasuk::create($request->all());

        return redirect()->route('barang-masuk.index')
                         ->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data barang masuk.
     */

     
     public function edit($id)
    {
        $barang_masuk = BarangMasuk::findOrFail($id);
        // UBAH BARIS INI JUGA
        $pemasok = Pemasok::orderBy('nama_pemasok', 'asc')->get();
        $karyawan = User::orderBy('name', 'asc')->get();

        return view('barang-masuk.edit', compact('barang_masuk', 'pemasok', 'karyawan'));
    }
    /**
     * Memperbarui data barang masuk di dalam database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_masuk' => 'required|date',
            'sumber_dana' => 'required|string|max:200',
            'pemasok_id' => 'required|exists:pemasok,id',
            'karyawan_id' => 'required|exists:users,id',
        ]);

        $barang_masuk = BarangMasuk::findOrFail($id);
        $barang_masuk->update($request->all());

        return redirect()->route('barang-masuk.index')
                         ->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    /**
     * Menghapus data barang masuk dari database.
     */
    public function destroy($id)
    {
        $barang_masuk = BarangMasuk::findOrFail($id);
        $barang_masuk->delete();

        return redirect()->route('barang-masuk.index')
                         ->with('success', 'Data barang masuk berhasil dihapus.');
    }

    /**
     * Menyediakan data untuk DataTables dengan penanganan error.
     */
    public function getBarangMasuk(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangMasuk::with('pemasok', 'karyawan')->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('pemasok_nama', function($row){
                    return $row->pemasok ? $row->pemasok->nama : '-';
                })
                ->addColumn('karyawan_nama', function($row){
                    return $row->karyawan ? $row->karyawan->name : '-';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('barang-masuk.edit', $row->id);
                    $deleteForm = '
                        <form action="'.route('barang-masuk.destroy', $row->id).'" method="POST" class="d-inline">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>
                        </form>';
                    
                    $actionBtn = '<a href="'.$editUrl.'" class="btn btn-success btn-sm mr-2">Edit</a>' . $deleteForm;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
