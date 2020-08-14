<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Register;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Register $request)
    {
        try {
            User::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password'))
            ]);
        } catch (\Exception $exception) {
            return response()->error('Error', [ 'user' => 'the user was not created' ], 500);
        }

        return response()->json([
            'name' => $request->input('name'),
            'username' => $request->input('username')
        ], 201);
    }
}
