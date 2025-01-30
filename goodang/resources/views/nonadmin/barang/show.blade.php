@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Barang: {{ $barang->nama }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staffbarang.index') }}">Barang</a></li>
                    <li class="breadcrumb-item active">Detail Barang</li>
                </ol>
            </div>
            
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5>Informasi Barang</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Kode SKU</th>
                                <td>{{ $barang->kode_sku }}</td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $barang->nama }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $barang->deskripsi ?? 'Tidak ada deskripsi' }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>{{ $barang->kategori->nama ?? 'Tidak ada kategori' }}</td>
                            </tr>
                            <tr>
                                <th>Supplier</th>
                                <td>{{ $barang->supplier->nama ?? 'Tidak ada supplier' }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td class="harga-barang format-harga" data-harga="{{ $barang->harga }}"></td>
                            </tr>
                            <tr>
                                <th>Gambar</th>
                                <td>
                                    @if($barang->gambar)
                                        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" width="100">
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <h5 class="mt-4">Jumlah Stok</h5>
                        @if($barang->jumlahstok->isEmpty())
                            <div class="alert alert-warning">Tidak ada stok untuk barang ini.</div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Gudang</th>
                                        <th>Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang->jumlahstok as $key => $stok)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $stok->gudang->nama ?? 'Tidak ada data gudang' }}</td>
                                            <td>{{ $stok->kuantitas }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <br>
                        <a href="{{ route('barang.export_show', $barang->id) }}" class="btn btn-danger mb-3">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
