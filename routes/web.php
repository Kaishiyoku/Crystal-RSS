<?php

Route::get('/', 'HomeController@index')->name('home.index');

if (app()->environment() !== 'production') {
    Route::get('/redis/keys', function () {
        Redis::set('A', 'basoipdja9isjdiasjd');
        $data = Redis::keys('*');

        return response()->json($data);
    });

    Route::get('/redis/get/{key}', function ($key) {
        function isJson($string) {
            json_decode($string);

            return (json_last_error() == JSON_ERROR_NONE);
        }

        $type = Redis::type($key)->getPayload();

        switch ($type) {
            case 'string':
                $data = isJson(Redis::get($key)) ? json_decode(Redis::get($key)) : Redis::get($key);
                break;
            case 'hash':
                $data = Redis::hgetall($key);
                break;
            // TODO: handle other types too
            default:
                $data = null;
        }

        return response()->json($data);
    });
}