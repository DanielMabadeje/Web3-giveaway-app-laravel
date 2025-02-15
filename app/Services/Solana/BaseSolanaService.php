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
    protected $rpcUrl;

    public function __construct()
    {


        $network = config('solana.solana_network');
        $rpcUrls = [
            'localnet' => SolanaRpcClient::LOCAL_ENDPOINT,
            'testnet'  => SolanaRpcClient::DEVNET_ENDPOINT,
            'mainnet'  => SolanaRpcClient::MAINNET_ENDPOINT,
        ];

        if (!isset($rpcUrls[$network])) {
            throw new \Exception("Invalid SOLANA_NETWORK value: $network");
        }
        $this->rpcUrl = $rpcUrls[$network];
        $this->client = new SolanaRpcClient($this->rpcUrl);
        $this->sdk = new Connection($this->client);

        // Load the keypair from the specified path in .env
        $walletPath = config('solana.solana_keypair_path');

        if (!file_exists($walletPath)) {
            throw new \Exception("Solana keypair file not found at: $walletPath");
        }

        $privateKeyArray = json_decode(file_get_contents($walletPath), true);
        $this->keypair = Keypair::fromSecretKey($privateKeyArray);
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