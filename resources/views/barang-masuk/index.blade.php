@extends('adminlte::page')

@section('title', 'Barang Masuk')

{{-- Mengaktifkan plugin datatables --}}
@section('plugins.Datatables', true)

@section('content_header')
    <h1 class="m-0 text-dark">Data Barang Masuk</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- Menampilkan pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Barang Masuk</h3>
                    <div class="card-tools">
                        {{-- Tombol untuk menambah data baru --}}
                        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped" id="barang-masuk-table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Tanggal Masuk</th>
                                <th>Sumber Dana</th>
                                <th>Pemasok</th>
                                <th>Karyawan Penerima</th>
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
            // Inisialisasi DataTables
            $('#barang-masuk-table').DataTable({
                processing: true,
                serverSide: true,
                // Mengambil data dari route yang sudah kita buat
                ajax: '{{ route("get.barang-masuk") }}', 
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'tgl_masuk', name: 'tgl_masuk' },
                    { data: 'sumber_dana', name: 'sumber_dana' },
                    // Menggunakan nama kolom baru yang kita buat di controller
                    { data: 'pemasok_nama', name: 'pemasok.name' }, 
                    { data: 'karyawan_nama', name: 'karyawan.name' }, 
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                // Mengatur bahasa DataTables ke Bahasa Indonesia
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endpush
