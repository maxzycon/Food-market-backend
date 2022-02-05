<table>
    <thead>
        <tr>
            <th style='border: 1px solid #000000;'>ID</th>
            <th style='border: 1px solid #000000;'>Name</th>
            <th style='border: 1px solid #000000;'>Price</th>
            <th style='border: 1px solid #000000;'>Modal</th>
            <th style='border: 1px solid #000000;'>Laba</th>
            <th style='border: 1px solid #000000;'>Rate</th>
            <th style='border: 1px solid #000000;'>Types</th>
            <th style='border: 1px solid #000000;'>Total Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach($food as $item)
            <tr>
                <td style='border: 1px solid #000000;'>{{ $item->id }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->name }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->price) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->modal) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->laba) }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->rate }} +</td>
                <td style='border: 1px solid #000000;'>{{ $item->types }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->transaction_sum_quantity ?? 0 }} pcs</td>
            </tr>
        @endforeach
    </tbody>
</table>