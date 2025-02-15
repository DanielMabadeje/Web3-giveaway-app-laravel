
{{-- @slot() --}}
<div class="bg-white w-auto m-4 p-4 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{__('Participants')}}
    </h2>

    <div class="partipants_list">
        @forelse ($giveaway->participants as $participant)
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{$participant->wallet_address}}
            </div>
            <hr>
        @empty
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You have no participant yet!!") }}

                <a 
                    href="{{route('giveaway.create')}}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Share Giveaway Link
                </a>
            </div>
        @endforelse
    </div>
</div>