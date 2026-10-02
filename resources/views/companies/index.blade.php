<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Companies {{ request('archived') === 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast_notifactios />
        <div class="flex justify-end items-center space-x-4">
            @if (request('archived') === 'true')
                <!---Active companies button-->
                <a href="{{ route('companies.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Active') }}
                </a>
            @else
                <!---Archived companies button-->
                <a href="{{ route('companies.index', ['archived' => 'true']) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Archived') }}
                </a>
            @endif
            
            <!-- Add Company Button -->
            <a href="{{ route('companies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Company') }}
            </a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Name
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Address
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Industry
                    </th>   
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Website
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($companies as $company)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            <a class="text-blue-500 hover:text-blue-700" href="{{ route('companies.show', $company->id) }}">
                                {{ $company->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->address }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $company->industry }}</td>
                        <td class="px-6 py-4 text-gray-800">
                            @if ($company->website)
                                <a href="{{ $company->website }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $company->website }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <div class="flex space-x-4">
                                @if (request('archived') === 'true')
                                    <form action="{{ route('companies.restore', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>
                                @else 
                                    <a href="{{ route('companies.edit', $company->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a>
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
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
                        <td class="px-6 py-4 text-gray-800" colspan="5">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</x-app-layout>