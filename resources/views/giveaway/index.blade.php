<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between">
            <div class="flex w-4/5">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('All Giveaways!') }}
                </h2>
            </div>


        <div class="flex w-1/5">
            <a 
                href="{{route('giveaway.create')}}" 
                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Create Giveaway
            </a>
        </div>
        </div>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @forelse ($giveaways as $giveaway)
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex flex-wrap justify-between">
                                <div class="w-4/5 flex">
                                    {{$giveaway->amount}}
                                </div>

                                <div class="w-1/5 flex justify-between">
                                    <div class="flex">
                                        <a  
                                            href="{{route('giveaway.destroy', $giveaway)}}" 
                                            type="button" 
                                            class="inline-flex items-center px-4 py-2 bg-red-800 dark:bg-red-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-red-800 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-white focus:bg-red-700 dark:focus:bg-white active:bg-red-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Delete
                                        </a>
                                        <a  
                                            href="{{route('giveaway.show', $giveaway)}}" 
                                            type="button" 
                                            class="inline-flex items-center px-4 py-2 bg-red-800 dark:bg-red-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-red-800 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-white focus:bg-red-700 dark:focus:bg-white active:bg-red-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            View Giveaway
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- {{$giveaway->giveaway_type}} --}}
                        </div>
                    </div>
                </div>
            </div>
            @empty
                
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You have not created a giveaway yet!!") }}

                <a 
                    href="{{route('giveaway.create')}}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Create Giveaway
                </a>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
