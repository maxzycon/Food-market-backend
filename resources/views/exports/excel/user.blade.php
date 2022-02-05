<table>
    <thead>
        <tr>
            <th style='border: 1px solid #000000;'>No</th>
            <th style='border: 1px solid #000000;'>ID</th>
            <th style='border: 1px solid #000000;'>Name</th>
            <th style='border: 1px solid #000000;'>Email</th>
            <th style='border: 1px solid #000000;'>Roles</th>
            <th style='border: 1px solid #000000;'>Total Transaksi</th>
        </tr>
    </thead>
    @php
        $no = 1;
    @endphp
    <tbody>
        @foreach($user as $item)
            <tr>
                <td style='border: 1px solid #000000;'>{{ $no++ }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->id }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->name }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->email }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->roles }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->transaction_sum_total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>