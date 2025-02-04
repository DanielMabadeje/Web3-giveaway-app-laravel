<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Claim Giveaway') }}
        </h2>
    </x-slot>
    {{-- add-giveaway-participant --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('add-giveaway-participant', $reference)}}" method="post">
                        @csrf
                        <div>

                            <div class="mt-4">
                                
        
                                <input id="wallet_type" 
                                        name="wallet_type"
                                        type="hidden" 
                                        class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full p-2.5"
                                        :value="{{$giveaway->wallet_type}}"
                                        >
                                <x-input-error :messages="$errors->get('wallet_type')" class="mt-2" />
                            </div>
                    
                            {{-- {{ dd($giveaway->wallet_type->value) }} --}}
                            {{-- <x-input-label for="wallet_address" :value="__('Put Your ETH Address')" /> --}}
                            {{-- <x-input-label for="wallet_address" :value="__('Put Your $giveaway->wallet_type->value Address')" /> --}}
                            <x-input-label for="wallet_address" :value="__('Put Your ') . $giveaway->wallet_type->value . __(' Address')" />
                            <x-text-input id="wallet_address" class="block mt-1 w-full" type="text" name="wallet_address" :value="old('wallet_address')" required autofocus autocomplete="wallet_address" />
                            <x-input-error :messages="$errors->get('wallet_address')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Claim Giveaway') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
