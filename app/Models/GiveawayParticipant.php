<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiveawayParticipant extends Model
{
    /** @use HasFactory<\Database\Factories\GiveawayParticipantFactory> */
    use HasFactory;

    protected $fillable =   [
        'wallet_address',
        'giveaway_id'
    ];

    public function giveaway()  :   BelongsTo
    {
        return $this->belongsTo(Giveaway::class);
    }
}
