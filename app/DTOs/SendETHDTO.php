<?php

namespace App\DTOs;

class SendETHDTO{
    public function __construct(
        public readonly string $recepientAddress,
        public readonly string  |   float $amount
    )
    {
        
    }
}