<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StoreController extends Controller
{
    public function update(Request $request)
    {
        $token = $request->get('api_token');
        $data = $request->except('api_token');

        // check token
        $user = User::whereApiToken($token)->first();

        if ($user == null) {
            return $this->invalidApiTokenResponse();
        }

        Redis::set('store:user:' . $user->id, json_encode($data));
    }

    public function retrieve(Request $request)
    {
        $token = $request->get('api_token');

        // check token
        $user = User::whereApiToken($token)->first();

        if ($user == null) {
            return $this->invalidApiTokenResponse();
        }

        $data = Redis::get('store:user:' . $user->id);

        return response()->json(json_decode($data));
    }

    public function clear(Request $request)
    {
        $token = $request->get('api_token');

        // check token
        $user = User::whereApiToken($token)->first();

        if ($user == null){
            return $this->invalidApiTokenResponse();
        }

        Redis::del('store:user:' . $user->id);
    }

    private function invalidApiTokenResponse()
    {
        return response()->json(['invalid api token'], 422);
    }
}