<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Models\OrderedBasket;
use App\Models\UsersMobileToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\Cloud_lib;

class PurchasedTracks extends Controller
{

    public function index(Request $request)
    {
        $user_token = $request->input('user_token');
        $limit = (int) $request->input('limit', 10);
        $offset = (int) $request->input('offset', 0);

        if (!$user_token) {
            return TheOneResponse::InvalidCredential('User token is required.');
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('Invalid user token.');
        }

        $user_id = $userMobileToken->user_id;

        $orderedBaskets = OrderedBasket::where('user_id', $user_id)
            ->with([
                'items.track',
                'items.track.release' => function ($query) {
                    $query->select('tbl_release.id', 'release_id', 'original_release_date');
                },
                'items.track.artists' => function ($query) {
                    $query->select('tbl_users.id', 'artist_name');
                },
            ])->offset($offset)
            ->limit($limit)
            ->get();

        $purchasedTracks = collect();

        foreach ($orderedBaskets as $basket) {
            foreach ($basket->items as $item) {
                $trackData = null;

                if ($item->release_or_track === 'track' && $item->track) {
                    $trackData = collect([$item->track]);
                } elseif ($item->release_or_track === 'release' && $item->release) {
                    $trackData = $item->release->tracks;
                }

                if ($trackData) {
                    foreach ($trackData as $track) {
                        $artists = $track->artists->pluck('artist_name')->join(', ');
                        $track['artist_name'] = $artists;
                        $purchasedTracks->push($track);
                        unset($track->artists);
                    }
                }
            }
        }

        if ($purchasedTracks->isEmpty()) {
            return TheOneResponse::notFound('Purchased tracks not found.');
        }

        // Paginate tracks
        $paginatedTracks = $purchasedTracks->slice(0, $limit)->values();

        return TheOneResponse::ok(['purchased_tracks' => $paginatedTracks], 'Purchased Tracks retrieved successfully.');
    }
}
