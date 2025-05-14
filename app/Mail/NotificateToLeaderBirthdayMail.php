<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificateToLeaderBirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    public $variables;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($variables)
    {
        $this->variables = $variables;
    }

    public function build()
    {
        $data = $this->variables;
        return $this->subject('Cumpleaños de ' . $data->peopleName)
                    ->view('emails.notificate-to-leader-birthday-mail', compact('data'));
    }
}
