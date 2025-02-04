<?php

namespace App;

enum GiveawayTypeEnum   : string
{
    
    case ROUNDROBIN             =   "ROUNDROBIN";
    case FIRST_PARTICIPANT      =   "FIRST PARTICIPANT";
    case SELECT_WINNER          =   "SELECT_WINNER";


    public static function values()
    {
        return collect(self::cases())->map(fn ($case) => $case->value)->toArray();
    }
}
