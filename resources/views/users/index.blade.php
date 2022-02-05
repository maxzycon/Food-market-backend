<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  text-gray-800 leading-tight">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('users.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Create User
                </a>

                <form class="mt-5" method="POST" action="{{ route('users.export') }}" target="_blank">
                    <select name="roles1" id="roles1">
                        <option value="">- download semua role -</option>
                        <option value="admin">admin</option>
                        <option value="user">user</option>
                    </select>
                    <select name="type" id="type" required>
                        <option value="">- pilih type export -</option>
                        <option value="excel">excel</option>
                        <option value="pdf">pdf</option>
                    </select>
                    @csrf
                    <button type="submit">Download</button>
                </form>

                <form class="mt-5">
                    <input type="text" name="name" value="{{request()->get('name')}}" class="form-control" placeholder="ketik filter nama disini"/>
                    <select name="roles" id="roles">
                        <option value="">- pilih role -</option>
                        <option {{ request()->get("roles") == "admin" ? "selected" : "" }} value="admin">admin</option>
                        <option {{ request()->get("roles") == "user" ? "selected" : "" }} value="user">user</option>
                    </select>
                    <button type="submit">Filter</button>
                </form>
            </div>
            <div class="bg-white max-w-7xl mx-auto px-4 py-10">
                <div class="bg-white">
                    <table class="table-auto w-full" style="font-size: 11px">
                        <thead>
                            <tr>
                                <th class="border px-3 py-4" width="60px">No</th>
                                <th class="border px-3 py-4" width="60px">ID</th>
                                <th class="border px-2 py-4" width="100px">Photo</th>
                                <th class="border px-2 py-4" width="200px">Name</th>
                                <th class="border px-2 py-4">Email</th>
                                <th class="border px-2 py-4">Roles</th>
                                <th class="border px-2 py-4">Total Transaksi</th>
                                <th class="border px-2 py-4" width="200px">Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @forelse($user as $item)
                                <tr class="text-center">
                                    <td class="border px-2 py-2">{{ $no++ }}</td>
                                    <td class="border px-2 py-2">{{ $item->id }}</td>


                                    <td class="border px-2 py-2 object-center">

                                        <img src="{{ Storage::url($item->profile_photo_path) }}"
                                            class="w-30 rounded-md">


                                    </td>
                                    <td class="border px-2 py-2 ">{{ $item->name }}</td>
                                    <td class="border px-2 py-2">{{ $item->email }}</td>
                                    <td class="border px-2 py-2 text-center">{{ $item->roles }}</td>
                                    <td class="border px-2 py-2">Rp. {{ number_format($item->transaction_sum_total) }}</td>
                                    <td class="border px-2 py-2 text-center">
                                        <a href="{{ route('users.edit', $item->id) }}"
                                            class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-2 rounded">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('users.destroy', $item->id) }}" method="POST"
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
                                    <td colspan="6" class="border text-center p-5">
                                        Data Tidak Ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-5">
                    {{ $user->links() }}
                </div>
            </div>



        </div>
    </div>
</x-app-layout>
