<?php

use Illuminate\Support\Facades\Hash;

return [
    /*
    * The class name of the user model to be used.
    */
    'model' => App\Models\User::class,

    /*
    * The fields with their validation rules to check for user model input.
    */
    'fields' => [
        'name'     => [
            'validation_rules' => 'string|max:255',
            'secret' => false,
            'modifier_fn' => null,
        ],
        'email'    => [
            'validation_rules' => 'string|email|max:255|unique:users',
            'secret' => false,
            'modifier_fn' => null,
        ],
        'password' => [
            'validation_rules' => 'string|min:6',
            'secret' => true,
            'modifier_fn' => function ($value) {
                return Hash::make($value);
            },
        ],
        'is_active' => [
            'validation_rules' => 'boolean',
            'secret' => false,
            'modifier_fn' => null,
        ],
        'is_administrator' => [
            'validation_rules' => 'boolean',
            'secret' => false,
            'modifier_fn' => null,
        ],
    ],

];
