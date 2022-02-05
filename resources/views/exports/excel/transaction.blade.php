<table>
    <thead>
        <tr>
            <th style='border: 1px solid #000000;'>ID</th>
            <th style='border: 1px solid #000000;'>Food</th>
            <th style='border: 1px solid #000000;'>User Email</th>
            <th style='border: 1px solid #000000;'>Quantity</th>
            <th style='border: 1px solid #000000;'>Harga</th>
            <th style='border: 1px solid #000000;'>Total Modal</th>
            <th style='border: 1px solid #000000;'>Total Laba</th>
            <th style='border: 1px solid #000000;'>Total</th>
            <th style='border: 1px solid #000000;'>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaction as $item)
            <tr>
                <td style='border: 1px solid #000000;'>{{ $item->id }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->name }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->email }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->quantity }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->food_price) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total_modal) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total_laba) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total) }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->status }}</td>
            </tr>
            @endforeach
    </tbody>
</table>