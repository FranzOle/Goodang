@extends('layouts.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Kartu Stok Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kartu Stok</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <!-- Form Filter -->
                <form action="{{ route('kartustok.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="id_barang" class="form-label">Pilih Barang</label>
                            <select name="id_barang" id="id_barang" class="form-control">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangList as $barang)
                                    <option value="{{ $barang->id }}" {{ request('id_barang') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="id_gudang" class="form-label">Pilih Gudang</label>
                            <select name="id_gudang" id="id_gudang" class="form-control">
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangList as $gudang)
                                    <option value="{{ $gudang->id }}" {{ request('id_gudang') == $gudang->id ? 'selected' : '' }}>
                                        {{ $gudang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                            @if(request('id_barang') && request('id_gudang'))
                            <a href="{{ route('kartustok.export', ['id_barang' => request('id_barang'), 'id_gudang' => request('id_gudang')]) }}" class="btn btn-success">
                                <i class="fa fa-file-excel"></i>
                                Export ke Excel
                            </a>
                        @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tampilkan informasi stok jika filter dipilih -->
        @if(request('id_barang') && request('id_gudang'))
        <div class="row mb-3">
            <div class="col-12">
                <div class="">
                    <strong>Informasi Stok:</strong><br>
                    Barang: <strong>{{ $barangList->firstWhere('id', request('id_barang'))->nama ?? 'Barang tidak ditemukan' }}</strong><br>
                    Gudang: <strong>{{ $gudangList->firstWhere('id', request('id_gudang'))->nama ?? 'Gudang tidak ditemukan' }}</strong><br>
                    Kuantitas: <strong>{{ $stokGudang->firstWhere('id_gudang', request('id_gudang'))->kuantitas ?? 0 }}</strong>
                </div>
            </div>
        </div>
        @endif

        <div class="card card-primary card-outline">
            <div class="card-body">
                <h5 class="card-title mb-3">Daftar Kartu Stok</h5>
                @if(count($kartuStok) > 0)
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Kode Referensi</th>
                                <th>Transaksi</th>
                                <th>Kuantitas</th>
                                <th>Tipe</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kartuStok as $detail)
                                <tr>
                                    <td>{{ $detail->transaksi->kode_referensi }}</td>
                                    <td>{{ $detail->transaksi->deskripsi_tujuan }}</td>
                                    <td>{{ $detail->kuantitas }}</td>
                                    <td>{{ $detail->transaksi->stock_type == 'in' ? 'Masuk' : 'Keluar' }}</td>
                                    <td>{{ $detail->transaksi->tanggal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">Tidak ada data kartu stok untuk filter yang dipilih.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $(document).ready(function () {
        $('#kartustoktable').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
        });
    });
</script>
@endsection
