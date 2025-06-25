<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Barang;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index');
    }

    public function getBarang(Request $request)
    {
        if($request->ajax()) {
            $barang = Barang::all();
            return DataTables::of($barang)
                ->addIndexColumn()
                ->editColumn('action', function($barang) {
                    return view('partials._action', [
                        'model' => $barang,
                        'form_url' => route('barang.destroy', $barang->id),
                        'edit_url' => route('barang.edit', $barang->id)
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'merk' => 'required',
            'tipe' => 'required',
            'satuan' => 'required',
        ]);

        $barang = Barang::create($request->all());

        Alert::success('Success', 'Barang Berhasil Di Tambahkan');
        return redirect()->route('barang.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Alert::success('Success', 'User Berhasil Di Update');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('Success', 'User Berhasil Di Hapus');
        return redirect()->route('users.index');
    }
}
