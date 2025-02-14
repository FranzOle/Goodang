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
                <form action="{{ route('kartustok.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="id_barang" class="form-label">Pilih Barang</label>
                            <select name="id_barang" id="id_barang" class="form-control select2">
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangList as $barang)
                                    <option value="{{ $barang->id }}" {{ request('id_barang') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="id_gudang" class="form-label">Gudang</label>
                            <select name="id_gudang" id="id_gudang" class="form-control">
                                <option value="">-- Semua Gudang --</option>
                                @foreach($gudangList as $gudang)
                                    <option value="{{ $gudang->id }}" {{ request('id_gudang') == $gudang->id ? 'selected' : '' }}>
                                        {{ $gudang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">-- Pilih Tahun --</option>
                                @for($i = date('Y'); $i >= 2000; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control">
                                <option value="">-- Pilih Bulan --</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('kartustok.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
                                <th>Tanggal</th>
                                <th>Kode Referensi</th>
                                <th>Transaksi</th>
                                <th>Jumlah</th>
                                <th>Sisa Stok</th>
                                <th>Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kartuStok as $detail)
                                <tr>
                                    <td>{{ $detail->transaksi->tanggal }}</td>
                                    <td><a href="{{ route('logtransaksi.show', $detail->transaksi->id) }}">{{ $detail->transaksi->kode_referensi }}</a></td>
                                    <td>{{ $detail->transaksi->deskripsi_tujuan }}</td>
                                    <td>{{ $detail->transaksi->stock_type == 'in' ? '' : '' }}{{ $detail->kuantitas }}</td>
                                    <td>{{ $detail->saldo }}</td>
                                    <td>{{ $detail->transaksi->stock_type == 'in' ? 'Masuk' : 'Keluar' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(request('id_barang') && request('id_gudang'))
                            <a href="{{ route('kartustok.export', ['id_barang' => request('id_barang'), 'id_gudang' => request('id_gudang')]) }}" class="btn btn-success">
                                <i class="fa fa-file-excel"></i>
                                Export ke Excel
                            </a>
                        @endif
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
        $('.select2').select2({
            placeholder: '-- Pilih Barang --',
            allowClear: true,
            theme: 'bootstrap4',
            width: '100%' // Sesuaikan lebar dengan container
        });

        $('.datatable').DataTable({
            order: [[0, 'asc']],
            columnDefs: [{ orderable: false, targets: [2,3,4,5] }]
        });
    });
</script>
@endsection
