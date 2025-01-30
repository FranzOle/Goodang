@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Profil Pengguna</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('profiles.show', Auth::user()->id) }}">Profil</a></li>
                    <li class="breadcrumb-item active">Edit Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Bagian Form Update Profil -->
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Perbarui Data Profil</h5><br>
                        <form role="form" action="{{ route('profiles.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Input Nama -->
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="name" type="text" class="form-control" value="{{ $user->name }}" placeholder="Masukkan Nama Lengkap" required>
                                @error('name')
                                <span class="required text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Input Email -->
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control" value="{{ $user->email }}" placeholder="Masukkan Email" required>
                                @error('email')
                                <span class="required text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Input Foto Profil -->
                            <div class="form-group">
                                <label>Foto Profil</label>
                                @if($user->profile_photo_path)
                                    <div class="mb-2">
                                        <img src="{{ $user->profile_photo_url }}" alt="Foto Profil" class="img-circle" style="width: 100px;">
                                    </div>
                                @endif
                                <input name="profile_photo" type="file" class="form-control">
                                @error('profile_photo')
                                <span class="required text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nomor_telepon">Nomor Telepon</label>
                                <input name="nomor_telepon" type="text" class="form-control" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" placeholder="Nomor Telepon">
                                @error('nomor_telepon')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Tombol Submit -->
                            <button type="submit" class="btn btn-primary my-3">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="{{ route('profiles.show', Auth::user()->id) }}" class="btn btn-secondary my-3">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                    </div>
                </div>
            </div>

            <!-- Bagian Form Edit Password -->
            <!-- Bagian Form Edit Password -->
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Edit Password</h5><br>
                        @if(Auth::user()->role != 'admin')
                        <!-- Input Password Lama -->
                        <div class="form-group">
                            <label>Password Sebelumnya</label>
                            <input name="current_password" type="password" class="form-control" placeholder="Masukkan Password Sebelumnya">
                            @error('current_password')
                            <span class="required text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        <!-- Input Password Baru -->
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input name="password" type="password" class="form-control" placeholder="Masukkan Password Baru">
                            @error('password')
                            <span class="required text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Konfirmasi Password Baru -->
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Ulangi Password Baru">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form> <!-- Tutup Form -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPasswordInput = document.querySelector('input[name="current_password"]');
        const newPasswordInput = document.querySelector('input[name="password"]');
        
        newPasswordInput.addEventListener('input', function() {
            if (newPasswordInput.value.trim() !== '') {
                currentPasswordInput.setAttribute('required', 'required');
            } else {
                currentPasswordInput.removeAttribute('required');
            }
        });
    });
</script>
@endsection
