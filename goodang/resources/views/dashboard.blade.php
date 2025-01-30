@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Halo, <span>{{ Auth::user()->name ?? 'Guest' }}</span></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Row 1: Summary Info Boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-truck-loading"></i></span>
                    <div class="info-box-content">
                        <a href="{{ Auth::user()->role === 'admin' ? route('gudang.index') : route('staffgudang.index')}}" class="info-box-text text-dark">Jumlah Gudang</a>
                        <span class="info-box-number">{{ $jumlahGudang }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-boxes"></i></span>
                    <div class="info-box-content">
                        <a href="{{ Auth::user()->role === 'admin' ? route('barang.index') : route('staffbarang.index')}}" class="info-box-text text-dark">Jumlah Barang</a>
                        <span class="info-box-number">{{ $jumlahBarang }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Transaksi Bulan Ini</span>
                        <span class="info-box-number">{{ $jumlahTransaksiBulanIni }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                @if(Auth::user()->role === 'admin')
                <div class="info-box">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah User</span>
                        <span class="info-box-number">{{ $jumlahUser }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- Stock Movement -->
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Stock Movement</h3><br>
                        <form id="filterForm" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="itemFilter">Pilih Barang</label>
                                    <select name="barang_id" id="itemFilter" class="form-control">
                                        <option value="">Semua Barang</option>
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" {{ $barangDipilih == $barang->id ? 'selected' : '' }}>
                                                {{ $barang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="yearFilter">Pilih Tahun</label>
                                    <select name="tahun" id="yearFilter" class="form-control">
                                        @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                            <option value="{{ $year }}" {{ $tahunDipilih == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Filter</button>
                        </form>
                        <div class="card-tools">
                            <span id="toggleChartType" class="text-primary">Switch to Bar Chart</span>
                        </div>
                    </div>
                    <div class="card-body" style="position: relative; height: 50vh; width: 100%;">
                        <canvas id="interactiveChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi Dalam 7 Hari Terakhir</h3><br>
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">{{ $transaksiMingguan->count() }}</span>
                            <span>Total Transaksi</span>
                        </p>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Referensi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiMingguan as $key => $trx)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{route('logtransaksi.show',  $trx->id)}}">{{ $trx->kode_referensi }}</a></td>
                                        <td>{{ $trx->tanggal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Low Stock and Top Staff -->
        <div class="row">
            <!-- Low Stock -->
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Stok Barang Sedikit</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Gudang</th>
                                    <th>Kuantitas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stokSedikit as $stok)
                                    <tr>
                                        <td>{{ $stok->barang->nama }}</td>
                                        <td>{{ $stok->gudang->nama }}</td>
                                        <td>{{ $stok->kuantitas }}</td>
                                        <td>
                                            <a href="{{ route('barang.show', $stok->barang->id )}}" class="text-muted"><i class="fas fa-search"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Staff -->
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">5 Staff Paling Aktif</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Total Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topStaff as $staff)
                                    <tr>
                                        <td><a href="{{ route('users.show', $staff->id) }}">{{ $staff->name ?? '' }}</a></td>
                                        <td>{{ $staff->transaksi_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable untuk tabel transaksi mingguan dengan batas 5 data
        $('.datatable').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false
        });
    });

    const chartDataIn = @json($stockMovementIn);
    const chartDataOut = @json($stockMovementOut);
    const chartLabels = Object.keys(chartDataIn); // Assuming both datasets share the same keys

    let chartType = 'line'; // Default chart type
    const ctx = document.getElementById('interactiveChart').getContext('2d');

    let stockChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Stock In',
                    data: Object.values(chartDataIn),
                    backgroundColor: 'rgba(60,141,188,0.5)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    fill: true,
                },
                {
                    label: 'Stock Out',
                    data: Object.values(chartDataOut),
                    backgroundColor: 'rgba(255,99,132,0.5)',
                    borderColor: 'rgba(255,99,132,0.8)',
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
            },
        }
    });

    document.getElementById('toggleChartType').addEventListener('click', function () {
        stockChart.destroy();
        chartType = chartType === 'line' ? 'bar' : 'line';

        stockChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Stock In',
                        data: Object.values(chartDataIn),
                        backgroundColor: 'rgba(60,141,188,0.5)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        borderWidth: chartType === 'bar' ? 1 : 2,
                        fill: chartType !== 'bar',
                    },
                    {
                        label: 'Stock Out',
                        data: Object.values(chartDataOut),
                        backgroundColor: 'rgba(255,99,132,0.5)',
                        borderColor: 'rgba(255,99,132,0.8)',
                        borderWidth: chartType === 'bar' ? 1 : 2,
                        fill: chartType !== 'bar',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
            }
        });

        this.textContent = chartType === 'line' ? 'Switch to Bar Chart' : 'Switch to Line Chart';
    });
</script>
@endpush

