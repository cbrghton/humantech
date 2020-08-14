<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('error', function ($title, $errors, $code) {

            $errorBody = [
                'error' => $title,
                'details' => $errors
            ];

            return Response::json($errorBody, $code);
        });
    }
}

