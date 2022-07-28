<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use App\Mail\ticketMail;
use Illuminate\Queue\SerializesModels;

class commentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $agentData;
    public $ticket;
    public $customerEmail;
    public function __construct($agentData,$customerEmail,$ticket)
    {

        $this->customerEmail= $customerEmail;
        $this->agentData= $agentData;
        $this->ticket= $ticket;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.comment')
            ->subject('پاسخ تیکت')
            ->to($this->customerEmail);
    }
}
