<?php

namespace App\Services\Solana\traits;

trait SolanaConverterTrait
{
    function solToLamports(float $sol): int {
        return (int) ($sol * 1_000_000_000);
    }
    
    function lamportsToSol(int $lamports): float {
        return $lamports / 1_000_000_000;
    }
    
}