<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">

            {{-- صندوق لإظهار أية أخطاء عامة في التحقق --}}
            @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    <p class="font-bold mb-1">يرجى تصحيح الأخطاء التالية:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('job_vacancies.store') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Company Details Section -->
                <div class="mb-6 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm"> 
                    <h3 class="text-lg font-medium text-gray-800">Job Vacancy Details</h3>
                    <p class="text-sm text-gray-500 mb-4">Please fill in the details of the job vacancy.</p>

                    <!-- Job Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="{{ $errors->has('title') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('title') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="{{ $errors->has('location') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                     <!-- Expected Salary -->
                    <div class="mb-4">
                        <label for="salary" class="block text-sm font-medium text-gray-700">Expected Salary (USD)</label>
                        <input type="number" name="salary" id="salary" value="{{ old('salary') }}"
                            class="{{ $errors->has('salary') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('salary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    

                    <!--type select dropdown section -->
                    <div class="mb-4">
                        <label for="Type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" 
                            class="{{ $errors->has('type') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Select Type</option>
                            <option value="full-Time" {{ old('type') == 'full-Time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Hybrid" {{ old('type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>

                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                   

               <! company select dropdown section -->
                <div class="mb-4">
                    <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                    <select name="company_id" id="company_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Category select dropdown section -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Job Category</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Category</option>
                        @foreach ($jobCategories as $jobCategory)
                            <option value="{{ $jobCategory->id }}" {{ old('category') == $jobCategory->id ? 'selected' : '' }}>{{ $jobCategory->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Job Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Job Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            {{ old('description') }}
                        </textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Submit Buttons -->
<div class="flex justify-end items-center space-x-4 mt-6">
    <a href="{{ route('job_vacancies.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded mr-2">
        {{ __('Cancel') }}
    </a>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm">
        {{ __('Add Job Vacancy') }}
    </button>
</div>
            </form>
        </div>
    </div>
</x-app-layout>