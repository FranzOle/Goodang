@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Profil Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Profil</li>
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
                        <h5>Informasi Pengguna</h5>
                        <table class="table">
                            <tr>
                                <th>Foto Profil</th>
                                <td>
                                    <img src="{{ $user->profile_photo_url }}" alt="Foto Profil" class="img-circle" width="100">
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
                            <tr>
                                @if(Auth::user()->role === 'staff')
                                <th>Ditugaskan digudang:</th>
                                <td>{{ $user->gudang->nama }}</td>
                            @endif
                            </tr>
                        </table>
                        <a href="{{ route('profiles.edit', Auth::user()->id) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
