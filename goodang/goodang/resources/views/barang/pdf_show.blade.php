<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }
        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #0084ff;
            color: white;
            font-weight: bold;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .center {
            text-align: center;
        }
        .image {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Detail Barang</h1>
        {{-- <p>Gambar</p>   
        @if($barang->gambar)
        <img src="{{ public_path('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="image">
        @else
        <span>-</span>
        @endif                --}}
        <p>Kode SKU: {{ $barang->kode_sku }}</p>
        <p>Nama: {{ $barang->nama }}</p>
        <p>Kategori: {{ $barang->kategori->nama }}</p>
        <p>Supplier: {{ $barang->supplier->nama }}</p>
    </div>

    <h2>Stok di Gudang</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Gudang</th>
                <th>Kuantitas</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($barang->jumlahstok as $stok)
                <tr>
                    <td>{{ $stok->gudang->nama }}</td>
                    <td>{{ $stok->kuantitas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
