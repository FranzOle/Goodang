@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Transfer Barang Antar Gudang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('logtransaksi.index')}}">Transaksi</a></li>
                    <li class="breadcrumb-item active">Transfer Barang</li>
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
                        <h5 class="card-title">Transaksi Transfer Barang</h5><br>
                        <form role="form" action="{{ route('transaksi.transfer.store') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <!-- Gudang Asal -->
                                <div class="form-group">
                                    <label>Gudang Asal</label>
                                    <select id="gudang-asal" name="gudang_asal" class="form-control" required>
                                        <option value="">Pilih Gudang Asal</option>
                                        @foreach($gudangs as $gudang)
                                            <option value="{{ $gudang->id }}">{{ $gudang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Gudang Tujuan -->
                                <div class="form-group">
                                    <label>Gudang Tujuan</label>
                                    <select name="gudang_tujuan" class="form-control" required>
                                        <option value="">Pilih Gudang Tujuan</option>
                                        @foreach($gudangs as $gudang)
                                            <option value="{{ $gudang->id }}">{{ $gudang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Informasi Transaksi -->
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
                                    <textarea name="deskripsi_tujuan" class="form-control" rows="3" placeholder="Masukkan Deskripsi"></textarea>
                                </div>

                                <!-- Barang -->
                                <h5 class="mt-4">Barang</h5>
                                <div id="stok-container">
                                    <div class="row mb-2 stok-row">
                                        <div class="col-md-6">
                                            <label>Barang</label>
                                            <select name="stok[0][id_barang]" class="form-control barang-dropdown" required>
                                                <option value="">Pilih Barang</option>
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

    // Barang per gudang asal
    const barangPerGudang = @json($gudangs->mapWithKeys(function($gudang) {
        return [$gudang->id => $gudang->jumlahstok->map(function($stok) {
            return ['id' => $stok->barang->id, 'nama' => $stok->barang->nama];
        })];
    }));

    // Fungsi untuk memuat barang dari gudang asal
    function loadBarang(gudangId, dropdown) {
        dropdown.innerHTML = '<option value="">Pilih Barang</option>';
        if (barangPerGudang[gudangId]) {
            barangPerGudang[gudangId].forEach(barang => {
                dropdown.innerHTML += `<option value="${barang.id}">${barang.nama}</option>`;
            });
        }
    }

    // Event Listener untuk Gudang Asal
    document.getElementById('gudang-asal').addEventListener('change', function () {
        const gudangId = this.value;
        const firstDropdown = document.querySelector('.barang-dropdown');
        loadBarang(gudangId, firstDropdown);
    });

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

        const gudangId = document.getElementById('gudang-asal').value;
        const dropdown = newRow.querySelector('.barang-dropdown');
        loadBarang(gudangId, dropdown);

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
