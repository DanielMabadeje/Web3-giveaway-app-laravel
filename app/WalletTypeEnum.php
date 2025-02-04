<?php

namespace App;

enum WalletTypeEnum : string
{
    case SOLANA     =   "SOLANA";
    case ETHEREUM   =   "ETHEREUM";
    case BITCOIN    =   "BITCOIN";


    public static function values()
    {
        return collect(self::cases())->map(fn ($case) => $case->value)->toArray();
    }

    public function symbol()
    {
        return[
            self::SOLANA        =>  'SOL',
            self::ETHEREUM      =>  'ETH',
            self::BITCOIN       =>  'BTC'
        ];
    }
}
