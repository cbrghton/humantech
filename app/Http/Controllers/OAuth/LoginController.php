<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Generate Token to access api
     *
     * @param Login $request
     * @return JsonResponse
     */
    public function generateToken(Login $request)
    {
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (!Auth::attempt($credentials)) {
            return response()->error('Unauthorized', [ 'Unauthorized' ], 401);
        }

        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        $token = $tokenResult->accessToken;

        Auth::logout();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /**
     * Unauthorized message show
     *
     * @return JsonResponse
     */
    public function unauthorized()
    {
        return response()->error('Unauthorized', [ 'Unauthorized' ], 401);
    }

}
