@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Klien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Klien</a></li>
                    <li class="breadcrumb-item active">Detail Klien</li>
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
                        <h5>Informasi Klien</h5>
                        <table class="table">
                            <tr>
                                <th>Nama Toko</th>
                                <td>{{ $client->nama }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $client->no_telepon }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $client->email }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $client->alamat }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('client.index') }}" class="btn btn-secondary mt-3">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection