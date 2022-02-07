<table>
                
    <thead>
        <tr>
            <td  style='border: 1px solid #000000;' colspan="6" width="20%">Tanggal start</td>
            <td width="2%" style="text-align:center;border: 1px solid #000000;">:</td>
            <td  style='border: 1px solid #000000;' colspan="2" >{{$start ?? "-"}}</td>
        </tr>
        <tr>
            <td  style='border: 1px solid #000000;' colspan="6" width="20%">Tanggal end</td>
            <td width="2%" style="text-align:center;border: 1px solid #000000;">:</td>
            <td  style='border: 1px solid #000000;' colspan="2" >{{$end ?? "-"}}</td>
        </tr>
        <tr>
            <th style='border: 1px solid #000000;'>ID</th>
            <th style='border: 1px solid #000000;'>Food</th>
            <th style='border: 1px solid #000000;'>User Email</th>
            <th style='border: 1px solid #000000;'>Quantity</th>
            <th style='border: 1px solid #000000;'>Harga</th>
            <th style='border: 1px solid #000000;'>Total Modal</th>
            <th style='border: 1px solid #000000;'>Total Laba</th>
            <th style='border: 1px solid #000000;'>Status</th>
            <th style='border: 1px solid #000000;'>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kasmasuk as $item)
            <tr>
                <td style='border: 1px solid #000000;'>{{ $item->id }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->name }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->email }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->quantity }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->food_price) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total_modal) }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total_laba) }}</td>
                <td style='border: 1px solid #000000;'>{{ $item->status }}</td>
                <td style='border: 1px solid #000000;'>Rp. {{ number_format($item->total) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7" style='border: 1px solid #000000;text-align:center;'>Total uang masuk</td>
            <td style='border: 1px solid #000000;text-align:center'>:</td>
            <td style='border: 1px solid #000000;'>Rp. {{ number_format($total) }}</td>
        </tr>
    </tbody>
</table>