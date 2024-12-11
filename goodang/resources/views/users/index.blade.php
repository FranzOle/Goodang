@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Kelola Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">List Users</li>
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
              <h5 class="card-title">List users</h5><br>
              <a class="btn btn-sm btn-primary me-4" href="{{ route('users.create') }}">
                <i class="fa fa-solid fa-plus me-2"></i> Tambah User
            </a><br><br>
            {{-- <a class="btn btn-sm btn-danger" href="{{ route('users.export') }}">
              <i class="fa fa-file-pdf me-2"></i> Export PDF
          </a><br><br>  --}}
            
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users)
                        @foreach($users as $key => $users)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $users->name ?? '' }}</td>
                                <td>{{ $users->email ?? '' }} @if(auth()->id() == $users->id) (Anda) @endif</td>
                                <td>{{ $users->role ?? '' }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $users->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit me-2"></i> Edit
                                    </a>
                                    @if(auth()->id() != $users->id)
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="users-delete{{ $users->id }}" method="post">
                                        <i class="fa fa-solid fa-trash me-2"></i> Hapus
                                    </a>
                                    <form id="users-delete{{ $users->id }}" action="{{ route('users.destroy', $users->id) }}" method="POST" style="display:none;">
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