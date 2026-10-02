<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Category') }}
        </h2>

    </x-slot>
    <div class="overflow-x-auto p-6">


        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
             <form action="{{ route('job_categories.store') }}" method="POST">
            @csrf
             @method('POST')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="{{$errors->has('name')? 'outline outline-1 outline-red-500' : ''}}  mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
              
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex justify-end items-center space-x-4">

                <a href="{{ route('job_categories.index') }}" class="gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded mr-2">
                {{ __('Cancel') }}
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Category') }}
            </button>
            </div>
        </form>
        </div>
       
    </div>




</x-app-layout>