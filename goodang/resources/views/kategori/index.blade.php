@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Kategori</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">List Kategori</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-10">
          <div class="card card-primary card-outline">
            <div class="card-body">
              <h5 class="card-title">List Kategori</h5><br>
              @if(Auth::check() && Auth::user()->role === 'admin')
              <a class="btn btn-sm btn-primary me-4" href="{{ route('kategori.create') }}">
                <i class="fa fa-solid fa-plus me-2"></i> Tambah Kategori
              </a>
              @endif
              <a class="btn btn-sm btn-danger" href="{{ route('kategori-export') }}">
                <i class="fa fa-file-pdf me-2"></i> Export PDF
              </a><br><br>
              
              <table class="table table-bordered datatable">
                  <thead>
                      <tr>
                          <th>No.</th>
                          <th>Nama Kategori</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if($kategori)
                          @foreach($kategori as $key => $kategori)
                              <tr>
                                  <td>{{ ++$key }}</td>
                                  <td>{{ $kategori->nama ?? '' }}</td>
                                  <td>
                                      <a href="{{ route('kategori.show', $kategori->id) }}" class="btn btn-sm btn-outline-info">
                                          <i class="fa fa-eye me-2"></i>
                                      </a>
                                      @if(Auth::check() && Auth::user()->role === 'admin')
                                          <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-sm btn-outline-primary">
                                              <i class="fa fa-edit me-2"></i>
                                          </a>
                                          <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="kategori-delete{{ $kategori->id }}" method="post">
                                              <i class="fa fa-solid fa-trash me-2"></i>
                                          </a>
                                          <form id="kategori-delete{{ $kategori->id }}" action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:none;">
                                              @csrf
                                              @method('DELETE')
                                          </form>
                                      @endif
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
