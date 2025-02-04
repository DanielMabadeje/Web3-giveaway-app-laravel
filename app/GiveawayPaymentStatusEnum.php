<?php

namespace App;

enum GiveawayPaymentStatusEnum : string
{
    case OPEN             =   "Open";
    case CLOSED           =   "Closed";


    public static function values()
    {
        return collect(self::cases())->map(fn ($case) => $case->value)->toArray();
    }
}
