<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6 max-w-7xl mx-auto">
        <x-toast_notifactios />

        <!-- Back button section -->
        <div class="mb-4">
            <a href="{{ route('job_applications.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm inline-flex items-center">
                Back
            </a>
        </div>

        <!-- Details section -->
        <div class="w-full bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2 text-gray-800">Application Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                <p><strong>Applicant:</strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job Vacancy:</strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy->company->name }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2.5 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                        {{ $jobApplication->status }}
                    </span>
                </p>
                <p class="md:col-span-2"><strong>Resume File:</strong>
                    @if ($jobApplication->resume?->fileUrl) 
                        <a href="{{ $jobApplication->resume->fileUrl }}" class="text-blue-600 hover:text-blue-800 underline" target="_blank">
                            {{ $jobApplication->resume->fileUrl }}
                        </a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </p>  
            </div>
            
            <!-- Edit & Archive buttons section -->
            <div class="flex justify-end items-center space-x-3 mt-6">
                <a href="{{ route('job_applications.edit', [$jobApplication->id, 'redirectToList' => 'false']) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2 rounded-md shadow-sm transition inline-flex items-center">
                    Edit Application
                </a>

                <form action="{{ route('job_applications.destroy', $jobApplication->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white font-medium text-sm px-5 py-2 rounded-md shadow-sm transition inline-flex items-center" 
                            onclick="return confirm('Are you sure you want to archive this Application?')">
                        Archive Application
                    </button>
                </form>
            </div>

            <!-- Tabs navigation section -->
            <div class="mt-6 border-b border-gray-200 pb-2">
                <ul class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('job_applications.show', [$jobApplication->id, 'tab' => 'Resume']) }}" 
                           class="px-4 py-2 {{ request('tab') === 'Resume' || !request('tab') ? 'bg-gray-400 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-gray-300 rounded-md font-medium inline-block transition">
                            Resume
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('job_applications.show', [$jobApplication->id, 'tab' => 'AIFeedback']) }}" 
                           class="px-4 py-2 {{ request('tab') === 'AIFeedback' ? 'bg-gray-400 text-white' : 'bg-gray-200 text-gray-800' }} hover:bg-gray-300 rounded-md font-medium inline-block transition">
                            AI Feedback
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Content section -->
            <div class="mt-6">
                <!-- 1. Resume Tab -->
                <div id="Resume" class="{{ request('tab', 'Resume') === 'Resume' ? 'block' : 'hidden' }} space-y-6">
                    @php
                        $resume = $jobApplication->resume;
                    @endphp

                    <!-- Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="text-md font-bold text-gray-800 mb-2">Summary</h4>
                        <div class="text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $resume->summary ?? 'No summary provided.' }}
                        </div>
                    </div>

                    <!-- Experience -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="text-md font-bold text-gray-800 mb-2">Experience</h4>
                        <div class="text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $resume->experience ?? 'No experience details available.' }}
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="text-md font-bold text-gray-800 mb-2">Education</h4>
                        <div class="text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $resume->education ?? 'No education details available.' }}
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="text-md font-bold text-gray-800 mb-3">Skills</h4>
                        @if (!empty($resume?->skills))
                            <div class="flex flex-wrap gap-2">
                                @if (is_array($resume->skills))
                                    @foreach ($resume->skills as $skill)
                                        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                @else
                                    <div class="text-gray-700 whitespace-pre-line">
                                        {{ $resume->skills }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">No skills listed.</p>
                        @endif
                    </div>
                </div>

                <!-- 2. AI Feedback Tab -->
                <div id="AIFeedback" class="{{ request('tab') === 'AIFeedback' ? 'block' : 'hidden' }} space-y-6">
                    @php
                        $aiScore = $jobApplication->aiGeneratedScore ?? $jobApplication->resume?->aiGeneratedScore;
                        $aiFeedback = $jobApplication->aiGeneratedFeedback ?? $jobApplication->resume?->aiGeneratedFeedback;
                    @endphp

                    <!-- AI Generated Score -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">AI Compatibility Score</h4>
                            <p class="text-sm text-gray-500">Automated match evaluation based on job requirements.</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-3xl font-extrabold {{ ($aiScore ?? 0) >= 70 ? 'text-green-600' : (($aiScore ?? 0) >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $aiScore !== null ? $aiScore . '%' : 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <!-- AI Generated Feedback -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h4 class="text-md font-bold text-gray-800 mb-3">Detailed Evaluation & Feedback</h4>
                        @if ($aiFeedback)
                            <div class="bg-white p-4 rounded border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $aiFeedback }}
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500">
                                No AI feedback has been generated for this application yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>