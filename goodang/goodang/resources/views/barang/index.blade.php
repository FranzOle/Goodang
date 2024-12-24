@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Barang</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">List Barang</li>
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
              <h5 class="card-title">List Barang</h5><br>
              <a class="btn btn-sm btn-primary me-4" href="{{ route('barang.create') }}">
                <i class="fa fa-solid fa-plus me-2"></i> Tambah Data
            </a>
            <a class="btn btn-sm btn-danger" href="{{ route('barang.export') }}">
              <i class="fa fa-file-pdf me-2"></i> Export PDF
          </a>
            <br><br> 
            
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Gambar</th>
                        <th>Kode SKU</th>
                        <th>Supplier</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($barang)
                        @foreach($barang as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->nama ?? '' }}</td>
                                <td>
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Barang" class="rounded-circle shadow img-fluid" style="width: 75px; height: 75px; object-fit: cover;">
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td>
                                <td>{{ $item->kode_sku ?? '' }}</td>
                                <td>{{ $item->supplier->nama ?? '' }}</td>
                                <td>
                                  <a href="{{ route('barang.show', $item->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fa fa-eye me-2"></i> Show
                                </a>
                                    <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit me-2"></i> Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="barang-delete{{ $item->id }}" method="post">
                                        <i class="fa fa-solid fa-trash me-2"></i> Hapus
                                    </a>
                                    <form id="barang-delete{{ $item->id }}" action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display:none;">
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
