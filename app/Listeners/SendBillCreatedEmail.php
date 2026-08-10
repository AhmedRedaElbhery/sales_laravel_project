<?php

namespace App\Listeners;

use App\Events\BillCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\BillCreatedMail;
use Illuminate\Support\Facades\Mail;

class SendBillCreatedEmail implements ShouldQueue
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
     * @param  \App\Events\BillCreated  $event
     * @return void
     */
    public function handle(BillCreated $event)
    {
        Mail::to($event->bill->creator->email)
            ->send(new BillCreatedMail($event->bill));
    }
}