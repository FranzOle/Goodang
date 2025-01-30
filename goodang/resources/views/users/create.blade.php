@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Tambah User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Tambah User</h5><br>

                        <form role="form" action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input name="name" type="text" class="form-control" placeholder="Masukkan Username" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Masukkan Password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Konfirmasi Password">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="nomor_telepon">Nomor Telepon</label>
                                    <input id="telepon" name="nomor_telepon" type="text" class="form-control" placeholder="Contoh: 08123456789" value="{{ old('nomor_telepon') }}">
                                    @error('nomor_telepon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    
                                </div>
                                <div id="map" style="height: 300px; width: 100%;"></div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="">Pilih Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales</option>
                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group d-none" id="gudang-container">
                                    <label for="id_gudang">Tugaskan ke Gudang</label>
                                    <select name="id_gudang" class="form-control">
                                        <option value="">Pilih Gudang</option>
                                        @foreach($gudang as $item)
                                            <option value="{{ $item->id }}" {{ old('id_gudang') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_gudang')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="no_goodang">No Goodang</label>
                                    <input name="no_goodang" type="text" class="form-control" placeholder="Masukkan No Goodang (Opsional)" value="{{ old('no_goodang') }}">
                                    @error('no_goodang')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        const gudangContainer = document.getElementById('gudang-container');
        if (role === 'staff') {
            gudangContainer.classList.remove('d-none');
        } else {
            gudangContainer.classList.add('d-none');
        }
    });
</script>
@endsection
