<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;

class EmailUserRegistrationAdministratorsNotification extends BaseListener
{
    /**
     * Handle the event.
     *
     * @param  UserRegistered $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        // send mails to all administrators
        $administrators = User::active()->administrator()->orderBy('name');

        foreach ($administrators->get() as $administrator) {
            $this->mailer->send('auth.emails.register', ['user' => $user], function ($m) use ($administrator) {
                $m->to($administrator->email)->subject(__('auth.emails.register.title'));
            });
        }
    }
}
