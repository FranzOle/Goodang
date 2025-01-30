@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Klien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Toko</a></li>
                    <li class="breadcrumb-item active">Edit Toko</li>
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
                        <h5 class="card-title">Edit data Klien</h5><br>
                        <form role="form" action="{{ route('client.update', $client->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama Toko</label>
                                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama Klien" value="{{ old('nama', $client->nama) }}">
                                    @if($errors->has('nama'))
                                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input id="telepon" name="no_telepon" type="text" class="form-control" placeholder="Masukkan No. Telepon" value="{{ old('no_telepon', $client->no_telepon) }}">
                                    @if($errors->has('no_telepon'))
                                    <span class="text-danger">{{ $errors->first('no_telepon') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" type="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email', $client->email) }}">
                                    @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input id="alamat" name="alamat" type="text" class="form-control" placeholder="Pilih alamat dari peta" value="{{ old('alamat', $client->alamat) }}">
                                    @if($errors->has('alamat'))
                                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                    @endif
                                </div>
                                <div id="map" style="height: 300px; width: 100%;"></div>
                                <button type="submit" class="btn btn-primary my-3">
                                    <i class="fa fa-save"></i> Update
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