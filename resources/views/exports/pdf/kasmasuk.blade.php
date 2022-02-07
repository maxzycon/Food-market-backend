<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Kas masuk</title>
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
            <h2>Laporan {{!$start && !$end ? "semua" : ""}} kas masuk</h2>
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
                        <th>ID</th>
                        <th>Food</th>
                        <th>User Email</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                        <th>Total Modal</th>
                        <th>Total Laba</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kasmasuk as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->food_price) }}</td>
                            <td>Rp. {{ number_format($item->total_modal) }}</td>
                            <td>Rp. {{ number_format($item->total_laba) }}</td>
                            <td>{{ $item->status }}</td>
                            <td>Rp. {{ number_format($item->total) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="7" style='border: 1px solid #000000;text-align:center;'>Total uang masuk</td>
                        <td style='border: 1px solid #000000;text-align:center'>:</td>
                        <td>Rp. {{ number_format($total) }}</td>
                    </tr>
                </tbody>
            </table>
        </main>
    </body>
</html>