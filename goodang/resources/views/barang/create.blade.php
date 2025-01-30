@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
                    <li class="breadcrumb-item active">Tambah Barang</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Card Tambah Barang -->
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Tambahkan Data Barang</h5><br>
                        <form role="form" action="{{ route('barang.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="id_kategori" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_kategori'))
                                    <span class="required text-danger">{{ $errors->first('id_kategori') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select name="id_supplier" class="form-control">
                                        <option value="">Pilih Supplier</option>
                                        @foreach($supplier as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_supplier'))
                                    <span class="required text-danger">{{ $errors->first('id_supplier') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Kode SKU</label>
                                    <div class="input-group">
                                        <input id="kode_sku" name="kode_sku" type="text" class="form-control" placeholder="Masukkan Kode SKU">
                                        <div class="input-group-append">
                                            <button type="button" id="generate-sku" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                    @if($errors->has('kode_sku'))
                                    <span class="required text-danger">{{ $errors->first('kode_sku') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama Barang">
                                    @if($errors->has('nama'))
                                    <span class="required text-danger">{{ $errors->first('nama') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan Deskripsi Barang"></textarea>
                                    @if($errors->has('deskripsi'))
                                    <span class="required text-danger">{{ $errors->first('deskripsi') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Harga Barang</label>
                                    <input id="harga" name="harga" type="text" class="form-control" placeholder="Masukkan Harga Barang">
                                    @if($errors->has('harga'))
                                    <span class="required text-danger">{{ $errors->first('harga') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Gambar Barang</label>
                                    <input name="gambar" type="file" class="form-control">
                                    @if($errors->has('gambar'))
                                    <span class="required text-danger">{{ $errors->first('gambar') }}</span>
                                    @endif
                                </div>
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
@endsection

@push('scripts')
<script>
    const hargaInput = document.getElementById('harga');
    const hiddenHargaInput = document.createElement('input');
    hiddenHargaInput.type = 'hidden';
    hiddenHargaInput.name = 'harga';
    hargaInput.parentNode.appendChild(hiddenHargaInput);

    hargaInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        hiddenHargaInput.value = value; // Simpan nilai numerik ke hidden input
        e.target.value = 'Rp. ' + new Intl.NumberFormat('id-ID').format(value); // Tampilkan format rupiah dengan tanda "Rp."
    });
</script>
@endpush