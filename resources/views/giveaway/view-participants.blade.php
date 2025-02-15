
<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.css" rel="stylesheet" />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View All Participants '.$giveaway->giveaway_name.' Giveaway!') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <div class="max-w-7xl mx-auto sm:px-5 lg:px-7 ">
                    <div class="bg-white w-auto m-4 p-4 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{__('Participants')}}
                        </h2>
                    
                        <div class="partipants_list flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                {{$participants =   $giveaway->participants()->paginate(10)}}
                                @forelse ($participants as $participant)
                    
                    
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center">
                                        <div class="flex-1 min-w-0 ms-4">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Participant
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                {{$participant->wallet_address}}
                                            </p>
                                        </div>
                                        @if ($giveaway->status->value == 'Open')
                                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                
                                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Make Winner</a>
                    
                                            </div>
                                        @else
                                            @if ($participant->is_winner)
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <span
                                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300">Winner</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </li>
                    
                                @empty
                                <div class="p-6 text-gray-900 dark:text-gray-100">
                                    {{ __("You have no participant yet!!") }}
                    
                                    <a href="{{route('giveaway.create')}}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Share Giveaway Link
                                    </a>
                                </div>
                                @endforelse
                            </ul>
                    
                            <div class="right px-3 ml-auto">
                                {{$participants->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            const clipboard = FlowbiteInstances.getInstance('CopyClipboard', 'wallet-address-copy-text');

            const $defaultMessage = document.getElementById('default-message');
            const $successMessage = document.getElementById('success-message');

            clipboard.updateOnCopyCallback((clipboard) => {
                showSuccess();

                // reset to default state
                setTimeout(() => {
                    resetToDefault();
                }, 2000);
            })

            const showSuccess = () => {
                $defaultMessage.classList.add('hidden');
                $successMessage.classList.remove('hidden');
            }

            const resetToDefault = () => {
                $defaultMessage.classList.remove('hidden');
                $successMessage.classList.add('hidden');
            }
        })

    </script>
</x-app-layout>