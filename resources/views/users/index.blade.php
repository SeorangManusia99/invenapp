@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1 class="m-0 text-dark">Data Pengguna</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Data Pengguna
                    <a href="{{ route('users.create') }}" class="btn btn-md btn-primary float-right">Tambah Baru</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>NO</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>

                        @php
                            $no = 1;
                        @endphp

                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-md btn-warning">Edit</a>
                                    <button type="submit" class="btn btn-md btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
