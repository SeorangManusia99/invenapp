@extends('adminlte::page')

@section('title', 'Edit Karyawan')

@section('content_header')
    <h1 class="m-0 text-dark">Form Edit Karyawan</h1>
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
                    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        {{-- User (ditampilkan sebagai teks, tidak bisa diubah) --}}
                        <div class="form-group">
                            <label>Nama Karyawan</label>
                            <input type="text" class="form-control" value="{{ $karyawan->user->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $karyawan->user->email }}" readonly>
                        </div>

                        {{-- Nomor HP --}}
                        <div class="form-group">
                            <label for="nomor_hp">Nomor HP</label>
                            <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $karyawan->nomor_hp) }}" required>
                            @error('nomor_hp') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
                            @error('alamat') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
