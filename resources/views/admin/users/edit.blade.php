<x-app-layout>
    <x-slot name="title">Edit Pengguna</x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-2xl font-bold text-white mb-6">Edit Pengguna</h1>

        <form method="POST" action="{{ route('admin.users.update', $user) }}"
            class="bg-gray-900/60 border border-white/5 rounded-2xl p-6 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-400 mb-1.5">Role</label>
                <select name="role" required class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="owner" {{ old('role', $user->role) === 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.users.index') }}" class="flex-1 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 rounded-xl text-sm text-center transition-all">Batal</a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-semibold text-sm">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
