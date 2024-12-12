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
            
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Gudang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users)
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name ?? '' }}</td>
                                <td>{{ $user->email ?? '' }} @if(auth()->id() == $user->id) (Anda) @endif</td>
                                <td>{{ ucfirst($user->role) ?? '' }}</td>
                                <td>
                                    @if($user->role === 'staff')
                                        {{ $user->gudang->nama ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-edit me-2"></i> Edit
                                    </a>
                                    @if(auth()->id() != $user->id)
                                    <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="users-delete{{ $user->id }}" method="post">
                                        <i class="fa fa-solid fa-trash me-2"></i> Hapus
                                    </a>
                                    <form id="users-delete{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
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
