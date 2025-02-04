<?php

namespace App\Services\Solana;

use App\DTOs\SendCryptoDTO;
use App\DTOs\SendSolanaDTO;
use App\Interfaces\CryptoServiceInterface;

class SolanaService extends BaseSolanaService implements    CryptoServiceInterface
{

    public function __construct(
        public SolanaTransactionService $solanaTransactionService,
        public SolanaEscrowService      $solanaEscrowService
    )
    {
        
    }

    public function generateEscrowAccount(string $seed =   'giveaway123'): array
    {
        return  $this->solanaEscrowService->generateSolanaEscrowAccount($seed);
    }

    /**
     * Get App Wallet Balance in SOL.
     */
    public function getBalance(string $address)
    {
        return $this->solanaEscrowService->getEscrowBalance($address);
    }

    /**
     * Send SOL to a recipient.
     */
    public function send(SendCryptoDTO $sendCryptoDTO)
    {
        try {
            $transactionHash = $this->solanaTransactionService->sendSolana(
                new SendSolanaDTO(
                    $sendCryptoDTO->recepientAddress, 
                    $sendCryptoDTO->escrow,
                    $sendCryptoDTO->escrowAddress,
                    $sendCryptoDTO->amount
                )
            );

            return $transactionHash;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
