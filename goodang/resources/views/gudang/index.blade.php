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
              <a class="btn btn-sm btn-primary me-4" href="{{ route('gudang.create') }}">
                <i class="fa fa-solid fa-plus me-2"></i> Tambah Data
            </a>
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
                                <td>
                                  <a href="{{ route('gudang.show', $gudang->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fa fa-eye me-2"></i> Show
                                </a>
                                    <a href="{{ route('gudang.edit', $gudang->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit me-2"></i> Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="gudang-delete{{ $gudang->id }}" method="post">
                                        <i class="fa fa-solid fa-trash me-2"></i> Hapus
                                    </a>
                                    <form id="gudang-delete{{ $gudang->id }}" action="{{ route('gudang.destroy', $gudang->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>                                        
                                </td>
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