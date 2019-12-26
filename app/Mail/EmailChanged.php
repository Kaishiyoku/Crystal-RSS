<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private $newEmail;

    /**
     * @var string
     */
    private $newEmailToken;


    /**
     * Create a new message instance.
     *
     * @param string $newEmail
     * @param string $newEmailToken
     */
    public function __construct(string $newEmail, string $newEmailToken)
    {
        $this->newEmail = $newEmail;
        $this->newEmailToken = $newEmailToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('profile.emails.new_email.title'))
            ->view('emails.profile.new_email')
            ->text('emails.profile.new_email')
            ->with([
                'newEmail' => $this->newEmail,
                'newEmailToken' => $this->newEmailToken,
            ]);
    }
}
