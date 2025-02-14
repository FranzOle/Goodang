@extends('layouts.master')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Penjualan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Penjualan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Form Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('sale.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="client_id" class="form-label">Pilih Client</label>
                            <select name="client_id" id="client_id" class="form-control select2">
                                <option value="">-- Pilih Client --</option>
                                @foreach($clientList as $client)
                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="user_id" class="form-label">Pilih Sales</label>
                            <select name="user_id" id="user_id" class="form-control select2">
                                <option value="">-- Pilih Sales --</option>
                                @foreach($salesUsers as $salesUser)
                                    <option value="{{ $salesUser->id }}" {{ request('user_id') == $salesUser->id ? 'selected' : '' }}>
                                        {{ $salesUser->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach($tahunList as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
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
                            <a href="{{ route('sale.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Form Filter -->

        <div class="card card-primary card-outline">
            <div class="card-body">
                <h5 class="card-title mb-3">Daftar Penjualan</h5>
                @if($saleList->count() > 0)
                    <table class="table table-bordered datatable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Client</th>
                                <th>Sales</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($saleList as $sale)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($sale->tanggal)->format('Y-m-d') }}</td>
                                    <td>{{ $sale->client->nama }}</td>
                                    <td>{{ $sale->user->name }}</td>
                                    <td>{{ number_format($sale->total, 2) }}</td>
                                    <td>{{ ucfirst($sale->status) }}</td>
                                    <td>
                                        <a href="{{ route('sale.show', $sale->id) }}" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <!-- Implementasikan form delete jika diperlukan -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $saleList->links() }}
                    </div>
                @else
                    <div class="alert alert-info">Tidak ada data penjualan untuk filter yang dipilih.</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Inisialisasi Select2 untuk dropdown Client dan Sales
        $('#client_id, #user_id').select2({
            placeholder: '-- Pilih --',
            allowClear: true,
            theme: 'bootstrap4',
            width: '100%'
        });

        $('.datatable').DataTable({
            order: [[0, 'asc']],
            columnDefs: [{ orderable: false, targets: [5] }]
        });
    });
</script>
@endsection
