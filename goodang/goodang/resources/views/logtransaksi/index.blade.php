@extends('layouts.master')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Log Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Log Transaksi</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <form method="GET" action="{{ route('logtransaksi.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Filter Tanggal</label>
                            <select name="tanggal" class="form-control">
                                <option value="">Semua Data</option>
                                <option value="hari" {{ request('tanggal') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="bulan" {{ request('tanggal') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="tahun" {{ request('tanggal') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Tanggal Spesifik</label>
                            <input type="date" name="tanggal_spesifik" class="form-control" value="{{ request('tanggal_spesifik') }}">
                        </div>
                        <div class="col-md-2">
                            <label>Barang</label>
                            <select name="barang_id" class="form-control">
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Gudang</label>
                            <select name="gudang_id" class="form-control">
                                <option value="">Pilih Gudang</option>
                                @foreach($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}" {{ request('gudang_id') == $gudang->id ? 'selected' : '' }}>
                                        {{ $gudang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>User</label>
                            <select name="user_id" class="form-control">
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-body">
                <h5 class="card-title mb-3">Daftar Log Transaksi</h5>
                <table class="table table-bordered datatable" id="logTransaksiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Referensi</th>
                            <th>Tanggal</th>
                            <th>Gudang</th>
                            <th>User</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->kode_referensi }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->gudang->nama }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ ucfirst($item->stock_type) }}</td>
                                <td>
                                    <a href="{{ route('logtransaksi.show', $item->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa fa-eye me-2"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('logtransaksi.export') }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#logTransaksiTable').DataTable({
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