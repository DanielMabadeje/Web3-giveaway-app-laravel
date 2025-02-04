<?php

namespace App\Services\Solana;

use Attestto\SolanaPhpSdk\Transaction;
use Attestto\SolanaPhpSdk\Programs\SystemProgram;
use Attestto\SolanaPhpSdk\PublicKey;

class SolanaEscrowService extends BaseSolanaService
{

    /**
     * Get the balance of the escrow account.
     */
    public function getEscrowBalance(string $escrowAddress): float
    {
        $balance = $this->sdk->getBalance($escrowAddress);
        return $this->lamportsToSol($balance); // Convert lamports to SOL
    }

    /**
     * Transfer SOL from escrow to a recipient (giveaway winner).
     */
    public function releaseEscrowFunds(string $escrowAddress, string $recipientAddress, float $amount)
    {
        $amountInLamports = $this->solToLamports($amount);
        $fromPublicKey = new PublicKey($escrowAddress); // Escrow account
        $toPublicKey = new PublicKey($recipientAddress); // Recipient  4fYNw3dojWmQ4dXtSGE9epjRGy9pFSx62YypT7avPYvA (a test address)

        $instruction = SystemProgram::transfer(
            $fromPublicKey->getPublicKey(),
            $toPublicKey,
            $amountInLamports
        );
        

        try {
            $transaction = new Transaction(null, null, $fromPublicKey->getPublicKey());
            $transaction->add($instruction);

            // $signature = $this->sdk->sendTransaction($transaction, [$this->keypair]);
            $signature = $this->sdk->sendTransaction($transaction, [$fromPublicKey]);
            return $signature;
        } catch (\Exception $e) {
            throw new \Exception("Failed to send SOL: " . $e->getMessage());
        }
    }
}