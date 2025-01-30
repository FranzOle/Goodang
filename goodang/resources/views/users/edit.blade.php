@extends('layouts.master')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Perbarui Data User</h5><br>
                        <form role="form" action="{{ route('users.update', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Username -->
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Entry Username">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="Entry Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Role -->
                                @if(Auth::user()->id !== $user->id)
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select id="role" name="role" class="form-control">
                                            <option value="">Pilih Role</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                            <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales</option>
                                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="no_goodang">No Goodang</label>
                                    <input name="no_goodang" type="text" class="form-control" placeholder="Masukkan No Goodang (Opsional)" value="{{ old('no_goodang') }}">
                                    @error('no_goodang')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Gudang -->
                                <div class="form-group {{ old('role', $user->role) == 'staff' ? '' : 'd-none' }}" id="gudang-container">
                                    <label for="id_gudang">Tugaskan ke Gudang</label>
                                    <select name="id_gudang" class="form-control">
                                        <option value="">Pilih Gudang</option>
                                        @foreach($gudang as $item)
                                            <option value="{{ $item->id }}" {{ old('id_gudang', $user->id_gudang) == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_gudang')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="form-group">
                                    <label for="nomor_telepon">Nomor Telepon</label>
                                    <input id="telepon" name="nomor_telepon" type="text" class="form-control" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" placeholder="Nomor Telepon">
                                    @error('nomor_telepon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Alamat -->
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
                                <a href="{{ route('users.index') }}" class="btn btn-secondary my-3">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mengatur visibilitas dropdown gudang
    document.getElementById('role')?.addEventListener('change', function () {
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
