<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $isEdit ? 'Edit User' : 'Create User' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ $isEdit ? route('users.update', $user->id) : route('users.store') }}">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}" required
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300" />
                    </div>

                    @if ($isEdit)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password
                                (optional)</label>
                            <input name="password" type="password"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New
                                Password</label>
                            <input name="password_confirmation" type="password"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300" />
                        </div>
                    @else
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input name="password" type="password" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm
                                Password</label>
                            <input name="password_confirmation" type="password" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300" />
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="role" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300">
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected($user->roles->first()?->name === $role->name)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        {{ $isEdit ? 'Update' : 'Create' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
