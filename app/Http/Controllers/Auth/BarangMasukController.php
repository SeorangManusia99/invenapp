<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Pemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    /**
     * Menampilkan halaman daftar transaksi Barang Masuk.
     */
    public function index()
    {
        return view('barang_masuk.index');
    }

    /**
     * Mengambil data untuk ditampilkan di DataTables.
     */
    public function getBarangMasuk(Request $request)
    {
        if ($request->ajax()) {
            $data = BarangMasuk::with(['pemasok', 'user'])->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tgl_masuk', function ($row) {
                    return Carbon::parse($row->tgl_masuk)->translatedFormat('d F Y');
                })
                ->editColumn('pemasok.nama_pemasok', fn($row) => $row->pemasok->nama_pemasok ?? 'N/A')
                ->editColumn('user.name', fn($row) => $row->user->name ?? 'N/A')
                ->addColumn('action', function ($row) {
                    $showUrl = route('barang-masuk.show', $row->id);
                    $editUrl = route('barang-masuk.edit', $row->id);
                    $deleteUrl = route('barang-masuk.destroy', $row->id);
                    
                    return '
                        <a href="'. $showUrl .'" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Detail</a>
                        <a href="'. $editUrl .'" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <form action="'. $deleteUrl .'" method="POST" class="d-inline">
                            '. csrf_field() .'
                            '. method_field('DELETE') .'
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin mau dihapus? Menghapus transaksi ini akan mengembalikan stok barang seperti semula.\');"><i class="fa fa-trash"></i> Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create()
    {
        $pemasok = Pemasok::orderBy('nama_pemasok')->pluck('nama_pemasok', 'id');
        $barang = Barang::orderBy('nama_barang')->get(['id', 'nama_barang', 'stok']);
        $kode_masuk = 'BM-' . date('Ymd') . '-' . (BarangMasuk::count() + 1);

        return view('barang_masuk.create', compact('pemasok', 'barang', 'kode_masuk'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk' => 'required|date_format:d/m/Y',
            'pemasok_id' => 'required|exists:pemasoks,id',
            'kode_masuk' => 'required|unique:barang_masuks,kode_masuk',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:barangs,id',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.harga' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $barangMasuk = BarangMasuk::create([
                'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d'),
                'kode_masuk' => $request->kode_masuk,
                'pemasok_id' => $request->pemasok_id,
                'user_id' => auth()->id(),
            ]);

            foreach ($request->details as $detail) {
                $barangMasuk->details()->create($detail);
                Barang::find($detail['barang_id'])->increment('stok', $detail['jumlah']);
            }

            DB::commit();
            Alert::success('Success', 'Transaksi Barang Masuk Berhasil Disimpan');
            return redirect()->route('barang-masuk.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        return view('barang_masuk.show', compact('barangMasuk'));
    }

    /**
     * Menampilkan form untuk mengedit transaksi.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load('details.barang');
        $pemasok = Pemasok::orderBy('nama_pemasok')->pluck('nama_pemasok', 'id');
        $barang = Barang::orderBy('nama_barang')->get(['id', 'nama_barang', 'stok']);

        return view('barang_masuk.edit', compact('barangMasuk', 'pemasok', 'barang'));
    }

    /**
     * Memperbarui transaksi di database.
     */
    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $request->validate([
            'tgl_masuk' => 'required|date_format:d/m/Y',
            'pemasok_id' => 'required|exists:pemasoks,id',
            'details' => 'required|array|min:1',
            'details.*.barang_id' => 'required|exists:barangs,id',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.harga' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1. Kembalikan stok lama
            foreach ($barangMasuk->details as $originalDetail) {
                Barang::find($originalDetail->barang_id)->decrement('stok', $originalDetail->jumlah);
            }

            // 2. Update master data & hapus detail lama
            $barangMasuk->update([
                'tgl_masuk' => Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format('Y-m-d'),
                'pemasok_id' => $request->pemasok_id,
            ]);
            $barangMasuk->details()->delete();

            // 3. Buat detail baru & tambahkan stok baru
            foreach ($request->details as $detail) {
                $barangMasuk->details()->create($detail);
                Barang::find($detail['barang_id'])->increment('stok', $detail['jumlah']);
            }

            DB::commit();
            Alert::success('Success', 'Transaksi Berhasil Diperbarui');
            return redirect()->route('barang-masuk.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Menghapus transaksi dari database.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok barang sebelum menghapus
            foreach ($barangMasuk->details as $detail) {
                Barang::find($detail->barang_id)->decrement('stok', $detail->jumlah);
            }
            $barangMasuk->delete(); // Otomatis hapus detail karena cascadeOnDelete

            DB::commit();
            Alert::success('Success', 'Transaksi Berhasil Dihapus');
            return redirect()->route('barang-masuk.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal menghapus transaksi: ' . $e->getMessage());
            return back();
        }
    }
}