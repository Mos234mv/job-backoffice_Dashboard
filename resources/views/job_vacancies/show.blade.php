<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast_notifactios />

        <!-- Back button section -->
        <div class="mb-4">
            <a href="{{ route('job_vacancies.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back
            </a>
        </div>

        <!-- Job Vacancy details section -->
        <div class="w-full mx-auto bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Job Vacancy Information</h3>
            <p class="mb-2"><strong>Company:</strong> {{ $jobVacancy->company?->name ?? 'N/A' }}</p>
            <p class="mb-2"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
            <p class="mb-2"><strong>Type:</strong> {{ $jobVacancy->type }}</p>
            <p class="mb-2"><strong>Salary:</strong> {{ $jobVacancy->salary ? '$' . number_format($jobVacancy->salary, 2) : 'N/A' }}</p>
            <p class="mb-2"><strong>Description:</strong> {{ $jobVacancy->description ?? 'N/A' }}</p>     
            
            <!-- Edit and Archive Job Vacancy buttons section -->
            <div class="flex justify-end items-center space-x-4 mt-4">
                <a href="{{ route('job_vacancies.edit', [$jobVacancy->id, 'redirectToList' => 'false']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Job Vacancy
                </a>
                <form action="{{ route('job_vacancies.destroy', $jobVacancy->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to archive this job vacancy?')">
                        Archive Job Vacancy
                    </button>
                </form>
            </div>

            <!-- Tabs navigation section -->
            <div class="mt-8 border-b pb-2">
                <ul class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('job_vacancies.show', [$jobVacancy->id, 'tab' => 'applications']) }}"
                           class="px-4 py-2 {{ request('tab', 'applications') === 'applications' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-blue-500 hover:text-white rounded-md font-medium">
                           Applications
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Applications table section -->
            <div class="mt-4">   
                <table class="min-w-full bg-white rounded-lg shadow border">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 text-left py-2">Applicant Name</th>
                            <th class="px-4 text-left py-2">Job Title</th>
                            <th class="px-4 text-left py-2">Status</th>
                            <th class="px-4 text-left py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobVacancy->jobApplications ?? [] as $application)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $application->user?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $jobVacancy->title }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-800">
                                        {{ $application->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('job_applications.show', $application->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No applications submitted for this job yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>