<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Job Categories {{ request('archived') === 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast_notifactios />

        <div class="flex justify-end items-center space-x-4">
            @if (request('archived') === 'true')
                <!---Active categories button-->
                <a href="{{ route('job_categories.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Active') }}
                </a>
            @else
                <!---Archived categories button-->
                <a href="{{ route('job_categories.index', ['archived' => 'true']) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Archived') }}
                </a>
            @endif
            
            <!-- Add Category Button -->
            <a href="{{ route('job_categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Category') }}
            </a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Category Name
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request('archived') === 'true')
                                    <form action="{{ route('job_categories.restore', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>
                                @else 
                                    <a href="{{ route('job_categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a>
                                    <form action="{{ route('job_categories.destroy', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">🗃️ Archive</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 text-gray-800" colspan="2">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>