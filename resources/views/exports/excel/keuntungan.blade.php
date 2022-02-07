<table>
    <thead>
        <tr>
            <td>Tahun</td>
            <td style="text-align:center">:</td>
            <td>{{$tahun ?? "semua"}}</td>
        </tr>
        <tr>
            <td>Bulan</td>
            <td style="text-align:center">:</td>
            <td>{{$bulan ?? "semua"}}</td>
        </tr>
        <tr>
            <td>Tanggal start</td>
            <td style="text-align:center">:</td>
            <td>{{$start ?? "-"}}</td>
        </tr>
        <tr>
            <td>Tanggal end</td>
            <td style="text-align:center">:</td>
            <td>{{$end ?? "-"}}</td>
        </tr>
    <tr>
        <th style='background-color:yellow;' colspan="3">Laba bersih</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style='border: 1px solid #000000;'>Total laba kotor</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($total_laba) }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total Kas Keluar</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>- Rp. {{ number_format($total_pengeluaran) }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total Laba Bersih</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($laba_bersih) }}</td>
        </tr>
        <tr>
            <th style='background-color:yellow;' colspan="3">Kas Masuk</th>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Produk Terjual</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>{{ $quantity }} produk</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total Uang Masuk</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($total) }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total Modal</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($total_modal) }}</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total Laba Kotor</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($total_laba) }}</td>
        </tr>
        <tr>
            <th style='background-color:yellow;' colspan="3">Kas Keluar</th>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total pembelian</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>{{ $jumlah_pembelian }} item</td>
        </tr>
        <tr>
            <td style='border: 1px solid #000000;'>Total Uang Keluar</td>
            <td style='border: 1px solid #000000;'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($total_pengeluaran) }}</td>
        </tr>
    </tbody>
</table>