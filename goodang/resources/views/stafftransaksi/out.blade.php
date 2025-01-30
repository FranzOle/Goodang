@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Export Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('logtransaksi.index')}}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Export Barang</li>
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
                        <h5 class="card-title">Transaksi Barang Keluar</h5><br>
                        <form role="form" action="{{ route('stafftransaksi.store', 'out') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <!-- Gudang Asal -->
                                <div class="form-group">
                                    <label>Gudang Asal</label>
                                    <input type="text" class="form-control" value="{{ $gudangAsal->nama }}" readonly>
                                    <input type="hidden" name="id_gudang" value="{{ $gudangAsal->id }}">
                                </div>

                                <!-- Informasi Transaksi -->
                                <div class="form-group">
                                    <label>Kode Referensi</label>
                                    <div class="input-group">
                                        <input id="kode_referensi" name="kode_referensi" type="text" class="form-control" placeholder="Masukkan Kode Referensi" required>
                                    <div class="input-group-append">
                                        <button type="button" id="generate-referensi" class="btn btn-primary">Generate</button>
                                    </div>
                                    </div>
                                    @if($errors->has('kode_referensi'))
                                    <span class="required text-danger">{{ $errors->first('kode_referensi') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input name="tanggal" type="date" class="form-control" required>
                                    @if($errors->has('tanggal'))
                                    <span class="required text-danger">{{ $errors->first('tanggal') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi_tujuan" class="form-control" rows="3" placeholder="Masukkan Deskripsi"></textarea>
                                    @if($errors->has('deskripsi_tujuan'))
                                    <span class="required text-danger">{{ $errors->first('deskripsi_tujuan') }}</span>
                                    @endif
                                </div>

                                <!-- Barang -->
                                <h5 class="mt-4">Barang</h5>
                                <div id="stok-container">
                                    <div class="row mb-2 stok-row">
                                        <div class="col-md-6">
                                            <label>Barang</label>
                                            <select name="stok[0][id_barang]" class="form-control barang-dropdown" required>
                                                <option value="">Pilih Barang</option>
                                                @foreach($gudangAsal->jumlahstok as $stok)
                                                    <option value="{{ $stok->barang->id }}">{{ $stok->barang->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Kuantitas</label>
                                            <input name="stok[0][kuantitas]" type="number" class="form-control" min="1" placeholder="Masukkan Kuantitas" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-stok">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success mt-3" id="add-stok">
                                    Tambah Barang
                                </button><br>
                                <button type="submit" class="btn btn-primary my-3">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let stokIndex = 1;

    // Menambahkan baris barang baru
    document.getElementById('add-stok').addEventListener('click', function () {
        const container = document.getElementById('stok-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-2', 'stok-row');
        newRow.innerHTML = `
            <div class="col-md-6">
                <label>Barang</label>
                <select name="stok[${stokIndex}][id_barang]" class="form-control barang-dropdown" required>
                    <option value="">Pilih Barang</option>
                    @foreach($gudangAsal->jumlahstok as $stok)
                        <option value="{{ $stok->barang->id }}">{{ $stok->barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Kuantitas</label>
                <input name="stok[${stokIndex}][kuantitas]" type="number" class="form-control" min="1" placeholder="Masukkan Kuantitas" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-stok">Hapus</button>
            </div>
        `;
        container.appendChild(newRow);

        stokIndex++;
    });

    // Event Listener untuk tombol hapus
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-stok')) {
            e.target.closest('.stok-row').remove();
        }
    });
</script>
@endsection
