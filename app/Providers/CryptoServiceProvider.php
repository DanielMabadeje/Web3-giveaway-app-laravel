<?php

namespace App\Providers;

use App\GiveawayTypeEnum;
use App\Interfaces\CryptoServiceInterface;
use App\Services\Ethereum\ETHService;
use App\Services\Solana\SolanaService;
use App\WalletTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CryptoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CryptoServiceInterface::class, function ($app) {
            $request = $app->make(Request::class); // Get the current request
            $giveawayType = $request->input('wallet_type', WalletTypeEnum::SOLANA); // Default to SOL

            if ($giveawayType === WalletTypeEnum::ETHEREUM) {
                return $app->make(ETHService::class); // Use service container
            } elseif ($giveawayType === WalletTypeEnum::SOLANA) {
                return $app->make(SolanaService::class); // Use service container
            }else{
                return $app->make(SolanaService::class); // Use service container
            }

            throw new \Exception('Unsupported Wallet type: ' . $giveawayType);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
