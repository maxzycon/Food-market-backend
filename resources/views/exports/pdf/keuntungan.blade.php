<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Keuntungan</title>
    <link rel="stylesheet" href="./pdf.css">
</head>
    <body>
        <header>
            <img src="./header.png" alt="header" width="100%">
        </header>
        <footer class='ft'>
            <img src="./footer.png" alt="footer" width="100%">
        </footer>
        <main>
            <h2>Laporan keuntungan</h2>
            <table style="margin-bottom:10px">
                <tr>
                    <td width="20%">Tahun</td>
                    <td width="2%" style="text-align:center">:</td>
                    <td>{{$tahun ?? "semua"}}</td>
                </tr>
                <tr>
                    <td width="20%">Bulan</td>
                    <td width="2%" style="text-align:center">:</td>
                    <td>{{$bulan ?? "semua"}}</td>
                </tr>
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
                    <th style='background-color:yellow;' colspan="3">Laba bersih</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total laba kotor</td>
                        <td style="text-align:center">:</td>
                        <td>Rp. {{ number_format($total_laba) }}</td>
                    </tr>
                    <tr>
                        <td>Total Kas Keluar</td>
                        <td style="text-align:center">:</td>
                        <td>- Rp. {{ number_format($total_pengeluaran) }}</td>
                    </tr>
                    <tr>
                        <td>Total Laba Bersih</td>
                        <td style="text-align:center">:</td>
                        <td>Rp. {{ number_format($laba_bersih) }}</td>
                    </tr>
                    <tr>
                        <th style='background-color:yellow;' colspan="3">Kas Masuk</th>
                    </tr>
                    <tr>
                        <td>Produk Terjual</td>
                        <td style="text-align:center">:</td>
                        <td>{{ $quantity }} produk</td>
                    </tr>
                    <tr>
                        <td>Total Uang Masuk</td>
                        <td style="text-align:center">:</td>
                        <td>Rp. {{ number_format($total) }}</td>
                    </tr>
                    <tr>
                        <td>Total Modal</td>
                        <td style="text-align:center">:</td>
                        <td>Rp. {{ number_format($total_modal) }}</td>
                    </tr>
                    <tr>
                        <td>Total Laba Kotor</td>
                        <td style="text-align:center">:</td>
                        <td>Rp. {{ number_format($total_laba) }}</td>
                    </tr>
                    <tr>
                        <th style='background-color:yellow;' colspan="3">Kas Keluar</th>
                    </tr>
                    <tr>
                        <td>Total pembelian</td>
                        <td style="text-align:center">:</td>
                        <td>{{ $jumlah_pembelian }} item</td>
                    </tr>
                    <tr>
                        <td>Total Uang Keluar</td>
                        <td style="text-align:center">:</td>
                        <td>Rp. {{ number_format($total_pengeluaran) }}</td>
                    </tr>
                </tbody>
            </table>
        </main>
    </body>
</html>