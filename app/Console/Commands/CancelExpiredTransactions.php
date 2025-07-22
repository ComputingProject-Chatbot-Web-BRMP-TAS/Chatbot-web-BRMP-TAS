<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Carbon\Carbon;

class CancelExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel transactions that have not been paid for more than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $expiredTransactions = Transaction::where('status_order', 'menunggu_pembayaran')
            ->where('order_date', '<=', $now->subHours(24))
            ->whereDoesntHave('payments') // Hanya yang belum punya payment sama sekali
            ->get();

        $count = 0;
        foreach ($expiredTransactions as $transaction) {
            $transaction->status_order = 'dibatalkan';
            $transaction->save();
            $count++;
        }

        $this->info("{$count} transaksi dibatalkan otomatis.");
    }
}
