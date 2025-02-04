<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Create Giveaway") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-12 px-12 mt-4">
                <div class="p-6">
                    <form method="POST" action="{{ route('giveaway.store') }}" class="mx-5 w-10 px-60">
                        @csrf
                
                        <!-- Creator Wallet -->
                        <div>
                            <x-input-label for="creator_wallet" :value="__('Creator Wallet')" />
                            <x-text-input id="creator_wallet" class="block mt-1 w-full" type="text" name="creator_wallet" :value="old('creator_wallet')" required autofocus autocomplete="creator_wallet" />
                            <x-input-error :messages="$errors->get('creator_wallet')" class="mt-2" />
                        </div>
                
                        <!--amount -->
                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step=".00000001" name="amount" :value="old('amount')" required autocomplete="amount" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                
                        <!-- Wallet Type -->
                        <div class="mt-4">
                            <x-input-label for="wallet_type" :value="__('Select A Wallet Type')" />
    
                            <select id="wallet_type" 
                                    name="wallet_type" 
                                    class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full p-2.5">
                                @foreach(\App\WalletTypeEnum::values() as $key => $wallet)
                                    <option value="{{$wallet}}">{{$wallet}}</option>    
                                @endforeach
                                <option selected>Select A Wallet</option>
                              </select>
                
                            <x-input-error :messages="$errors->get('wallet_type')" class="mt-2" />
                        </div>
                
                        <!-- Giveaway Type -->
                        <div class="mt-4">
                            <x-input-label for="giveaway_type" :value="__('Select A Giveaway Type')" />
    
                            <select id="giveaway_type" 
                                    name="giveaway_type" 
                                    class="block mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full p-2.5">
                                @foreach(\App\GiveawayTypeEnum::values() as $key => $giveawayType)
                                    <option value="{{$giveawayType}}">{{$giveawayType}}</option>    
                                @endforeach
                                <option selected>Select A Giveaway Type</option>
                              </select>
                
                            <x-input-error :messages="$errors->get('giveaway_type')" class="mt-2" />
                        </div>
    
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Create Giveaway') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
