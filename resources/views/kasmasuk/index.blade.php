<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-white max-w-7xl mx-auto px-4 py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">

                    <div class="w-full md:w-5/6 px-4 mb-4 md:mb-0">
                        <div class="flex flex-wrap mb-3">
                            <div class="w-1/6">
                                <div class="text-sm">Produk Terjual</div>
                                <div class="text-xl font-bold">{{ ($kasmasuk->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("quantity")) }} produk</div>
                            </div>
                            <div class="w-3/6">
                                <div class="text-sm">Total Uang Masuk</div>
                                <div class="text-xl font-bold">Rp. {{ number_format($kasmasuk->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total")) }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Total Modal</div>
                                <div class="text-xl font-bold">Rp. {{ number_format($kasmasuk->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total_modal")) }}</div>
                            </div>
                            <div class="w-1/6">
                                <div class="text-sm">Total Laba</div>
                                <div class="text-xl font-bold">Rp. {{ number_format($kasmasuk->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total_laba")) }}</div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-6">

        <div class="bg-white max-w-7xl mx-auto px-4 py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-5">
                <form method="POST" action="{{ route('kasmasuk.export') }}" target="_blank">
                    <input type="date" value="{{request()->get('start')}}" name="start" id="start">
                    <input type="date" value="{{request()->get('end')}}" name="end" id="end">
                    <select name="type" id="type" required>
                        <option value="">- pilih type export -</option>
                        <option value="excel">excel</option>
                        <option value="pdf">pdf</option>
                    </select>
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Download</button>
                </form>
                </div>
                <div class="bg-white">
                    <form class="mb-5">
                        <input type="text" name="name" value="{{request()->get('name')}}" class="form-control" placeholder="ketik filter nama disini"/>
                        <select name="type" id="type">
                            <option value="">- pilih status -</option>
                            <option {{ request()->get("type") == "ON_DELIVERY" ? "Selected" : "" }} value="ON_DELIVERY">ON_DELIVERY</option>
                            <option {{ request()->get("type") == "DELIVERED" ? "Selected" : "" }} value="DELIVERED">DELIVERED</option>
                            <option {{ request()->get("type") == "CANCELLED" ? "Selected" : "" }} value="CANCELLED">CANCELLED</option>
                        </select>
                        <input type="date" value="{{request()->get('start')}}" name="start" id="start">
                        <input type="date" value="{{request()->get('end')}}" name="end" id="end">
                        <button class="ml-2" type="submit">Filter</button>
                    </form>
                    <table class="table-auto w-full text-center" style="font-size: 12px">
                        <thead>
                            <tr>
                                {{-- <th class="border px-2 py-2">No</th> --}}
                                <th class="border px-2 py-2">ID</th>
                                <th class="border px-2 py-2" width="180px">Food</th>
                                <th class="border px-2 py-2" width="180px">User Email</th>
                                <th class="border px-2 py-2">Quantity</th>

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
                            @forelse($kasmasuk as $item)
                                <tr>

                                    {{-- <td class="border px-6 py-4">{{ $no++ }}</td> --}}
                                    <td class="border px-2 py-2">{{ $item->id }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->food->name }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->user->email }}</td>
                                    <td class="border px-2 py-2">{{ $item->quantity }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->food_price) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total_modal) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total_laba) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total) }}</td>
                                    <td class="border px-2 py-2">{{ $item->status }}</td>
                                    <td class="border px-2 py-2 text-center">
                                        <a href="{{ route('kasmasuk.show', $item->id) }}"
                                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            View
                                        </a>

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
                    {{ $kasmasuk->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
