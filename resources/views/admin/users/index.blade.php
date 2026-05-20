<x-app-layout>
    <x-slot name="title">Kelola Pengguna</x-slot>
    <div class="flex">
        <x-sidebar section="admin" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="section-label">Admin Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Kelola Pengguna</h1>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" class="flex flex-wrap gap-3 mb-6">
                <div
                    class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-primary flex-1 min-w-48 bg-white">
                    <x-icon name="search" class="w-4 h-4 text-gray-400 shrink-0" />
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="flex-1 text-sm outline-none bg-transparent text-gray-700 placeholder-gray-400">
                </div>
                <select name="role"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent outline-none bg-white">
                    <option value="">Semua Role</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                <button type="submit" class="btn-primary py-2 px-4 text-sm">
                    <x-icon name="filter" class="w-4 h-4" />
                    Filter
                </button>
            </form>

            <div class="card overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-field bg-accent">
                            <th class="text-left px-5 py-3 ">Pengguna</th>
                            <th class="text-left px-5 py-3 ">Email</th>
                            <th class="text-left px-5 py-3  hidden md:table-cell">Telepon</th>
                            <th class="text-left px-5 py-3 ">Role</th>
                            <th class="text-left px-5 py-3  hidden sm:table-cell">Bergabung</th>
                            <th class="text-left px-5 py-3 ">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-field">
                        @foreach ($users as $user)
                            @php
                                $roleColors = [
                                    'user' => 'bg-gray-100 text-gray-600',
                                    'owner' => 'bg-blue-50 text-blue-600',
                                    'admin' => 'bg-primary-light text-primary',
                                ];
                            @endphp
                            <tr class="hover:bg-accent transition-colors">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-primary-light flex items-center justify-center text-xs font-bold text-primary shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-gray-900 text-xs">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-500">{{ $user->email }}</td>
                                <td class="px-5 py-3 text-xs text-gray-400 hidden md:table-cell">
                                    {{ $user->phone ?? '—' }}</td>
                                <td class="px-5 py-3">
                                    <span
                                        class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $roleColors[$user->role] ?? '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-400 hidden sm:table-cell">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-1.5">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="p-1.5 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                                            <x-icon name="pencil" class="w-4 h-4" />
                                        </a>
                                        @if ($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                x-data
                                                x-on:submit.prevent="if(confirm('Hapus pengguna ini?')) $el.submit()">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                                    <x-icon name="trash" class="w-4 h-4" />
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
            <div class="mt-6">{{ $users->links() }}</div>
        </main>
    </div>
</x-app-layout>
