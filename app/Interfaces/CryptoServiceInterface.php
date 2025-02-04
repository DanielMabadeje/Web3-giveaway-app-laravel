<?php

namespace App\Interfaces;

use App\DTOs\SendCryptoDTO;

interface CryptoServiceInterface
{
    public function send(SendCryptoDTO $sendCryptoDTO);

    public function generateEscrowAccount(string $seed);

    public function getBalance(string $walletAddress);
}
