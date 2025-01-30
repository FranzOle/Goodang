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
            <li class="breadcrumb-item"><a href="{{route('kategori.index')}}">Kategori</a></li>
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
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td><a href="{{ route('barang.show', $item->id) }}">{{ $item->nama ?? '' }}</a></td>
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
                                            <td>
                                                <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-edit me-2"></i> Edit
                                                </a>
                                                <a href="javascript:;" class="btn btn-sm btn-outline-danger sa-delete" data-form-id="barang-delete{{ $item->id }}" method="post">
                                                    <i class="fa fa-solid fa-trash me-2"></i> Hapus
                                                </a>
                                                <form id="barang-delete{{ $item->id }}" action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>                                      
                                            </td>
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
