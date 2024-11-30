<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Models\UsersMobileToken;
use Illuminate\Http\Request;

class AppActivity extends Controller
{
    public function add_activity(Request $request)
    {

        $validated = $request->validate([
            'user_token' => 'required|string',
            'device_id' => 'required|string',
            'activity' => 'nullable|integer',
            'group' => 'nullable|string',
            'type' => 'nullable|integer',
            'os' => 'nullable|integer',
            'info' => 'nullable|string',
        ]);


        if (!$validated['user_token']) {
            return TheOneResponse::InvalidCredential('User token is required.');
        }

        $userMobileToken = UsersMobileToken::where('token', $validated['user_token'])->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is Invalid.');
        }

        $user_id = $userMobileToken->user_id;

        $data = \App\Models\AppActivity::create([
            'user_id' => $user_id ?? 0,
            'device_id' => $validated['device_id'],
            'activity' => $validated['activity'] ?? null,
            'type' => $validated['type'] ?? null,
            'group' => $validated['group'] ?? null,
            'os' => $validated['os'] ?? null,
            'info' => $validated['info'] ?? null,
        ]);

        return TheOneResponse::created(['data' => $data], 'App activity added successfully');
    }
}
