<?php

use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

return [

    /*
     * Whether or not the Opis Closure serialization is enabled
     */
    'enable_serialization' => true,

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
            'modifier_fn' => \Opis\Closure\serialize(function ($value) {
                return Hash::make($value);
            }),
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

    'post_creation_fn' => \Opis\Closure\serialize(function ($user) {
        $user->api_token = Uuid::uuid4();
        $user->save();

        return \App\Http\Controllers\Auth\RegisterController::createDefaultCategory($user);
    }),

];
