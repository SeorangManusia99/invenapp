@extends('adminlte::page')

@section('title', 'Edit Users')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Edit Data Pengguna
                </div>

                <div class="card-body">
                    <form action="{{ route('users.update' , $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input value="{{ $user->name }}" type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input value="{{ $user->email }}" type="email" name="email" class="form-control" placeholder="Masukkan Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-danger"> Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
