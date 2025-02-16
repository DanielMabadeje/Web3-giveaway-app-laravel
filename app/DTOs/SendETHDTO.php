<?php

namespace App\DTOs;

use stdClass;

class SendETHDTO{
    public function __construct(
        public readonly string  $recepientAddress,
        public readonly array   |   stdClass   $escrow,
        public readonly string  $escrowAddress,
        public readonly string  |   float $amount
    )
    {
        
    }
}