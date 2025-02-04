<?php

use App\GiveawayStatusEnum;
use App\GiveawayTypeEnum;
use App\WalletTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('giveaways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('giveaway_name');
            $table->decimal('amount', 18, 8); // ETH or SOL amount
            $table->enum('wallet_type', WalletTypeEnum::values());
            $table->enum('giveaway_type', GiveawayTypeEnum::values())->default(GiveawayTypeEnum::FIRST_PARTICIPANT);
            $table->enum('status', GiveawayStatusEnum::values())->default(GiveawayStatusEnum::PENDING);

            $table->string('has_paid')->nullable();
            $table->string('escrow_address')->nullable();
            $table->json('escrow')->nullable();
            $table->string('escrow_seed')->nullable();
            $table->string('bump')->nullable();
            
            $table->string('reference')->unique();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giveaways');
    }
};
