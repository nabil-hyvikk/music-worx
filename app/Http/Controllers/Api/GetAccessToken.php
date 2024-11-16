<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Models\SecretKeys;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetAccessToken extends Controller
{
    public function getToken(Request $request)
    {
        $validated = $request->validate([
            'client_secret' => 'required',
        ]);

        $secretKey = SecretKeys::where('secret_key', $validated['client_secret'])->first();

        if (!$secretKey) {
            return TheOneResponse::InvalidCredential('Invalid secret key');
           // return response()->json(['error' => 'Invalid secret key'], 404);
        }

        //$user = User::find($secretKey->user_id);

        // $existingToken = DB::table('personal_access_tokens')
        //     ->where('tokenable_type', 'App\Models\SecretKeys')
        //     ->where('tokenable_id', $secretKey->id)
        //     ->where(function ($query) {
        //         $query->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
        //     })->first();

        // if ($existingToken) {
        //     return response()->json([
        //         'message' => 'You already generated token refresh it if expired',
        //         'token_type' => 'bearer',
        //         'expires_at' => $existingToken->expires_at,
        //     ], 200);
        // }

        $token = $secretKey->createToken('Access-Token-' . Carbon::now(), ['*'], Carbon::now()->addHour())->plainTextToken;
        //$token = $user->createToken($user->id . '-Token-' . Carbon::now(), ['*'], now()->addHour())->plainTextToken;

        $expiresAt = Carbon::now()->addHour();

        $token = [
            'token' => $token,
        ];

        return TheOneResponse::created($token);

        // return response()->json([
        //     'message' => 'Token Created successfully',
        //     'token_type' => 'bearer',
        //     'token' => $token,
        //     'expires_at' => $expiresAt,
        // ], 201);
    }
}
