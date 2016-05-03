<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Transaction;

class paymentWasApplied extends Event
{
    use SerializesModels;

    private $charge;
    private $payment;
    private $old_amount;
    private $new_amount;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Transaction $payment, Transaction $charge, $old_amount, $new_amount)
    {
        $this->payment = $payment;
        $this->charge = $charge;
        $this->old_amount = $old_amount;
        $this->new_amount = $new_amount;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
