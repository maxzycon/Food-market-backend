<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kas keluar</title>
    <link rel="stylesheet" href="./pdf.css">
</head>
    <body>
        <header>
            <img src="./header.png" alt="header" width="100%">
        </header>
        <footer>
            <img src="./footer.png" alt="footer" width="100%">
        </footer>
        <main>
            <h2>Laporan {{$type !== '' && !empty($type) ? strtolower($type) : "semua"}} kas keluar</h2>
            <table style="margin-bottom:10px">
                <tr>
                    <td width="20%">Tanggal start</td>
                    <td width="2%" style="text-align:center">:</td>
                    <td>{{$start ?? "-"}}</td>
                </tr>
                <tr>
                    <td width="20%">Tanggal end</td>
                    <td width="2%" style="text-align:center">:</td>
                    <td>{{$end ?? "-"}}</td>
                </tr>
            </table>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jenis Pengeluaran</th>
                        <th>Supplier</th>
                        <th>Tanggal</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr> 
                </thead>
                @php
                    $no = 1;
                @endphp
                <tbody>
                    @foreach($kaskeluar as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->jenis_pengeluaran }}</td>
                            <td>{{ $item->supplier }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->harga) }}</td>
                            <td>Rp. {{ number_format($item->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </body>
</html>