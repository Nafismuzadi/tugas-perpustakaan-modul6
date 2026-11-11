@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200/80 p-6">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Kelola Pengguna & Role</h1>
                    <p class="text-sm text-gray-500 mt-1">Daftar seluruh pengguna dan penetapan hak akses sistem.</p>
                </div>
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 text-sm rounded-lg border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Pesan Error -->
            @if(session('error'))
                <div class="mb-4 p-3 bg-rose-50 text-rose-700 text-sm rounded-lg border border-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Role Saat Ini</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @foreach ($users as $u)
                            <tr class="hover:bg-gray-50/50 transition border-b border-gray-100">
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $u->name }}</td>
                                <td class="py-3 px-4">{{ $u->email }}</td>
                                <td class="py-3 px-4">
                                    @foreach($u->getRoleNames() as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $role }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.users.edit', $u->id) }}" class="text-amber-600 hover:text-amber-800 text-xs font-semibold">
                                            Ubah Role
                                        </a>

                                        @if($u->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $u->name }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection