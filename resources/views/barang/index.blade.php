@extends('adminlte::page')

@section('title', 'Barang')

@section('plugins.Datatables', true)

@section('content_header')
    <h1 class="m-0 text-dark">Data Barang</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Data Barang
                    <a href="{{ route('barang.create') }}" class="btn btn-md btn-primary float-right">Tambah Baru</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
`
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function() {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.barang') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_barang', name: 'nama' },
                    { data: 'merk', name: 'merk' },
                    { data: 'tipe', name: 'tipe' },
                    { data: 'satuan', name: 'satuan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush
