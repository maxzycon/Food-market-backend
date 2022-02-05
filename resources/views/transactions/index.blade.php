<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="bg-white max-w-7xl mx-auto px-4 py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white">

                    <div class="mb-5">
                        <form method="POST" action="{{ route('transaction.export') }}" target="_blank">
                            <select name="status" id="status">
                                <option value="">Download semua status</option>
                                <option {{ request()->post("status") == "ON_DELIVERY" ? "Selected" : "" }} value="ON_DELIVERY">ON_DELIVERY</option>
                                <option {{ request()->post("status") == "DELIVERED" ? "Selected" : "" }} value="DELIVERED">DELIVERED</option>
                                <option {{ request()->post("status") == "CANCELLED" ? "Selected" : "" }} value="CANCELLED">CANCELLED</option>
                            </select>
                            <select name="type" id="type" required>
                                <option value="">- pilih type export -</option>
                                <option value="excel">excel</option>
                                <option value="pdf">pdf</option>
                            </select>
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Download
                            </button>
                        </form>
                    </div>
                    <div class="mb-5">
                        <form method="GET">
                            <input type="text" name="name" value="{{request()->get('name')}}" class="form-control" placeholder="ketik filter nama disini"/>
                            <select name="type" id="type">
                                <option value="">- pilih status -</option>
                                <option {{ request()->get("type") == "ON_DELIVERY" ? "Selected" : "" }} value="ON_DELIVERY">ON_DELIVERY</option>
                                <option {{ request()->get("type") == "DELIVERED" ? "Selected" : "" }} value="DELIVERED">DELIVERED</option>
                                <option {{ request()->get("type") == "CANCELLED" ? "Selected" : "" }} value="CANCELLED">CANCELLED</option>
                            </select>
                            <button type="submit">Filter</button>
                        </form>
                    </div>


                    <table class="table-auto w-full text-center" style="font-size: 12px">
                        <thead>
                            <tr>
                                {{-- <th class="border px-2 py-2">No</th> --}}
                                <th class="border px-2 py-2">ID</th>
                                <th class="border px-2 py-2" width="180px">Food</th>
                                <th class="border px-2 py-2" width="180px">User Email</th>
                                <th class="border px-2 py-2" >Quantity</th>

                                <th class="border px-2 py-2">Harga</th>
                                <th class="border px-2 py-2">Total Modal</th>
                                <th class="border px-2 py-2">Total Laba</th>
                                <th class="border px-2 py-2">Total</th>
                                <th class="border px-2 py-2">Status</th>
                                <th class="border px-2 py-2">Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @forelse($transaction as $item)
                                <tr>
                                    {{-- <td class="border px-6 py-4">{{ $no++ }}</td> --}}
                                    <td class="border px-2 py-2">{{ $item->id }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->name }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->email }}</td>
                                    <td class="border px-2 py-2">{{ $item->quantity }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->food_price) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total_modal) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total_laba) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total) }}</td>
                                    <td class="border px-2 py-2">{{ $item->status }}</td>
                                    <td class="border px-2 py-2 text-center">
                                        <a href="{{ route('transactions.show', $item->id) }}"
                                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            View
                                        </a>
                                        <form action="{{ route('transactions.destroy', $item->id) }}" method="POST"
                                            class="inline-block">
                                            {!! method_field('delete') . csrf_field() !!}
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-2 rounded inline-block">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="border text-center p-5">
                                        Data Tidak Ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-5">
                    {{ $transaction->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
