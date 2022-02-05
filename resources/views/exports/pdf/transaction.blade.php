<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Transaction</title>
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
            <h2>Laporan {{ strtolower($status) ?? "semua" }} transaction</h2>
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
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->food_price) }}</td>
                            <td>Rp. {{ number_format($item->total_modal) }}</td>
                            <td>Rp. {{ number_format($item->total_laba) }}</td>
                            <td>Rp. {{ number_format($item->total) }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </main>
    </body>
</html>