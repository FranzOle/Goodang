<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log Transaksi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Log Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Referensi</th>
                <th>Tanggal</th>
                <th>Gudang</th>
                <th>User</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->kode_referensi }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->gudang->nama ?? '-' }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->deskripsi_tujuan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
