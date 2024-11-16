<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SecretKeys;

class RefreshAccessToken extends Controller
{
    public function refreshAccessToken(Request $request)
    {
        $currentToken = $request->bearerToken();

        // $currentToken = $request->input('token');

        if (!$currentToken) {
            //return response()->json(['error' => 'No access token provided'], 401);
            return TheOneResponse::InvalidCredential('Access token not provided');
        }

        $hashedToken = hash('sha256', $currentToken);

        $tokenData = DB::table('personal_access_tokens')
            ->where('token', $hashedToken)
            ->first();

        if (!$tokenData) {
            //return response()->json(['error' => 'Invalid current token'], 404);
            return TheOneResponse::InvalidCredential('Invalid current token');
        }

        if (Carbon::now()->lessThan(Carbon::parse($tokenData->expires_at))) {
            return TheOneResponse::ok(['current_token' => $currentToken],'Current token is still valid');
            // return response()->json([
            //     'message' => 'Current token is still valid',
            //     'token_type' => 'bearer',
            //     'current_token' => $currentToken,
            //     'expires_at' => $tokenData->expires_at,
            // ], 200);
        }

        $secretKey = SecretKeys::find($tokenData->tokenable_id);

        $newToken = $secretKey->createToken('Access-Token-' . Carbon::now(), ['*'], now()->addHour())->plainTextToken;
        $expiresAt = Carbon::now()->addHour();

        return TheOneResponse::created(['new_token' => $newToken],'New Token generated successfully');

        // return response()->json([
        //     'message' => 'New Token generated successfully',
        //     'token_type' => 'bearer',
        //     'new_token' => $newToken,
        //     'expires_at' => $expiresAt,
        // ], 201);


    }
}
