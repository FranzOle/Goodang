@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Daftar Toko/Customer</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">List Toko</li>
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
              <h5 class="card-title">List Klien</h5><br>
              <a class="btn btn-sm btn-primary me-4" href="{{ route('client.create') }}">
                <i class="fa fa-solid fa-plus me-2"></i> Tambah Data
              </a>
              <a class="btn btn-sm btn-danger" href="{{ route('client.export') }}">
                <i class="fa fa-file-pdf me-2"></i> Export PDF
              </a><br><br> 

              <table class="table table-bordered datatable">
                  <thead>
                      <tr>
                          <th>No.</th>
                          <th>Nama Toko</th>
                          <th>No. Telepon</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if($clients)
                          @foreach($clients as $key => $client)
                              <tr>
                                  <td>{{ ++$key }}</td>
                                  <td><a href="{{ route('client.show', $client->id) }}">{{ $client->nama ?? '' }}</a></td>
                                  <td>{{ $client->no_telepon ?? '' }}</td>
                                  <td>
                                      <a href="{{ route('client.edit', $client->id) }}" class="btn btn-sm btn-outline-primary">
                                          <i class="fa fa-edit me-2"></i>
                                      </a>
                                      <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="client-delete{{ $client->id }}">
                                          <i class="fa fa-solid fa-trash me-2"></i>
                                      </a>
                                      <form id="client-delete{{ $client->id }}" action="{{ route('client.destroy', $client->id) }}" method="POST" style="display:none;">
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
