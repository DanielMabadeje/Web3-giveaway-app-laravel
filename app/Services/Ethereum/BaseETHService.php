<?php

namespace App\Services\Ethereum;

use App\DTOs\SendSolanaDTO;

class BaseETHService
{
    protected $client;
    protected $keypair;

    public function __construct()
    {
        // Initialize Solana Client
        // $rpcUrl = config('solana.rpc_url');
        // $this->client = new Connection(SolanaRpcClient::class);

        // Load App Wallet Private Key
        // $privateKey = base64_decode(env('APP_SOL_PRIVATE_KEY'));
        // $this->keypair = Keypair::fromSecretKey($privateKey);
    }
}