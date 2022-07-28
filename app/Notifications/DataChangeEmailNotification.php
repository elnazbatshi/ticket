<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class DataChangeEmailNotification extends Notification
{
    use Queueable;

    public function __construct($data)
    {
        $this->data = $data;
        $this->ticket = $data['ticket'];
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return (new MailMessage)
            ->subject($this->data['action'])
            ->greeting('با سلام')
            ->line($this->data['action'])
            ->line("ارسال کننده تیکت: ".$this->ticket->author_name)
            ->line("نام ارسال کننده: ".$this->ticket->title)
            ->line("خلاصه: ".Str::limit($this->ticket->content, 200))
            ->action('دیدن تیکت', route('admin.tickets.show', $this->ticket->id))
            ->line('با تشکر')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');
    }
}
