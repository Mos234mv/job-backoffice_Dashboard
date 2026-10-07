<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast_notifactios />


        <! back button section -->
          @if(auth()->user()?->role === 'admin')
        <div class="mb-4">
            <a href="{{ route('companies.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back
            </a>
        </div>
        @endif

        <!-- Company details section -->
        <div class="w-full mx-auto bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Company Information</h3>
            <p></p><strong>Owner:</strong> {{ $company->owner->name}}</p>
             <p><strong>Email:</strong> {{ $company->owner?->email }}</p>
            <p><strong>Address:</strong> {{ $company->address }}</p>
            <p><strong>Industry:</strong> {{ $company->industry }}</p>
            <p><strong>Website:</strong>
                @if ($company->website) 
                    <a href="{{ $company->website }}" class="text-blue-500 hover:text-blue-700 underline" target="_blank">
                        {{ $company->website }}
                    </a>
                @else
                    N/A
                @endif
            </p>  
            
            <!-- Edit and Archive buttons section -->
           @if(auth()->user()?->role === 'company-owner')
    <a href="{{ route('my-company.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Edit Company
    </a>
@else
    <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Edit Company
    </a>
@endif

                
                @if(auth()->user()?->role === 'admin')
    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to archive this company?')">
            Archive Company
        </button>
    </form>
@endif
            </div>
             @if(auth()->user()?->role === 'admin')

            <!-- Tabs navigation section -->
            <div class="mt-6">
                <ul class="flex items-center space-x-2 pb-2">
                    <li>
                        <a href="{{ route('companies.show', [$company->id, 'tab' => 'Jobs']) }}" 
                           class="px-4 py-2 {{ request('tab') === 'Jobs' || !request('tab') ? 'bg-gray-400 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-gray-300 rounded-md font-medium">
                           Jobs
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('companies.show', [$company->id, 'tab' => 'Applications']) }}" 
                           class="px-4 py-2 {{ request('tab') === 'Applications' ? 'bg-gray-400 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-gray-300 rounded-md font-medium">
                            Applications
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Content section -->
            <div>
                <!-- Job table section -->
                <div id="Jobs" class="{{ request('tab') === 'Jobs' || request('tab') == '' ? 'block' : 'hidden' }} mt-4">
                   
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-md">
                        <thead>
                            <tr>
                                <th class="px-4 text-left py-2">Job Title</th>
                                <th class="px-4 text-left py-2">Type</th>
                                <th class="px-4 text-left py-2">Location</th>
                                <th class="px-4 text-left py-2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($company->jobVacancies as $job)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $job->title }}</td>
                                    <td class="px-4 py-2">{{ $job->type }}</td>
                                    <td class="px-4 py-2">{{ $job->location }}</td>     
                                    <td>
                                        <a href="{{ route('job_vacancies.show', $job->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                            View
                                        </a>
                                        
                                    </td> 
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Applications table section -->
                <div id="Applications" class="{{ request('tab') === 'Applications' ? 'block' : 'hidden' }} mt-4">
                    <!-- محتوى الطلبات هنا -->
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-md">
                        <thead>
                            <tr>
                                <th class="px-4 text-left py-2">Applicant Name</th>
                                <th class="px-4 text-left py-2">Job Title</th>
                                <th class="px-4 text-left py-2">Status</th>
                                <th class="px-4 text-left py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Application rows will be populated here -->
                            
                                @foreach ( $company->jobApplications as $application)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $application->user->name }}</td>
                                        <td class="px-4 py-2">{{ $application->jobVacancy->title }}</td>
                                        <td class="px-4 py-2">{{ $application->status }}</td>
                                        <td>
                                            <a href="{{ route('job_applications.show', $application->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>




                </div>    
            </div>

        </div>
        @endif
    </div>
</x-app-layout>