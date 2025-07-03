<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class KaryawanController extends Controller
{
    /**
     * Menampilkan halaman utama (index) untuk Karyawan.
     */
    public function index()
    {
        return view('karyawan.index');
    }

    /**
     * Menampilkan form untuk membuat data karyawan baru.
     */
    public function create()
    {
        // Mengambil hanya user yang belum terdaftar sebagai karyawan
        $users = User::whereDoesntHave('karyawan')->get();
        return view('karyawan.create', compact('users'));
    }

    /**
     * Menyimpan data karyawan baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:karyawan,user_id',
            'nomor_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')
                         ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data karyawan.
     */
    public function edit($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Memperbarui data karyawan di dalam database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($request->only(['nomor_hp', 'alamat']));

        return redirect()->route('karyawan.index')
                         ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus data karyawan dari database.
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')
                         ->with('success', 'Data karyawan berhasil dihapus.');
    }

    /**
     * Menyediakan data untuk DataTables.
     */
    public function getKaryawan(Request $request)
    {
        if ($request->ajax()) {
            $data = Karyawan::with('user')->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_user', function($row){
                    return $row->user ? $row->user->name : 'N/A';
                })
                ->addColumn('email_user', function($row){
                    return $row->user ? $row->user->email : 'N/A';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('karyawan.edit', $row->id);
                    $deleteForm = '
                        <form action="'.route('karyawan.destroy', $row->id).'" method="POST" class="d-inline">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>
                        </form>';
                    $actionBtn = '<a href="'.$editUrl.'" class="btn btn-success btn-sm mr-2">Edit</a>' . $deleteForm;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
