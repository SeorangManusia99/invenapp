@extends('adminlte::page')

@section('title', 'Edit Barang Masuk')

@section('content_header')
    <h1 class="m-0 text-dark">Form Edit Barang Masuk</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('barang-masuk.update', $barang_masuk->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        {{-- Tanggal Masuk --}}
                        <div class="form-group">
                            <label for="tgl_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" id="tgl_masuk" name="tgl_masuk" value="{{ old('tgl_masuk', $barang_masuk->tgl_masuk) }}" required>
                            @error('tgl_masuk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Sumber Dana --}}
                        <div class="form-group">
                            <label for="sumber_dana">Sumber Dana</label>
                            <input type="text" class="form-control @error('sumber_dana') is-invalid @enderror" id="sumber_dana" name="sumber_dana" value="{{ old('sumber_dana', $barang_masuk->sumber_dana) }}" placeholder="Masukkan sumber dana" required>
                            @error('sumber_dana') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Pemasok (Dropdown) --}}
                        <div class="form-group">
                            <label for="pemasok_id">Pemasok</label>
                            <select class="form-control" id="pemasok_id" name="pemasok_id" required>
                                <option value="" disabled selected>-- Pilih Pemasok --</option>
                                @foreach ($pemasok as $p)
                                    <option value="{{ $p->id }}" {{ old('pemasok_id', $barang_masuk->pemasok_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_pemasok }}</option>
                                @endforeach
                            </select>
                            @error('pemasok_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                           {{-- Karyawan (Dropdown) --}}
                           <div class="form-group">
                            <label for="karyawan_id">Karyawan Penerima</label>
                            <select class="form-control @error('karyawan_id') is-invalid @enderror" id="karyawan_id" name="karyawan_id" required>
                                <option value="" disabled>-- Pilih Karyawan --</option>
                                {{-- Looping data karyawan (users) dari controller --}}
                                @foreach ($karyawan as $k)
                                    <option value="{{ $k->id }}" {{ old('karyawan_id', $barang_masuk->karyawan_id) == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id') <span class="text-danger">{{ $message }}</span> @enderror
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
