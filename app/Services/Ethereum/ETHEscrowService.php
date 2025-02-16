<?php

namespace App\Services\Ethereum;

use Web3\Contract;
use Web3\Utils;
use Web3p\EthereumTx\Transaction;

class ETHEscrowService extends BaseETHService
{
    public function createEscrow(string $giveawayId)
    {
        // Smart contract handles mapping giveaways to locked funds.
        $escrowData = [
            'escrow_address' => $this->contractAddress,
            'giveaway_id' => $giveawayId,
        ];

        return $escrowData;
    }

    public function getBalance(string $giveawayId)
    {
        $balance = null;

        $this->contract->at($this->contractAddress)
            ->call('getEscrowBalance', $giveawayId, function ($err, $result) use (&$balance) {
                if ($err !== null) {
                    throw new \Exception("Failed to fetch escrow balance: " . $err->getMessage());
                }
                $balance = Utils::fromWei($result[0], 'ether');
            });

        return $balance;
    }

    public function releaseFunds(string $giveawayId, string $winnerAddress)
    {
        $txData = [
            'from' => config('ethereum.owner_address'),
            'to' => $this->contractAddress,
            'data' => $this->contract->at($this->contractAddress)
                        ->getData('releaseEscrowFunds', $giveawayId, $winnerAddress),
            'gas' => '0x5208',
            'gasPrice' => '0x' . dechex(20000000000),
            'nonce' => '0x0',
        ];

        return $this->sendTransaction($txData);
    }

    private function sendTransaction(array $txData)
    {
        $tx = new Transaction($txData);
        $signedTx = $tx->sign($this->privateKey);

        $this->web3->eth->sendRawTransaction('0x' . $signedTx, function ($err, $txHash) {
            if ($err !== null) {
                throw new \Exception("Transaction failed: " . $err->getMessage());
            }
            return $txHash;
        });
    }
}
