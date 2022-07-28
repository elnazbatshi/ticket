<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ticketMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $customerEmail;
    public $agents;
    public $categoryName;
    public $request;
    public function __construct($customerEmail,$agents,$categoryName,$request)
    {
       $this->customerEmail= $customerEmail;
       $this->agents= $agents;
       $this->categoryName= $categoryName;
       $this->request= $request;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.ticket')
            ->subject('درخواست مشتری')
            ->to($this->agents);

    }
}
