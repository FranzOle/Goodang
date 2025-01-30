<html>
    <table>
        <thead>
            <tr style="background-color: #4CAF50; color: white; font-weight: bold; text-align: center;">
                <th colspan="6" style="font-size: 16px; border: 1px solid black;">Laporan Kartu Stok Barang</th>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid black;">Nama Barang:</td>
                <td style="border: 1px solid black;">{{ $barang->nama }}</td>
                <td colspan="4" style="border: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid black;">Kode Barang:</td>
                <td style="border: 1px solid black;">{{ $barang->kode_sku }}</td>
                <td colspan="4" style="border: 1px solid black;"></td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px solid black;">Lokasi:</td>
                <td style="border: 1px solid black;">{{ $gudang->nama }}</td>
                <td colspan="4" style="border: 1px solid black;"></td>
            </tr>
            <tr style="background-color: #87CEEB; font-weight: bold; text-align: center;">
                <th style="border: 1px solid black;">Tanggal</th>
                <th style="border: 1px solid black;">Type</th>
                <th style="border: 1px solid black;">Kuantitas</th>
                <th style="border: 1px solid black;">Deskripsi</th>
                <th style="border: 1px solid black;">Penanggung Jawab</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kartuStok as $stok)
                <tr style="text-align: center;">
                    <td style="border: 1px solid black;">{{ $stok->created_at->format('d-m-Y') }}</td>
                    <td style="border: 1px solid black;">{{ $stok->transaksi->stock_type == 'in' ? 'Masuk' : ($stok->transaksi->stock_type == 'out' ? 'Keluar' : '-') }}</td>
                    <td style="border: 1px solid black;">
                        {{ $stok->transaksi->stock_type == 'in' ? $stok->kuantitas : ($stok->transaksi->stock_type == 'out' ? $stok->kuantitas : 0) }}
                    </td>
                    <td style="border: 1px solid black;">{{ $stok->transaksi->deskripsi_tujuan ?? '-' }}</td>
                    <td style="border: 1px solid black;">{{ $stok->transaksi->id_user->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</html>
