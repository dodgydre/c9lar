<?php

namespace App\Listeners;

use App\Events\PaymentWasApplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentWasAppliedUpdateBalances
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentWasApplied  $event
     * @return void
     */
    public function handle(PaymentWasApplied $event)
    {
        //
    }
}
