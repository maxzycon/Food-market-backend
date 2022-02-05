<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Food</title>
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
            <h2>Laporan food</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Modal</th>
                        <th>Laba</th>
                        <th>Rate</th>
                        <th>Types</th>
                        <th>Total Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($food as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>Rp. {{ number_format($item->price) }}</td>
                            <td>Rp. {{ number_format($item->modal) }}</td>
                            <td>Rp. {{ number_format($item->laba) }}</td>
                            <td>{{ $item->rate }} +</td>
                            <td>{{ $item->types }}</td>
                            <td>{{ $item->transaction_sum_quantity ?? 0 }} pcs</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </main>
    </body>
</html>