<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecoverAbandonedCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:recover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to users who have abandoned their carts for more than 2 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $abandonedCarts = \App\Models\Cart::where('updated_at', '<=', now()->subDays(2))
            ->where(function($q) {
                $q->whereNull('last_reminded_at')
                  ->orWhere('last_reminded_at', '<=', now()->subDays(7)); // Only remind again after a week if they still haven't checked out
            })
            ->has('items')
            ->with('user')
            ->get();

        $count = 0;
        foreach ($abandonedCarts as $cart) {
            if ($cart->user) {
                $cart->user->notify(new \App\Notifications\AbandonedCartNotification());
                $cart->update(['last_reminded_at' => now()]);
                $count++;
            }
        }

        $this->info("Successfully sent {$count} abandoned cart reminders.");
    }
}
