@extends('adminlte::page')

@section('title', 'Data Karyawan')

@section('plugins.Datatables', true)

@section('content_header')
    <h1 class="m-0 text-dark">Data Karyawan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Karyawan</h3>
                    <div class="card-tools">
                        <a href="{{ route('karyawan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Karyawan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="karyawan-table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function() {
            $('#karyawan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("get.karyawan") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_user', name: 'user.name' },
                    { data: 'email_user', name: 'user.email' },
                    { data: 'nomor_hp', name: 'nomor_hp' },
                    { data: 'alamat', name: 'alamat' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: { url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json" }
            });
        });
    </script>
@endpush
