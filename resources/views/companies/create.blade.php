<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Company') }}
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

            <form action="{{ route('companies.store') }}" method="POST">
                @csrf

                <!-- Company Details Section -->
                <div class="mb-6 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm"> 
                    <h3 class="text-lg font-medium text-gray-800">Company Details</h3>
                    <p class="text-sm text-gray-500 mb-4">Please fill in the details of the company.</p>

                    <!-- Company Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                            class="{{ $errors->has('name') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" 
                            class="{{ $errors->has('address') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Industry -->
                    <div class="mb-4">
                        <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                        <select name="industry" id="industry" 
                            class="{{ $errors->has('industry') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Select Industry</option>
                            <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option> 
                        </select>
                        @error('industry')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="mb-2">
                        <label for="website" class="block text-sm font-medium text-gray-700">Website (Optional)</label>
                        <input type="text" name="website" id="website" value="{{ old('website') }}" 
                            class="{{ $errors->has('website') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('website')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Company Owner Section -->
                <div class="mb-6 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm"> 
                    <h3 class="text-lg font-medium text-gray-800">Company Owner</h3>
                    <p class="text-sm text-gray-500 mb-4">Please provide details for the company owner account.</p>

                    <!-- Owner Name (owner_name) -->
                    <div class="mb-4">
                        <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" 
                            class="{{ $errors->has('owner_name') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('owner_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Email (email) -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Owner Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                            class="{{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Owner Password (password) -->
                    <div class="mb-2" x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700">Owner Password</label>
                        <div class="relative mt-1">
                            <input :type="show ? 'text' : 'password'" name="password" id="password" required autocomplete="new-password"
                                class="{{ $errors->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300' }} block w-full pr-10 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                                @click="show = !show">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end items-center space-x-4">
                    <a href="{{ route('companies.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                        {{ __('Add Company') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>