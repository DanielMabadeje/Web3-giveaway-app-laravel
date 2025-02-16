<?php

namespace App\Services\Ethereum;

use Web3\Utils;
use Web3p\EthereumTx\Transaction;
use App\DTOs\SendETHDTO;

class ETHTransactionService extends BaseETHService
{
    public function sendEthereum(SendETHDTO $sendETHDTO)
    {
        $txData = [
            'nonce' => '0x0',
            'from' => config('ethereum.owner_address'),
            'to' => $sendETHDTO->recepientAddress,
            'value' => '0x' . Utils::toWei($sendETHDTO->amount, 'ether')->toHex(),
            'gas' => '0x5208',
            'gasPrice' => '0x' . dechex(20000000000),
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
