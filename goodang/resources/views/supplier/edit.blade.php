@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Supplier</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('supplier.index')}}">Supplier</a></li>
            <li class="breadcrumb-item active">Edit Supplier</li>
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
              <h5 class="card-title">Edit data Supplier</h5><br>

              <form role="form" action="{{route('supplier.update', $supplier->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama Supplier</label>
                    <input name="nama" type="text" class="form-control" placeholder="Masukkan Nama Supplier" value="{{ $supplier->nama}}">
                    @if($errors->has('nama'))
                    <span class="required text-danger">{{$errors->first('nama') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">No Telepon</label>
                    <input name="telepon" type="text" class="form-control" placeholder="Masukkan Telepon Supplier" value="{{ $supplier->telepon}}">
                    @if($errors->has('telepon'))
                    <span class="required text-danger">{{$errors->first('telepon') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Alamat</label>
                    <input name="alamat" type="text" class="form-control" placeholder="Masukkan alamat Supplier" value="{{ $supplier->alamat}}">
                    @if($errors->has('alamat'))
                    <span class="required text-danger">{{$errors->first('alamat') }}</span>
                    @endif
                  </div>
                  <div id="map" style="height: 300px; width: 100%;"></div>
                  <button type="submit" class="btn btn-primary my-3"><li class="fa fa-save"></li>Submit</button>
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