@extends('adminlte::page')

@section('title', 'Tambah Barang Masuk')

@section('content_header')
    <h1 class="m-0 text-dark">Form Tambah Barang Masuk</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form action diarahkan ke route store --}}
                    <form action="{{ route('barang-masuk.store') }}" method="post">
                        @csrf
                        {{-- Tanggal Masuk --}}
                        <div class="form-group">
                            <label for="tgl_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" value="{{ old('tgl_masuk', date('Y-m-d')) }}" required>
                        </div>

                        {{-- Sumber Dana --}}
                        <div class="form-group">
                            <label for="sumber_dana">Sumber Dana</label>
                            <input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana') }}" placeholder="Masukkan sumber dana" required>
                        </div>

                                        {{-- Pemasok (Dropdown) --}}
                                        <div class="form-group">
                            <label for="pemasok_id">Pemasok</label>
                            {{-- Ganti class dari 'custom-select' menjadi 'form-control' --}}
                            <select class="form-control" id="pemasok_id" name="pemasok_id" required>
                                <option value="" disabled selected>-- Pilih Pemasok --</option>
                                @foreach ($pemasok as $p)
                                    {{-- Pastikan kolom yang ditampilkan adalah 'nama_pemasok' atau sesuai dengan tabel Anda --}}
                                    <option value="{{ $p->id }}" {{ old('pemasok_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_pemasok }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Karyawan (Dropdown) --}}zz
                        <div class="form-group">
                            <label for="karyawan_id">Karyawan Penerima</label>
                            <select class="form-control" id="karyawan_id" name="karyawan_id" required>
                                <option value="" disabled selected>-- Pilih Karyawan --</option>
                                {{-- Looping data karyawan (users) dari controller --}}
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
