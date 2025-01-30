@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Detail Pengguna</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="mb-4">Informasi Pengguna</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Foto Profil</th>
                                <td>
                                    <img src="{{ $user->profile_photo_url ?? asset('images/default-user.png') }}" 
                                         alt="Foto Profil" class="img-circle" width="100">
                                </td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ ucfirst($user->role) }}</td>
                            </tr>
                            @if($user->role === 'staff')
                                <tr>
                                    <th>Gudang Ditugaskan</th>
                                    <td>{{ $user->gudang->nama ?? 'Tidak Ada' }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $user->nomor_telepon }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $user->alamat }}</td>
                            </tr>
                        </table>
                        <div class="mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
