@extends('adminlte::page')

@section('title', 'Edit Barang')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Barang</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Edit Barang
                </div>

                <div class="card-body">
                    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" value="{{ $barang->nama_barang }}" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang">
                        </div>
                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" value="{{ $barang->merk }}" name="merk" class="form-control" placeholder="Masukkan Merk">
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe</label>
                            <select type="text" name="tipe" class="form-control" placeholder="Masukkan Tipe">

                                <option value="FOOD" {{ $barang->tipe == 'FOOD' ? 'selected' : '' }}>Makanan</option>
                                <option value="NONFOOD" {{ $barang->tipe == 'NONFOOD' ? 'selected' : '' }}>Bukan Makanan</option>

                            </select>

                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="number" value="{{ $barang->satuan }}" name="satuan" class="form-control" placeholder="Masukkan Satuan">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
