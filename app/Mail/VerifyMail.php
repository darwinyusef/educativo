<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $datas;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.theme')->subject('Verifique su Email - Notification')->from( config('paramslist.aprobed:email.no:reply') )
                    ->cc( config('paramslist.aprobed:email.principal') );
    }
}
