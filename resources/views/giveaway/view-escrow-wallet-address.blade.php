<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.css" rel="stylesheet" />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Send '.$giveaway->wallet_type->value.'!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">


                            @error('field')
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                    <span class="font-medium">Something went wrong!</span> Try sending in full
                                </div>
                            @enderror
                            <form action="{{route('giveaway.send-money-post', $giveaway)}}" method="post">
                                @csrf
                                <input id="wallet_type" name="wallet_type" type="hidden"
                                    class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full p-2.5"
                                    :value="{{$giveaway->wallet_type}}">

                                <div class="py-80" style="padding: 20px 0px;">
                                    <x-input-label for="wallet_type" :value="__('Copy the wallet address below and send '.$giveaway->amount.' '.$giveaway->wallet_type->value.' to proceed')" />
                                </div>
                                    <div class="w-full">
                                        <div class="relative">
                                            <label for="wallet-address-copy-text" class="sr-only">Label</label>
                                            <input id="wallet-address-copy-text" type="text"
                                                class="col-span-6 bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 py-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{$giveaway->escrow_address}}" disabled readonly>
                                            <button 
                                                data-copy-to-clipboard-target="wallet-address-copy-text" 
                                                onclick="event.preventDefault()"
                                                style="margin-top: -15px; padding:5px;"
                                                class="absolute end-2.5 top-1/2 -translate-y-1/2 text-gray-900 dark:text-gray-400 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700 rounded-lg py-2 px-4.5 inline-flex items-center justify-center bg-white border-gray-200 border h-8 w-1/3"
                                                >
                                                    <span id="default-message">
                                                        <span class="inline-flex items-center">
                                                            <svg class="w-3 h-3 me-1.5" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                            viewBox="0 0 18 20">
                                                            <path
                                                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                                            </svg>
                                                        <span class="text-xs font-semibold">Copy</span>
                                                        </span>
                                                    </span>
                                                    <span id="success-message" class="hidden">
                                                        <span class="inline-flex items-center">
                                                            <svg class="w-3 h-3 text-blue-700 dark:text-blue-500 me-1.5"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 16 12">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M1 5.917 5.724 10.5 15 1.5" />
                                                            </svg>
                                                            <span
                                                                class="text-xs font-semibold text-blue-700 dark:text-blue-500">Copied</span>
                                                        </span>
                                                    </span>
                                            </button>
                                        </div>
                                    </div>

                                


                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="ms-4">
                                        {{ __('I Have Sent '. $giveaway->amount.' '.$giveaway->wallet_type->value.' ✅') }}
                                    </x-primary-button>
                                </div>
                            </form>
                            {{-- {{$giveaway->giveaway_type}} --}}
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