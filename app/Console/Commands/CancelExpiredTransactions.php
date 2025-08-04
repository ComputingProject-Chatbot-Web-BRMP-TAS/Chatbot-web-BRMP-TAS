<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CancelExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel transactions that have expired payment deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting to check for expired transactions...');
            
            // Get transactions that are waiting for payment and have expired (24 hours after order)
            $expiredTransactions = Transaction::where('order_status', 'menunggu_pembayaran')
                ->where('order_date', '<=', Carbon::now()->subDay())
                ->get();
            
            $cancelledCount = 0;
            
            foreach ($expiredTransactions as $transaction) {
                // Check if there are any non-rejected payments
                $hasNonRejectedPayment = $transaction->payments()
                    ->where('payment_status', '!=', 'rejected')
                    ->exists();
                
                // Only cancel if no valid payment exists
                if (!$hasNonRejectedPayment) {
                    $transaction->update([
                        'order_status' => 'dibatalkan'
                    ]);
                    
                    $cancelledCount++;
                    
                    Log::info('Transaction cancelled due to expired payment', [
                        'transaction_id' => $transaction->transaction_id,
                        'user_id' => $transaction->user_id,
                        'order_date' => $transaction->order_date,
                        'cancelled_at' => Carbon::now()
                    ]);
                    
                    $this->line("Cancelled transaction #{$transaction->transaction_id} for user {$transaction->user->name}");
                }
            }
            
            $this->info("Successfully cancelled {$cancelledCount} expired transactions.");
            
            if ($cancelledCount > 0) {
                Log::info('Expired transactions cancelled', [
                    'count' => $cancelledCount,
                    'executed_at' => Carbon::now()
                ]);
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('Error cancelling expired transactions', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->error('Error occurred while cancelling expired transactions: ' . $e->getMessage());
            return 1;
        }
    }
}
