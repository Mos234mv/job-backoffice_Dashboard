<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }} {{ request('archived') === 'true' ? __('(Archived)') : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast_notifactios />

        <div class="flex justify-end items-center space-x-4 mb-4">
            @if (request('archived') === 'true')
                <!-- زر عرض الطلبات النشطة -->
                <a href="{{ route('job_applications.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Active') }}
                </a>
            @else
                <!-- زر عرض الطلبات المؤرشفة -->
                <a href="{{ route('job_applications.index', ['archived' => 'true']) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Archived') }}
                </a>
            @endif
            
           
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Position (Job Vacancy)</th>
                     @if(auth()->user()?->role === 'admin')
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($jobApplications as $application)
                    <tr class="hover:bg-gray-50">
                        <!-- اسم المتقدم -->
                        <td class="px-6 py-4 text-gray-800 font-medium">
                            @if (request('archived') === 'true')
                                <span class="text-gray-500">{{ $application->user->name ?? 'N/A' }}</span>
                            @else
                                <a class="text-blue-600 hover:text-blue-800 underline" href="{{ route('job_applications.show', $application->id) }}">
                                    {{ $application->user->name ?? 'N/A' }}
                                </a>
                            @endif
                        </td>
                      
                      <!-- الوظيفة المتقدم إليها -->
                        <td class="px-6 py-4 text-gray-800">
                            {{ $application->jobVacancy->title ?? 'N/A' }}
                        </td>
                          @if(auth()->user()?->role === 'admin')
                          <td class="px-6 py-4 text-gray-800">
                            {{ $application->jobvacancy->company->name?? 'N/A' }}
                        </td>
                         @endif


                        <!-- حالة الطلب -->
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                {{ ucfirst($application->status ?? 'pending') }}
                            </span>
                        </td>

                        <!-- الإجراءات -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                @if (request('archived') === 'true')
                                    <form action="{{ route('job_applications.restore', $application->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-semibold">
                                            ♻️ Restore
                                        </button>
                                    </form>
                                @else 
                                    <a href="{{ route('job_applications.edit', $application->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                        ✍️ Edit
                                    </a>
                                    <form action="{{ route('job_applications.destroy', $application->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to archive this application?')" class="text-red-600 hover:text-red-800 text-sm font-semibold ml-2">
                                            🗃️ Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-8 text-center text-gray-500" colspan="6">
                            No job applications found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- روابط الترقيم مع الحفاظ على الفلاتر -->
        <div class="mt-4">
            {{ $jobApplications->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>