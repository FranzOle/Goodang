<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
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
    <h1>Goodang</h1>
    <h2>Daftar Barang</h2>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Gambar</th>
                <th>Kode SKU</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $key => $item)
                <tr>
                    <td class="center">{{ ++$key }}</td>
                    <td class="center">
                        @if($item->gambar)
                            <img src="{{ public_path('storage/' . $item->gambar) }}" alt="Gambar Barang" class="image">
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td>{{ $item->kode_sku }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->supplier->nama ?? '-' }}</td>
                    <td>{{ $item->deskripsi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
