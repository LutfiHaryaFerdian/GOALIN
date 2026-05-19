<x-app-layout>
    <x-slot name="title">Edit Pengguna</x-slot>
    <div class="flex">
        <x-sidebar section="admin" />
        <main class="flex-1 min-w-0 py-8 px-4 sm:px-8">
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('admin.users.index') }}"
                   class="p-2 rounded-lg hover:bg-primary-light text-gray-400 hover:text-primary transition-colors">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div>
                    <p class="section-label">Admin Panel</p>
                    <h1 class="text-2xl font-extrabold text-gray-900">Edit Pengguna</h1>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}"
                  class="card p-6 space-y-5 max-w-xl">
                @csrf
                @method('PATCH')

                <div>
                    <label class="label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="input" required>
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">No. Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="input" placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label">Role</label>
                    <select name="role" class="input" required>
                        <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>User</option>
                        <option value="owner" {{ old('role', $user->role) === 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3 pt-2 border-t border-field">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary flex-1 justify-center">Batal</a>
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        <x-icon name="check" class="w-4 h-4" />
                        Simpan
                    </button>
                </div>
            </form>
        </main>
    </div>
</x-app-layout>
