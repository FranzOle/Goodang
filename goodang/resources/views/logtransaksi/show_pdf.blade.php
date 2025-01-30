<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Detail Transaksi: {{ $transaksi->kode_referensi }}</h1>
    <table>
        <tr>
            <th>Tanggal</th>
            <td>{{ $transaksi->tanggal }}</td>
        </tr>
        <tr>
            <th>Gudang</th>
            <td>{{ $transaksi->gudang->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>User</th>
            <td>{{ $transaksi->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $transaksi->deskripsi_tujuan }}</td>
        </tr>
    </table>

    <h3>Detail Barang</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->transaksidetail as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $detail->barang->nama ?? '-' }}</td>
                    <td>{{ $detail->kuantitas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
