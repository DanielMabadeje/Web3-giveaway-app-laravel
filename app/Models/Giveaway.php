<?php

namespace App\Models;

use App\GiveawayStatusEnum;
use App\GiveawayTypeEnum;
use App\WalletTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Giveaway extends Model
{
    /** @use HasFactory<\Database\Factories\GiveawayFactory> */
    use HasFactory;

    protected $fillable =   [
        'user_id',
        'giveaway_name',
        'amount',
        'wallet_type',
        'giveaway_type',
        'status',

        'has_paid',
        'escrow_address',
        'escrow',
        'escrow_seed',
        'bump',

        'reference'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->reference = self::generateUniqueToken();
        });
    }


    public function casts() :   array
    {
        return [
            'wallet_type'       =>  WalletTypeEnum::class,
            'giveaway_type'     =>  GiveawayTypeEnum::class,
            'status'            =>  GiveawayStatusEnum::class,
        ];
    }

    public function participants()  :   HasMany
    {
        return $this->hasMany(GiveawayParticipant::class);
    }

    public static function generateUniqueToken()
    {
        return uniqid();
    }
}
