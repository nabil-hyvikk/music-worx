<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Models\AddToCart;
use App\Models\Cart;
use App\Models\Mp3Mix;
use App\Models\SettingsAudio;
use App\Models\UsersMobileToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    //create cart
    public function create_cart(Request $request)
    {
        $validated = $request->validate([
            'cart_name' => 'required|string|max:255',
            'user_token' => 'required'
        ]);

        $user_token = $request->input('user_token');

        if (!$user_token) {
            return TheOneResponse::InvalidCredential('User token is required.');
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is Invalid.');
        }

        $user_id = $userMobileToken->user_id;

        $cart = Cart::create([
            'user_id' => $user_id,
            'cart_name' => $validated['cart_name'],
            'cart_type' => 'custom',
            'created_at' => Carbon::now(),
        ]);

        if ($cart) {
            return TheOneResponse::created(['cart' => $cart], 'Cart created successfully.');
        } else {
            return TheOneResponse::other(400, [], 'Invalid Cart detail');
        }
    }

    // add to cart
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token' => 'required|string',
            'cart_id' => 'required|integer|exists:tbl_cart,id',
            'track_id' => 'required|array|min:1',
            'track_id.*' => 'integer|exists:tbl_mp3_mix,id',
        ]);

        if ($validator->fails()) {
            return TheOneResponse::other(400, ['errors' => $validator->errors()], 'Invalid data');
        }

        $user_token = $request->input('user_token');

        if (!$user_token) {
            return TheOneResponse::InvalidCredential('User token is required.');
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is Invalid.');
        }

        $user_id = $userMobileToken->user_id;
        $cart_id = $request->input('cart_id');
        $track_ids = $request->input('track_id');
        //$details = 'track';

        $settings = SettingsAudio::where('user_id', $user_id)->first();
        if (!$settings) {
            $settings = [
                'audio_format' => 'mp3',
            ];
        }

        $cart = Cart::find($cart_id);

        if (!$cart) {
            return TheOneResponse::other(400, ['success' => false], 'Invalid Cart detail');
        }


        foreach ($track_ids as $track_id) {
            $track = Mp3Mix::find($track_id);
            if (!$track) {
                return TheOneResponse::notFound('Track not found: ' . $track_id);
            }

            if ($track->download_status != 1) {
                return TheOneResponse::other(403, ['success' => false], 'No download rights for track ' . $track_id);
            }
            if ($track->album_only_track == 1) {
                return TheOneResponse::other(403, ['success' => false], 'Track ' . $track_id . ' cannot be downloaded individually');
            }

            $cartData = [
                'user_id' => $user_id,
                'track_id' => $track_id,
                'cart_id' => $cart_id,
                //'release_or_track' => $details,
                'created_at' => Carbon::now()
            ];

            // Add track type from settings if available
            if ($settings) {
                $cartData['track_type'] = $settings['audio_format'];
            }

            AddToCart::create($cartData);
        }
        return TheOneResponse::ok(['success' => true], 'Tracks added to cart successfully');
    }
}
