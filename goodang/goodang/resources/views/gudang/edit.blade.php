@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Gudang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('gudang.index')}}">Gudang</a></li>
            <li class="breadcrumb-item active">Edit Gudang</li>
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
              <h5 class="card-title">Edit data Gudang</h5><br>

              <form role="form" action="{{route('gudang.update', $gudang->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="nama">Nama Gudang</label>
                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama Gudang" value="{{ $gudang->nama }}">
                    @if($errors->has('nama'))
                    <span class="required text-danger">{{$errors->first('nama') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input name="alamat" type="text" class="form-control" placeholder="Masukkan alamat Gudang" value="{{ $gudang->alamat }}">
                    @if($errors->has('alamat'))
                    <span class="required text-danger">{{$errors->first('alamat') }}</span>
                    @endif
                  </div>
                  <div id="map" style="height: 300px; width: 100%;"></div>
                  <button type="submit" class="btn btn-primary my-3"><i class="fa fa-save"></i> Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
