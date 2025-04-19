<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    public $name;

    /**
     * Create a new message instance.
     *
     * @param string $resetLink
     * @param string $name
     * @return void
     */
    public function __construct($resetLink, $name)
    {
        $this->resetLink = $resetLink;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Password Reset Request')
                    ->view('emails.reset_password')
                    ->with([
                        'resetLink' => $this->resetLink,
                        'name' => $this->name,
                    ]);
    }
}