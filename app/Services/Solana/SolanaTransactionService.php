<?php

namespace App\Services\Solana;

use App\DTOs\SendSolanaDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SolanaTransactionService extends BaseSolanaService
{

    public function __construct(public SolanaEscrowService $solanaEscrowService)
    {
        
    }

    /**
     * Send SOL to a recipient.
     */
    public function sendSolana(SendSolanaDTO $sendSolanaDTO)
    {
        try {

            $transaction = $this->solanaEscrowService->releaseEscrowFunds($sendSolanaDTO->escrowAddress, $sendSolanaDTO->recepientAddress, $sendSolanaDTO->amount);
            return $transaction;
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to send SOL: " . $e->getMessage());
        }      
    }
    

     /**
     * Get recent transactions for the app wallet.
     *
     * @return array
     */
    public function getRecentTransactions()
    {
        $rpcUrl = config('solana.rpc_url');
        $walletAddress = $this->keypair->getPublicKey();

        try {
            // Step 1: Fetch recent transaction signatures for the wallet address
            $signaturesResponse = Http::post($rpcUrl, [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => 'getSignaturesForAddress',
                'params' => [$walletAddress],
            ]);

            if ($signaturesResponse->failed()) {
                Log::error('Failed to fetch signatures for address', ['error' => $signaturesResponse->body()]);
                return [];
            }

            $signatures = $signaturesResponse->json()['result'];
            $transactions = [];

            // Step 2: For each signature, get transaction details
            foreach ($signatures as $signatureData) {
                $signature = $signatureData['signature'];

                // Fetch transaction details for each signature
                $transactionResponse = Http::post($rpcUrl, [
                    'jsonrpc' => '2.0',
                    'id' => 1,
                    'method' => 'getTransaction',
                    'params' => [$signature],
                ]);

                if ($transactionResponse->failed()) {
                    Log::error('Failed to fetch transaction details', ['signature' => $signature, 'error' => $transactionResponse->body()]);
                    continue;
                }

                $transaction = $transactionResponse->json()['result'];

                // Step 3: Extract relevant details (sender, amount, etc.)
                $senderAddress = $transaction['transaction']['message']['accountKeys'][0];
                $preBalance = $transaction['meta']['preBalances'][0];
                $postBalance = $transaction['meta']['postBalances'][0];
                $amount = $preBalance - $postBalance; // Calculate the amount sent

                // Step 4: Store transaction info (or match it to a giveaway)
                $transactions[] = [
                    'signature' => $signature,
                    'sender_address' => $senderAddress,
                    'amount' => $amount,
                    'timestamp' => $transaction['blockTime'],
                ];
            }

            return $transactions;
        } catch (\Exception $e) {
            Log::error('Error fetching recent transactions', ['error' => $e->getMessage()]);
            return [];
        }
    }
}