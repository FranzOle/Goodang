@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Barang dalam Kategori: {{ $kategori->nama }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('staffkategori.index')}}">Kategori</a></li>
            <li class="breadcrumb-item active">Barang</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        @if($barang->isEmpty())
                            <div class="alert alert-warning">
                                Tidak ada barang dalam kategori ini.
                            </div>
                        @else
                            <h5 class="card-title">List Barang</h5><br>
                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Gambar</th>
                                        <th>Kode SKU</th>
                                        <th>Supplier</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->nama ?? '' }}</td>
                                            <td>
                                                @if($item->gambar)
                                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Barang" class="rounded-circle shadow img-fluid" style="width: 75px; height: 75px; object-fit: cover;">
                                                @else
                                                    Tidak ada gambar
                                                @endif
                                            </td>
                                            <td>{{ $item->kode_sku ?? '' }}</td>
                                            <td>{{ $item->supplier->nama ?? '' }}</td>
                                            <td class="harga-barang format-harga" data-harga="{{ $item->harga }}">{{ $item->harga ?? ''}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
