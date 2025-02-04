<?php

namespace App;

enum GiveawayStatusEnum : string
{
    case OPEN               =   "Open";
    case PENDING            =   "pending";
    case CLOSED             =   "Closed";


    public static function values()
    {
        return collect(self::cases())->map(fn ($case) => $case->value)->toArray();
    }
}
