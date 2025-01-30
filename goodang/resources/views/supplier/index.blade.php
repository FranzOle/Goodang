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
            <li class="breadcrumb-item active">List Supplier</li>
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
        <div class="col-lg-12">

          <div class="card card-primary card-outline">
            <div class="card-body">
              <h5 class="card-title">List Supplier</h5><br>
              <a class="btn btn-sm btn-primary me-4" href="{{ route('supplier.create') }}">
                <i class="fa fa-solid fa-plus me-2"></i> Tambah Data
            </a>
            <a class="btn btn-sm btn-danger" href="{{ route('supplier.export') }}">
              <i class="fa fa-file-pdf me-2"></i> Export PDF
          </a><br><br> 
            
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Supplier</th>
                        <th>No. Telepon</th>
                        <th>Alamat Supplier</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($supplier)
                        @foreach($supplier as $key => $supplier)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td><a href="{{ route('supplier.show', $supplier->id) }}">{{ $supplier->nama ?? '' }}</a></td>
                                <td>{{ $supplier->telepon ?? '' }}</td>
                                <td>{{ $supplier->alamat ?? '' }}</td>
                                <td>
                                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit me-2"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="supplier-delete{{ $supplier->id }}" method="post">
                                        <i class="fa fa-solid fa-trash me-2"></i>
                                    </a>
                                    <form id="supplier-delete{{ $supplier->id }}" action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display:none;">
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