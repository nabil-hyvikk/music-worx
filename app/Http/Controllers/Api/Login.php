<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Models\User;
use App\Models\UsersMobileToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Login extends Controller
{
    public function login(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validateUser->fails()) {
           // return $this->sendError('Invalid Credentials', $validateUser->errors()->all(), 401);
           return TheOneResponse::InvalidCredential();
        }

        $user = User::where('username', $request->email)->first();

        if ($user) {
            if ($user->password === sha1($request->password)) {
                Auth::login($user);

                $mobileToken = $user->mobile_token;

                if (!$mobileToken) {
                    $token = Str::random(30);
                    $mobileToken = UsersMobileToken::create([
                        'user_id' => $user->id,
                        'token' => $token,
                    ]);
                }

                $token = [
                    'user_token' => $mobileToken->token,
                ];

               // return $this->sendResponse($token, 'Logged in Succcessfully', 200);
               return TheOneResponse::ok($token);
            }
        }
        return TheOneResponse::InvalidCredential();
        //return $this->sendError('Invalid Credentials', 401);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        //return response()->json(['message' => 'Logged out successfully'], 200);
        return TheOneResponse::ok(['message' => 'Logged out successfully']);
    }
}
