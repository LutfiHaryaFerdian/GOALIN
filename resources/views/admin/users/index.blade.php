<x-app-layout>
    <x-slot name="title">Kelola Pengguna</x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">Kelola Pengguna</h1>
        </div>

        <!-- Filters -->
        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..."
                class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 flex-1 min-w-48">
            <select name="role" class="px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="">Semua Role</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-lg text-sm hover:bg-emerald-500/20 transition-all">Filter</button>
        </form>

        <div class="bg-gray-900/60 border border-white/5 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Pengguna</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Email</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Telepon</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Role</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Bergabung</th>
                            <th class="text-left px-5 py-3 text-xs text-gray-500 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($users as $user)
                            @php
                                $roleColors = ['user' => 'text-gray-400 bg-gray-500/10 border-gray-500/20','owner' => 'text-blue-400 bg-blue-500/10 border-blue-500/20','admin' => 'text-purple-400 bg-purple-500/10 border-purple-500/20'];
                            @endphp
                            <tr class="hover:bg-white/2 transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center text-xs font-bold text-white">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-white text-xs">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-400 text-xs">{{ $user->email }}</td>
                                <td class="px-5 py-3 text-gray-500 text-xs">{{ $user->phone ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 rounded-full border text-[10px] font-medium {{ $roleColors[$user->role] ?? '' }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="px-2.5 py-1 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-400 hover:text-white rounded-lg text-[11px] transition-all">Edit</a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                x-data x-on:submit.prevent="if(confirm('Hapus pengguna ini?')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 rounded-lg text-[11px] transition-all">Hapus</button>
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
        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</x-app-layout>
