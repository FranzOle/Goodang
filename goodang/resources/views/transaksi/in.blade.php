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
                                            <option value="{{ $gudang->id }}" @selected(old('id_gudang') == $gudang->id)>
                                                {{ $gudang->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_gudang'))
                                    <span class="required text-danger">{{ $errors->first('id_gudang') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Kode Referensi</label>
                                    <div class="input-group">
                                        <input id="kode_referensi" name="kode_referensi" type="text" 
                                               class="form-control" placeholder="Masukkan Kode Referensi" 
                                               value="{{ old('kode_referensi') }}" required>
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
                                    <input name="tanggal" type="date" class="form-control" 
                                           value="{{ old('tanggal') }}" required>
                                    @if($errors->has('tanggal'))
                                    <span class="required text-danger">{{ $errors->first('tanggal') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi_tujuan" class="form-control" rows="3" 
                                              placeholder="Masukkan Deskripsi" required>{{ old('deskripsi_tujuan') }}</textarea>
                                    @if($errors->has('deskripsi_tujuan'))
                                    <span class="required text-danger">{{ $errors->first('deskripsi_tujuan') }}</span>
                                    @endif
                                </div>
                                <h5 class="mt-4">Barang</h5>
                                <div id="stok-container">
                                    @php $oldStok = old('stok', [['id_barang' => '', 'kuantitas' => '']]); @endphp
                                    @foreach($oldStok as $index => $stok)
                                    <div class="row mb-2 stok-row">
                                        <div class="col-md-6">
                                            <label>Barang</label>
                                            <select name="stok[{{ $index }}][id_barang]" class="form-control" required>
                                                <option value="">Pilih Barang</option>
                                                @foreach($barangs as $barang)
                                                    <option value="{{ $barang->id }}" 
                                                        @selected($stok['id_barang'] == $barang->id)>
                                                        {{ $barang->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Kuantitas</label>
                                            <input name="stok[{{ $index }}][kuantitas]" type="number" 
                                                   class="form-control" min="1" 
                                                   value="{{ $stok['kuantitas'] }}" 
                                                   placeholder="Masukkan Kuantitas" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            @if($index > 0)
                                            <button type="button" class="btn btn-danger btn-sm remove-stok">
                                                Hapus
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
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
    let stokIndex = {{ count($oldStok) }};

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
                <input name="stok[${stokIndex}][kuantitas]" type="number" 
                       class="form-control" min="1" 
                       placeholder="Masukkan Kuantitas" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-stok">
                    Hapus
                </button>
            </div>
        `;
        container.appendChild(newRow);
        
        newRow.querySelector('.remove-stok').addEventListener('click', function() {
            newRow.remove();
        });

        stokIndex++;
    });

    // Handle remove buttons for existing rows
    document.querySelectorAll('.remove-stok').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.stok-row').remove();
        });
    });
</script>
@endsection