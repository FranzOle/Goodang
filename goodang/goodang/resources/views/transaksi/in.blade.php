@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Import Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('logtransaksi.index')}}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Import Barang</li>
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
                        <h5 class="card-title">Transaksi Import</h5><br>
                        <form role="form" action="{{ route('transaksi.store', 'in') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Gudang</label>
                                    <select name="id_gudang" class="form-control" required>
                                        <option value="">Pilih Gudang</option>
                                        @foreach($gudangs as $gudang)
                                            <option value="{{ $gudang->id }}">{{ $gudang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kode Referensi</label>
                                    <input name="kode_referensi" type="text" class="form-control" placeholder="Masukkan Kode Referensi" required>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input name="tanggal" type="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi_tujuan" class="form-control" rows="3" placeholder="Masukkan Deskripsi" required></textarea>
                                </div>
                                <h5 class="mt-4">Barang</h5>
                                <div id="stok-container">
                                    <div class="row mb-2 stok-row">
                                        <div class="col-md-6">
                                            <label>Barang</label>
                                            <select name="stok[0][id_barang]" class="form-control" required>
                                                <option value="">Pilih Barang</option>
                                                @foreach($barangs as $barang)
                                                    <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Kuantitas</label>
                                            <input name="stok[0][kuantitas]" type="number" class="form-control" min="1" placeholder="Masukkan Kuantitas" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success mt-3" id="add-stok">
                                    Tambah Barang
                                </button>
                                <br>
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
    document.getElementById('add-stok').addEventListener('click', function() {
        const container = document.getElementById('stok-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'mb-2', 'stok-row');
        newRow.innerHTML = `
            <div class="col-md-6">
                <label>Barang</label>
                <select name="stok[${stokIndex}][id_barang]" class="form-control" required>
                    <option value="">Pilih Barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Kuantitas</label>
                <input name="stok[${stokIndex}][kuantitas]" type="number" class="form-control" min="1" placeholder="Masukkan Kuantitas" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-stok">
                    Hapus
                </button>
            </div>
        `;
        container.appendChild(newRow);

        // Tambahkan event listener untuk tombol hapus
        newRow.querySelector('.remove-stok').addEventListener('click', function() {
            newRow.remove();
            stokIndex--;
        });

        stokIndex++;
    });
</script>
@endsection
