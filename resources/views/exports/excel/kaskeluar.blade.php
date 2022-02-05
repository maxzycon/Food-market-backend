<table>
    <thead>
        <tr>
            <th style='border: 1px solid #000000;'>No</th>
            <th style='border: 1px solid #000000;'>ID</th>
            <th style='border: 1px solid #000000;'>Nama</th>
            <th style='border: 1px solid #000000;'>Jenis Pengeluaran</th>
            <th style='border: 1px solid #000000;'>Supplier</th>
            <th style='border: 1px solid #000000;'>Tanggal</th>
            <th style='border: 1px solid #000000;'>Quantity</th>
            <th style='border: 1px solid #000000;'>Harga</th>
            <th style='border: 1px solid #000000;'>Total</th>
        </tr>
    </thead>
    @php
        $no = 1;
    @endphp
    <tbody>
        @foreach($kaskeluar as $item)
            <tr>
                <td style='border: 1px solid #000000;'>{{ $no++ }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->id }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->name }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->jenis_pengeluaran }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->supplier }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->tanggal }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->quantity }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->harga) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>