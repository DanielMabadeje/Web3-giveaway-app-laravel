<?php

namespace App\Services\Ethereum;

use App\DTOs\SendCryptoDTO;
use App\DTOs\SendETHDTO;
use App\Interfaces\CryptoServiceInterface;

class ETHService    extends BaseETHService  implements  CryptoServiceInterface
{
    protected $client;
    protected $keypair;

    public function __construct(public ETHTransactionService $ETHTransactionService)
    {
        
    }

    /**
     * Send SOL to a recipient.
     */
    public function send(SendCryptoDTO $sendCryptoDTO)
    {
        try {
            $transactionHash = $this->ETHTransactionService->sendETH(new SendETHDTO($sendCryptoDTO->recepientAddress, $sendCryptoDTO->amount));
            return response()->json([
                'message' => 'ETH sent successfully!',
                'transaction_hash' => $transactionHash,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateEscrowAccount($seed =   'giveaway123')
    {
    }

     /**
     * Get App Wallet Balance in ETH.
     */
    public function getBalance(string $address)
    {
        
    }
}