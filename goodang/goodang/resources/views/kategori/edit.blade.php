@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Kategori</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('kategori.index')}}">Kategori</a></li>
            <li class="breadcrumb-item active">Edit Kategori</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6">

          <div class="card card-primary card-outline">
            <div class="card-body">
              <h5 class="card-title">Edit Kategori Barang</h5><br>

              <form role="form" action="{{route('kategori.update', $kategori->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Kategori</label>
                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Kategori" value="{{ $kategori->nama}}">
                    @if($errors->has('nama'))
                    <span class="required text-danger">{{$errors->first('nama') }}</span>
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary"><li class="fa fa-save"></li>Submit</button>
                </div>
                <!-- /.card-body -->
              </form>

            </div>
          </div><!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
@endsection