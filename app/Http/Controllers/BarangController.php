<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Barang;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use App\Imports\BarangImport;

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
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::find($id);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'merk' => $request->merk,
            'tipe' => $request->tipe,
            'satuan' => $request->satuan
        ]);

        Alert::success('Success', 'Barang Berhasil Di Update');
        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::find($id);
        $barang->delete();
        Alert::success('Success', 'Barang Berhasil Di Hapus');
        return redirect()->route('barang.index');
    }

    public function cetakBarangPdf()
    {
        $barang = Barang::all();

        $pdf = Pdf::loadView('barang.laporan-barang', compact('barang'));
        return $pdf->stream();
    }

    public function exportBarang()
    {
        return Excel::download(new BarangExport, 'barang.xlsx');
    }

    public function importBarang(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        Excel::import(new BarangImport, request()->file('file'));

        Alert::success('Success', 'Barang Berhasil Di Import');
        return redirect()->route('barang.index');
    }
}
