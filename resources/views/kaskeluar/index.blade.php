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
                                <div class="text-sm">Total Pembelian</div>
                                <div class="text-xl font-bold">{{ $kaskeluar->sum("quantity") }} item</div>
                            </div>
                            <div class="w-3/6">
                                <div class="text-sm">Total Uang Keluar</div>
                                <div class="text-xl font-bold">Rp. {{ number_format($kaskeluar->sum("total")) }}</div>
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
                <div class="mb-10">
                    <a href="{{ route('kaskeluar.create') }}"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        + Add Data
                    </a>

                    <form class="mt-5" action="{{route('kaskeluar.export')}}" method="POST" target="_blank">
                        @csrf
                        <select name="type1" id="type1">
                            <option value="">- semua jenis pengeluaran -</option>
                            <option {{ request()->post("type1") == "Produk" ? "Selected" : "" }} value="Produk">Produk</option>
                            <option {{ request()->post("type1") == "Utility" ? "Selected" : "" }} value="Utility">Utility</option>
                            <option {{ request()->post("type1") == "Operasional" ? "Selected" : "" }} value="Operasional">Operasional</option>
                            <option {{ request()->post("type1") == "Retribusi" ? "Selected" : "" }} value="Retribusi">Retribusi</option>
                            <option {{ request()->post("type1") == "Pemeliharaan" ? "Selected" : "" }} value="Pemeliharaan">Pemeliharaan</option>
                        </select>
                        <input type="date" name="start" id="start">
                        <input type="date" name="end" id="end">
                        <select name="type2" id="type" required>
                            <option value="">- pilih type export -</option>
                            <option value="excel">excel</option>
                            <option value="pdf">pdf</option>
                        </select>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">Download</button>
                    </form>

                    <form class="mt-5">
                        <input type="text" name="name" value="{{request()->get('name')}}" class="form-control" placeholder="ketik filter nama disini"/>
                        <select name="type" id="type">
                            <option value="">- pilih jenis pengeluaran -</option>
                            <option {{ request()->get("type") == "Produk" ? "Selected" : "" }} value="Produk">Produk</option>
                            <option {{ request()->get("type") == "Utility" ? "Selected" : "" }} value="Utility">Utility</option>
                            <option {{ request()->get("type") == "Operasional" ? "Selected" : "" }} value="Operasional">Operasional</option>
                            <option {{ request()->get("type") == "Retribusi" ? "Selected" : "" }} value="Retribusi">Retribusi</option>
                            <option {{ request()->get("type") == "Pemeliharaan" ? "Selected" : "" }} value="Pemeliharaan">Pemeliharaan</option>
                        </select>
                        <input type="date" name="start" id="start" value="{{request()->get('start')}}">
                        <input type="date" name="end" id="end" value="{{request()->get('end')}}">
                        <button class="ml-2" type="submit">Filter</button>
                    </form>
                </div>
                <div class="bg-white">
                    <table class="table-auto w-full text-center" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th class="border px-2 py-2">No</th>
                                <th class="border px-2 py-2">ID</th>
                                <th class="border px-2 py-2" width="180px">Nama</th>
                                <th class="border px-2 py-2" width="180px">Jenis Pengeluaran</th>
                                <th class="border px-2 py-2">Supplier</th>
                                <th class="border px-2 py-2" width="100px">Tanggal</th>

                                <th class="border px-2 py-2" width="50px">Quantity</th>
                                <th class="border px-2 py-2">Harga</th>
                                <th class="border px-2 py-2">Total</th>
                                <th class="border px-2 py-2">Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @forelse($kaskeluar as $item)
                                <tr>

                                    <td class="border px-6 py-4">{{ $no++ }}</td>
                                    <td class="border px-2 py-2">{{ $item->id }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->name }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->jenis_pengeluaran }}</td>


                                    <td class="border px-2 py-2 ">{{ $item->supplier }}</td>
                                    <td class="border px-2 py-2 ">{{ $item->tanggal }}</td>
                                    <td class="border px-2 py-2">{{ $item->quantity }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->harga) }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->total) }}</td>
                                    <td class="border px-2 py-2 text-center">
                                        <a href="{{ route('kaskeluar.edit', $item->id) }}"
                                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('kaskeluar.destroy', $item->id) }}" method="POST"
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
                    {{ $kaskeluar->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
