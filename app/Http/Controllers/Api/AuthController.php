<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function login($request)
    {
        return response()->json([]);
    }
}