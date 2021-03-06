<?php

return [
    'index' => [
        'title' => 'Profile',
        'registered_at' => 'Registered at',
        'options' => 'Options',
    ],
    'edit_password' => [
        'title' => 'Change password',
        'submit' => 'Set new password',
        'success' => 'Password changed.',
        'invalid_current_password' => 'The current password is wrong.',
    ],
    'edit_email' => [
        'title' => 'Change email address',
        'submit' => 'Set new email address',
        'success' => 'Email address changed. A confirmation email has been sent.',
    ],
    'confirm_new_email' => [
        'invalid_token' => 'Confirmation token invalid.',
        'success' => 'New email address successfully confirmed. You were logged out automatically. Please log in with your new email address.',
    ],
    'emails' => [
        'new_email' => [
            'title' => 'Confirm new email address',
            'you_have_changed_your_email_and_must_confirm_it' => 'You have set a new email address for your account. Please confirm it by clicking on the following link.',
            'new_email_address' => 'New email address: :email',
        ],
    ],
    'edit_settings' => [
        'title' => 'Settings',
        'submit' => 'Save',
    ],
    'update_settings' => [
        'success' => 'Settings saved.',
    ],
];
