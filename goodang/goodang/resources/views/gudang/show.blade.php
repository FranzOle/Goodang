@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Gudang: {{ $gudang->nama }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('gudang.index') }}">Gudang</a></li>
                    <li class="breadcrumb-item active">Data Gudang</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Card untuk Stok Barang --}}
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                            <h5 class="card-title">Daftar Stok Barang</h5><br>
                            @if($gudang->jumlahstok->isEmpty())
                            <div class="alert alert-warning">
                                Tidak ada barang di gudang ini.
                            </div>
                            @else
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Gambar</th>
                                        <th>Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gudang->jumlahstok as $key => $stok)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $stok->barang->nama ?? '-' }}</td>
                                            <td>
                                                @if($stok->barang->gambar)
                                                    <img src="{{ asset('storage/' . $stok->barang->gambar) }}" alt="Gambar Barang" class="rounded-circle shadow img-fluid" style="width: 75px; height: 75px; object-fit: cover;">
                                                @else
                                                    Tidak ada gambar
                                                @endif
                                            </td>
                                            <td>{{ $stok->kuantitas ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Card untuk Daftar User --}}
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                            <h5 class="card-title">Daftar User yang Ditugaskan</h5><br>
                            @if($gudang->user->isEmpty())
                            <div class="alert alert-warning">
                                Tidak ada user yang ditugaskan di gudang ini.
                            </div>
                            @else
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama User</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gudang->user as $key => $user)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
