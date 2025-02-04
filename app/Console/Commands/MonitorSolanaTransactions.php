<?php

namespace App\Console\Commands;

use App\Services\Solana\SolanaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MonitorSolanaTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monitor-solana-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private $solanaService;

    public function __construct(SolanaService $solanaService)
    {
        parent::__construct();
        $this->solanaService = $solanaService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transactions = $this->solanaService->getRecentTransactions(); // Implement this in your service

        foreach ($transactions as $transaction) {
            // Extract sender, amount, etc.
            $sender = $transaction['sender'];
            $amount = $transaction['amount'];
            $signature = $transaction['signature'];

            // Check if it's a new transaction
            if (!DB::table('deposits')->where('signature', $signature)->exists()) {
                // Save to database
                DB::table('deposits')->insert([
                    'sender_address' => $sender,
                    'amount' => $amount,
                    'giveaway_id' => null, // Match later if applicable
                    'timestamp' => now(),
                    'signature' => $signature,
                ]);

                // Notify user if giveaway is matched
            }
        }
    }
}
