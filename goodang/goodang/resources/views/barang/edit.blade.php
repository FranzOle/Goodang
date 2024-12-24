@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
                    <li class="breadcrumb-item active">Edit Barang</li>
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
                        <h5 class="card-title">Perbarui Data Barang</h5><br>
                        <form role="form" action="{{ route('barang.update', $barang->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="id_kategori" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategori as $item)
                                            <option value="{{ $item->id }}" {{ $barang->id_kategori == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
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
                                            <option value="{{ $item->id }}" {{ $barang->id_supplier == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_supplier'))
                                    <span class="required text-danger">{{ $errors->first('id_supplier') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Kode SKU</label>
                                    <input name="kode_sku" type="text" class="form-control" value="{{ $barang->kode_sku }}" placeholder="Masukkan Kode SKU">
                                    @if($errors->has('kode_sku'))
                                    <span class="required text-danger">{{ $errors->first('kode_sku') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input name="nama" type="text" class="form-control" value="{{ $barang->nama }}" placeholder="Masukkan Nama Barang">
                                    @if($errors->has('nama'))
                                    <span class="required text-danger">{{ $errors->first('nama') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan Deskripsi Barang">{{ $barang->deskripsi }}</textarea>
                                    @if($errors->has('deskripsi'))
                                    <span class="required text-danger">{{ $errors->first('deskripsi') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Gambar Barang</label>
                                    @if($barang->gambar)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" style="width: 100px;">
                                        </div>
                                    @endif
                                    <input name="gambar" type="file" class="form-control">
                                    @if($errors->has('gambar'))
                                    <span class="required text-danger">{{ $errors->first('gambar') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary my-3">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('barang.index') }}" class="btn btn-secondary my-3">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
