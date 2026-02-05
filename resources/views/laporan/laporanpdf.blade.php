<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Peminjaman</h3>
    <p>Periode: {{ request('from') }} s.d {{ request('to') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $p)
            <tr>
                <td>{{ $p->user->nama }}</td>
                <td>{{ $p->buku->judul }}</td>
                <td>{{ $p->jumlah }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_jatuh_tempo }}</td>
                <td>{{ $p->tanggal_kembali ?? '-' }}</td>
                <td>{{ ucfirst($p->status) }}</td>
                <td>Rp{{ number_format($p->denda, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
