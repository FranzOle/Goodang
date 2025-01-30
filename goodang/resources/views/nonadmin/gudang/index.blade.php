@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Pergudangan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">List Gudang</li>
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
        <div class="col-lg-10">

          <div class="card card-primary card-outline">
            <div class="card-body">
              <h5 class="card-title">List Gudang</h5><br>
              
            <a class="btn btn-sm btn-danger" href="{{ route('gudang.export') }}">
              <i class="fa fa-file-pdf me-2"></i> Export PDF
          </a><br><br> 
            
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Gudang</th>
                        <th>Alamat Gudang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($gudang)
                        @foreach($gudang as $key => $gudang)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $gudang->nama ?? '' }}</td>
                                <td>{{ $gudang->alamat ?? '' }}</td>
                                <td><a href="{{ route('staffgudang.show', $gudang->id) }}" class="btn btn-sm btn-outline-info">
                                  <i class="fa fa-eye me-2"></i>
                              </a></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection