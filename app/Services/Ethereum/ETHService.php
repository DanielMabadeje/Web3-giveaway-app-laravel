<?php

namespace App\Services\Ethereum;

use App\DTOs\SendCryptoDTO;
use App\DTOs\SendETHDTO;
use App\Interfaces\CryptoServiceInterface;

class ETHService implements CryptoServiceInterface
{
    public function __construct(
        protected ETHTransactionService $ethereumTransactionService,
        protected ETHEscrowService $ethereumEscrowService
    ) {}

    public function generateEscrowAccount(string $seed)
    {
        //Omor, remember that Ethereum uses a smart contract instead of PDAs. Each giveaway can be an ID inside the contract.
        return $this->ethereumEscrowService->createEscrow($seed);
    }

    public function getBalance(string $walletAddress)
    {
        return $this->ethereumEscrowService->getBalance($walletAddress);
    }

    public function send(SendCryptoDTO $sendCryptoDTO)
    {
        try {
            return $this->ethereumTransactionService->sendEthereum(
                new SendETHDTO(
                    $sendCryptoDTO->recepientAddress, 
                    $sendCryptoDTO->escrow, 
                    $sendCryptoDTO->escrowAddress, 
                    $sendCryptoDTO->amount
                )
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
