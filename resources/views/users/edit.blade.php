<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Role User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama User</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email (Hanya Baca)</label>
                        <input type="email" value="{{ $user->email }}" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-gray-500 shadow-sm">
                    </div>

                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role / Hak Akses</label>
                        <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>USER (Hanya Tambah Observasi)</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>ADMIN (Full Akses Master Data)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-md transition">
                            Update Role
                        </button>
                        <a href="{{ route('users.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>