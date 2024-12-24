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
            <div class="col-lg-6">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Perbarui Data User</h5><br>
                        <form role="form" action="{{ route('users.update', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input name="name" type="text" class="form-control" value="{{ $user->name }}" placeholder="Entry Username">
                                    @if($errors->has('name'))
                                        <span class="required text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" class="form-control" value="{{ $user->email }}" placeholder="Entry Email">
                                    @if($errors->has('email'))
                                        <span class="required text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    @if($errors->has('password'))
                                        <span class="required text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                    @if($errors->has('password_confirmation'))
                                        <span class="required text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>

                                @if(Auth::user()->id !== $user->id)
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select id="role" name="role" class="form-control">
                                            <option value="">Pilih Role</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                        @if($errors->has('role'))
                                            <span class="required text-danger">{{ $errors->first('role') }}</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Kolom Gudang -->
                                <div class="form-group {{ $user->role == 'staff' ? '' : 'd-none' }}" id="gudang-container">
                                    <label for="id_gudang">Tugaskan ke Gudang</label>
                                    <select name="id_gudang" class="form-control">
                                        <option value="">Pilih Gudang</option>
                                        @foreach($gudang as $item)
                                            <option value="{{ $item->id }}" {{ $user->id_gudang == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('id_gudang'))
                                        <span class="required text-danger">{{ $errors->first('id_gudang') }}</span>
                                    @endif
                                </div>

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
