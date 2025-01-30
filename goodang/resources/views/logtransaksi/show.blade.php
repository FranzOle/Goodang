@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Transaksi: {{ $transaksi->kode_referensi }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('logtransaksi.index') }}">Log Transaksi</a></li>
                    <li class="breadcrumb-item active">Detail Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Informasi Transaksi</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Kode Referensi</th>
                                <td>{{ $transaksi->kode_referensi }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $transaksi->tanggal }}</td>
                            </tr>
                            <tr>
                                <th>Gudang</th>
                                <td>{{ $transaksi->gudang->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $transaksi->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $transaksi->deskripsi_tujuan ?? '-' }}</td>
                            </tr>
                        </table>

                        <h5 class="card-title mt-4">Detail Barang</h5>
                        @if($transaksi->transaksidetail->isEmpty())
                            <div class="alert alert-warning">Tidak ada detail barang dalam transaksi ini.</div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi->transaksidetail as $key => $detail)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $detail->barang->nama ?? '-' }}</td>
                                            <td>{{ $detail->kuantitas }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        <a href="{{ route('logtransaksi.index') }}" class="btn btn-secondary mt-3">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
