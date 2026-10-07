<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Job Vacancies {{ request('archived') === 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast_notifactios />
        <div class="flex justify-end items-center space-x-4">
            @if (request('archived') === 'true')
                <!---Active companies button-->
                <a href="{{ route('job_vacancies.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Active') }}
                </a>
            @else
                <!---Archived companies button-->
                <a href="{{ route('job_vacancies.index', ['archived' => 'true']) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Archived') }}
                </a>
            @endif
            
            <!-- Add Company Button -->
            <a href="{{ route('job_vacancies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Job Vacancy') }}
            </a>
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Title
                    </th>
                     @if(auth()->user()->role == 'admin')
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Company
                    </th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Location
                    </th>   
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Type
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Salary
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">
                            @if (request()->input('archived') === 'true')
                                <span class="text-gray-500">{{ $jobVacancy->title }}</span>
                                
                          @else
                            <a class="text-blue-500 hover:text-blue-700 underline" href="{{ route('job_vacancies.show', $jobVacancy->id) }}" style="display: inline-block;">
                                {{ $jobVacancy->title }}    
                            </a>
                              @endif
                        </td>
                         @if(auth()->user()->role == 'admin')
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->company->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-gray-800">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-gray-800">
                            @if ($jobVacancy->type)
                                <span class="text-gray-500">{{ $jobVacancy->type }}</span>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">
                            @if ($jobVacancy->salary)
                                <span class="text-gray-500">${{ number_format($jobVacancy->salary , 2) }}</span>
                            @else
                                N/A
                            @endif
                        </td>   
                        <td>
                            <div class="flex space-x-4">
                                @if (request('archived') === 'true')
                                    <form action="{{ route('job_vacancies.restore', $jobVacancy->id) }}" method="POST" class="inline" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700">♻️ Restore</button>
                                    </form>
                                @else 
                                    <a href="{{ route('job_vacancies.edit', $jobVacancy->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a>
                                    <form action="{{ route('job_vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline">
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
                        <td class="px-6 py-4 text-gray-800" colspan="5">No job vacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>
    </div>
</x-app-layout>