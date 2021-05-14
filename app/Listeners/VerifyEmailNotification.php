<?php

namespace App\Listeners;

use App\Events\VerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifyEmailNotification extends ShouldQueue
{

    public $queue = 'verifyMail';

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
     * @param  VerifyEmail  $event
     * @return void
     */
    public function handle(VerifyEmail $event)
    {
        //
    }
}
