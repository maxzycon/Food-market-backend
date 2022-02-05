<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Food') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('food.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create Food
                </a>


                <a href="{{ route('food.excel') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    Download excel
                </a>

                <a href="{{ route('food.pdf') }}"
                    target="_blank"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">
                    Download pdf
                </a>

                <form class="mt-5">
                    <input type="text" name="name" value="{{request()->get('name')}}" class="form-control" placeholder="ketik filter nama disini"/>
                    <input type="text" name="type" value="{{request()->get('type')}}" class="form-control" placeholder="ketik filter type disini"/>
                    <button type="submit">Filter</button>
                </form>
            </div>

            <div class="bg-white max-w-7xl mx-auto px-4 py-10">
                <div class="bg-white">
                    <table class="table-auto w-full text-center" style="font-size: 11px">
                        <thead>
                            <tr>
                                {{-- <th class="border px-6 py-4">No</th> --}}
                                <th class="border px-3 py-4">ID</th>
                                <th class="border px-2 py-2" width="130px">Photo</th>

                                <th class="border px-2 py-2">Name</th>
                                {{-- <th class="border px-6 py-4">Ingredients</th> --}}

                                {{-- <th class="border px-6 py-4">Description</th> --}}
                                <th class="border px-2 py-2">Price</th>
                                <th class="border px-2 py-2">Modal</th>
                                <th class="border px-2 py-2">Laba</th>
                                <th class="border px-2 py-2">Rate</th>
                                <th class="border px-2 py-2">Types</th>
                                <th class="border px-2 py-2">Total Terjual</th>
                                <th class="border px-2 py-2" width="200px">Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @forelse($food as $item)
                                <tr>
                                    {{-- <td class="border px-6 py-4">{{ $no++ }}</td> --}}
                                    <td class="border px-1 py-1">{{ $item->id }}</td>


                                    <td class="border px-2 py-2 object-center">

                                        <img src="{{ $item->picturePath }}" class="w-48 rounded-md">


                                    </td>
                                    <td class="border px-2 py-2 ">{{ $item->name }}</td>
                                    {{-- <td class="border px-6 py-4 ">{{ $item->ingredients }}</td> --}}
                                    {{-- <td class="border px-6 py-4 ">{{ $item->description }}</td> --}}
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->price) }}</td>

                                    <td class="border px-2 py-2">Rp. {{ number_format($item->modal) }}</td>

                                    <td class="border px-2 py-2">Rp. {{ number_format($item->laba) }}</td>
                                    <td class="border px-2 py-2">{{ $item->rate }} +</td>
                                    <td class="border px-2 py-2">{{ $item->types }}</td>

                                    <td class="border px-2 py-2">{{ $item->transaction_sum_quantity ?? 0 }} pcs</td>
                                    <td class="border">
                                        <a href="{{ route('food.show', $item->id) }}"
                                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            Detail
                                        </a>
                                        <form action="{{ route('food.destroy', $item->id) }}" method="POST"
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
                    {{ $food->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
