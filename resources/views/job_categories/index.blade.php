<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }}
        </h2>
        <div class="overflow-x-auto p-6">
            <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-4 bg-white">
               <thead>
                <tr>
                    <th>
                        Category Name
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
               </thead>
               


            </table>



        </div>



    </x-slot>
</x-app-layout>
