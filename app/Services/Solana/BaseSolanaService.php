<?php

namespace App\Services\Solana;

use Attestto\SolanaPhpSdk\SolanaRpcClient;
use Attestto\SolanaPhpSdk\Connection;
use Attestto\SolanaPhpSdk\Keypair;
use App\Services\Solana\traits\SolanaConverterTrait;
use Attestto\SolanaPhpSdk\Program;
use Attestto\SolanaPhpSdk\PublicKey;
use BitWasp\Bitcoin\Base58;

abstract class BaseSolanaService
{
    use SolanaConverterTrait;
    public $client;
    public $sdk;
    public $program;
    public $keypair;

    public function __construct()
    {

        // Initialize Solana Client with RPC URL
        $rpcUrl = SolanaRpcClient::DEVNET_ENDPOINT ?? config('solana.rpc_url', SolanaRpcClient::DEVNET_ENDPOINT);
        $this->client = new SolanaRpcClient($rpcUrl);
        $this->sdk = new Connection($this->client);


        $privateKeyBase64 = config('solana.app_sol_private_key');
        
        $privateKeyBytes = base64_decode($privateKeyBase64);
        $correctedPrivateKey = substr($privateKeyBytes, 0, 64);

        
        if ($correctedPrivateKey === false || strlen($correctedPrivateKey) !== 64) {
            throw new \Exception("Invalid Solana private key: must be a 64-byte secret key.");
        }

        $this->keypair = Keypair::fromSecretKey($correctedPrivateKey);
        $this->program = new Program($this->client);
    }


    /**
     * Generate an escrow account (PDA) to temporarily hold giveaway funds.
     * @param string $seed
     */
    public function generateSolanaEscrowAccount(string $seed): array
    {
        $escrowSeed = 'giveaway_escrow_' . $seed;
        [$escrowPDA, $bump] = PublicKey::findProgramAddress(
            [$escrowSeed],
            $this->keypair->getPublicKey()
        );


        return [
            'escrow_address' => $escrowPDA->toBase58(),
            'escrow' => $escrowPDA,
            'seed' => $escrowSeed,
            'bump' => $bump,
        ];
    }
}