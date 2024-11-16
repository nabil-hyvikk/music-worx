<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Responses\TheOneResponse;
use App\Models\DjCharts;
use App\Models\Streambox;
use App\Models\StreamboxItems;
use App\Models\UsersMobileToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Libraries\Kraken_lib;
use Illuminate\Support\Facades\Storage;
use App\Libraries\Cloud_lib;

class Playlist extends Controller
{
    //get all playlist
    public function index(Request $request)
    {
        $user_token = $request->input('user_token');
        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 0);

        if (!$user_token) {
            return TheOneResponse::InvalidCredential('User token is required');
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is Invalid');
        }

        $user_id = $userMobileToken->user_id;
        //    'items.track','items.track.artists'=> function ($query) {
        //                     $query->select('artist_name');
        //                 },
        //                 'items.track.release' => function ($query) {
        //                     $query->select('release_id', 'slug', 'label', 'title');
        //                 },

        $query = Streambox::withCount([
            'followersCount as likes',
            'items as total_tracks',
        ])->with([
                    'user:id,artist_name',
                ])->where('user_id', '=', $user_id);

        $query->orderBy('tstamp', 'DESC');

        $playlists = $query->limit($limit)->offset($offset)->get();

        if ($playlists->isEmpty()) {
            return TheOneResponse::notFound('Playlists not found for this user');
        }

        foreach ($playlists as $playlist) {
            // Get cover URLs
            $fname = explode('.', $playlist->photo_cover);
            $playlist->cover250x250 = "https://images.music-worx.com/covers/" . $fname[0] . '-250x250.jpg';
            $playlist->cover100x100 = "https://images.music-worx.com/covers/" . $fname[0] . '-100x100.jpg';
            $playlist->artist_name = $playlist->user->artist_name;
            unset($playlist->user);
        }


        return TheOneResponse::ok(['playlists' => $playlists], 'playlists retrieved successfully');
    }

    //get single playlist
    public function show(Request $request)
    {
        $user_token = $request->input('user_token');
        $playlist_id = $request->input('playlist_id');

        if (!$user_token) {
            return TheOneResponse::InvalidCredential('User token is required.');
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is Invalid.');
        }

        $user_id = $userMobileToken->user_id;

        // 'items.track'
        $playlist = Streambox::with([
            'user:id,artist_name',
        ])->withCount([
                    'followersCount as likes',
                    'items as total_tracks'
                ])->where('user_id', '=', $user_id)->where('id', $playlist_id)->first();

        if (!$playlist) {
            return TheOneResponse::notFound('Playlists not found');
        }

        // Get cover URL
        $fname = explode('.', $playlist->photo_cover);
        $cover250x250 = "https://images.music-worx.com/covers/" . $fname[0] . '-250x250.jpg';
        $cover100x100 = "https://images.music-worx.com/covers/" . $fname[0] . '-100x100.jpg';

        // array_push($playlist, ['cover250x250' => $cover250x250, 'cover100x100' => $cover100x100]);
        $playlist['cover250x250'] = $cover250x250;
        $playlist['cover100x100'] = $cover100x100;
        $playlist->artist_name = $playlist->user->artist_name;
        unset($playlist->user);

        return TheOneResponse::ok(['data' => $playlist], 'Playlist retrived successfully.');
    }

    //create playlist
    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_token' => 'required|string',
            'playlist_name' => 'required|string|max:255',
            'cover_image' => 'required',
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
        $cover_image = $request->input('cover_image');
        $playlist_name = $request->input('playlist_name');

        if (!$user_id || !$playlist_name || !$cover_image) {
            return TheOneResponse::other(400, [], 'Please provide required data.');
        }

        // $existingPlaylist = Streambox::where('user_id', $user_id)
        //     ->where('name', $validated['playlist_name'])->first();
        $existingPlaylist = Streambox::where('user_id', $user_id)
            ->where('name', $playlist_name)->exists();

        if ($existingPlaylist) {
            return TheOneResponse::other(409, ['success' => false], 'Playlist already exists');
        }

        if (!empty($cover_image)) {

            preg_match('/^data:image\/(\w+);base64,/', $cover_image, $matches);
            $ext = $matches[1] ?? 'png';

            $cover_image = preg_replace('/^data:image\/\w+;base64,/', '', $cover_image);


            $name = preg_replace('/[^a-zA-Z0-9]/', '-', $playlist_name) . "-" . rand(1000, 9999);
            $filename = $name . "." . $ext;


            $path = 'uploads/covers/' . $filename;
            Storage::disk('public')->put($path, base64_decode($cover_image));

            $bucket_folder = "covers";
            $kraken_lib = new Kraken_lib();
            $result = $kraken_lib->optimize_and_upload(storage_path('app/public/' . $path), $filename, $bucket_folder, 1, 0);

            $data = Streambox::create([
                'user_id' => $user_id,
                'name' => $playlist_name,
                'photo_cover' => $filename
            ]);
            Storage::disk('public')->delete($path);
            return TheOneResponse::created(['data' => $data], 'Playlist created successfully.');
        } else {
            return TheOneResponse::other(400, [], 'Cover image upload failed');
        }
    }

    //update playlist
    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_token' => 'required|string',
            'playlist_id' => 'required|integer',
            'playlist_name' => 'nullable|string|max:255',
            'cover_image' => 'nullable|string',
            'is_public' => 'nullable|boolean',
        ]);

        $user_token = $request->input('user_token');
        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is invalid.');
        }

        $user_id = $userMobileToken->user_id;
        $playlist_id = $validated['playlist_id'];
        $name = $request->input('playlist_name');
        $cover_image = $request->input('cover_image');
        $is_public = $request->input('is_public');

        $playlist = Streambox::where('id', $playlist_id)->where('user_id', $user_id)->first();
        if (!$playlist) {
            return TheOneResponse::other(404, [], 'Playlist not found.');
        }

        if ($name) {
            $existingPlaylist = Streambox::where('user_id', $user_id)
                ->where('name', $name)
                ->where('id', '!=', $playlist_id)
                ->exists();
            if ($existingPlaylist) {
                return TheOneResponse::other(409, ['success' => false], 'Playlist with this name already exists');
            }
            $playlist->name = $name;
        }

        if (!is_null($is_public)) {
            $playlist->is_public = $is_public;
        }

        $cloud_lib = new Cloud_lib();


        if ($cover_image) {

            if ($playlist->photo_cover) {
                $oldCover = $playlist->photo_cover;
                $coverParts = pathinfo($oldCover);
                $oldCoverName = $coverParts['filename'];
                $cloud_lib->remove_from_wasabi($oldCover, 'img_bucket', 'covers');
                $cloud_lib->remove_from_wasabi("{$oldCoverName}-250x250.jpg", 'img_bucket', 'covers');
                $cloud_lib->remove_from_wasabi("{$oldCoverName}-100x100.jpg", 'img_bucket', 'covers');
            }


            preg_match('/^data:image\/(\w+);base64,/', $cover_image, $matches);
            $ext = $matches[1] ?? 'png';
            $cover_image = preg_replace('/^data:image\/\w+;base64,/', '', $cover_image);
            $nameSlug = preg_replace('/[^a-zA-Z0-9]/', '-', $name ?? $playlist->name) . "-" . rand(1000, 9999);
            $filename = $nameSlug . "." . $ext;
            $path = 'uploads/covers/' . $filename;


            Storage::disk('public')->put($path, base64_decode($cover_image));


            $bucket_folder = "covers";
            $kraken_lib = new Kraken_lib();
            $result = $kraken_lib->optimize_and_upload(storage_path('app/public/' . $path), $filename, $bucket_folder, 1, 0);
            Storage::disk('public')->delete($path);
            $playlist->photo_cover = $filename;
        }

        $playlist->save();

        return TheOneResponse::ok(['data' => $playlist], 'Playlist updated successfully.');
    }

    //delete playlist
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'user_token' => 'required|string',
            'playlist_id' => 'required|integer',
        ]);

        $user_token = $request->input('user_token');
        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is invalid.');
        }

        $user_id = $userMobileToken->user_id;
        $playlist_id = $validated['playlist_id'];

        if (!$user_id || !$playlist_id) {
            return TheOneResponse::other(400, ['success' => false], 'Please provide user ID and playlist ID');
        }

        $playlist = Streambox::where('id', $playlist_id)->where('user_id', $user_id)->first();
        if (!$playlist) {
            return TheOneResponse::other(404, [], 'Playlist not found.');
        }

        //delete song
        StreamboxItems::where('streambox_id', $playlist_id)->delete();

        //delete playlist
        $deleted = $playlist->delete();
        if ($deleted) {
            return TheOneResponse::ok(['success' => true], 'Playlist deleted successfully');
        } else {
            return TheOneResponse::other(500, ['success' => false], 'An error occurred, please try again');
        }
    }

    //add song in playlist
    public function addTracks(Request $request)
    {
        $validated = $request->validate([
            'user_token' => 'required|string',
            'playlist_id' => 'required|integer',
            'track_id' => 'required|array|min:1',
            'track_id.*' => 'required|integer',
        ]);

        $userToken = $validated['user_token'];
        $playlistId = $validated['playlist_id'];
        $trackIds = $validated['track_id'];

        // $userToken = $request->input('user_token');
        // $playlistId = $request->input('playlist_id');
        // $trackIds = $request->input('track_id');

        if (!$userToken && !$playlistId && !is_array($trackIds) && $trackIds==[]) {
            return TheOneResponse::other(400, ['success' => false], 'Invalid input provided');
        }

        $userMobileToken = UsersMobileToken::where('token', $userToken)->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is invalid.');
        }

        $user_id = $userMobileToken->user_id;
        $playlist = Streambox::where('id', $playlistId)->where('user_id', $user_id)->first();
        if (!$playlist) {
            return TheOneResponse::notFound('Playlist not found or access denied');
        }

        $addedTracks = [];
        $trackExist = [];
        foreach ($trackIds as $trackId) {
            $existingTrack = StreamboxItems::where('user_id', $user_id)
                ->where('streambox_id', $playlistId)
                ->where('track_id', $trackId)->first();

            if (!$existingTrack) {
                $lastTrack = StreamboxItems::where('streambox_id', $playlistId)->orderByDesc('position')->first();
                $position = $lastTrack ? $lastTrack->position + 1 : 1;

                // Add the track to the playlist
                $playlistSong = StreamboxItems::create([
                    'user_id' => $user_id,
                    'streambox_id' => $playlistId,
                    'track_id' => $trackId,
                    'position' => $position,
                ]);

                $addedTracks[] = $playlistSong;
            } else {
                $trackExist[] = $existingTrack;
            }
        }
        $playlist->updated_at = Carbon::now();
        $playlist->save();
        $this->updatePlaylistGenres($playlistId);
        return TheOneResponse::ok(['added_tracks' => $addedTracks, 'Tracks_already_Exist' => $trackExist], 'Tracks added to playlist successfully');
    }

    //remove song from playlist
    public function removeTracks(Request $request)
    {
        $userToken = $request->input('user_token');
        $playlistId = $request->input('playlist_id');
        $trackIds = $request->input('track_id');

        if (!$userToken || !$playlistId || !is_array($trackIds)) {
            return TheOneResponse::other(400, ['success' => false], 'Invalid input provided');
        }

        $userMobileToken = UsersMobileToken::where('token', $userToken)->first();
        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is invalid.');
        }

        $user_id = $userMobileToken->user_id;
        $playlist = Streambox::where('id', $playlistId)->where('user_id', $user_id)->first();
        if (!$playlist) {
            return TheOneResponse::notFound('Playlist not found or access denied');
        }

        $deletedCount = StreamboxItems::where('streambox_id', $playlistId)
            ->whereIn('track_id', $trackIds)->delete();

        if ($deletedCount > 0) {
            $this->updatePlaylistGenres($playlistId);
            return TheOneResponse::ok(['success' => true], 'Tracks removed from playlist successfully');
        } else {
            return TheOneResponse::notFound('Track not found in playlist.');
        }
    }

    //update genres based on added and remove tracks from playlist
    public function updatePlaylistGenres($streamboxId)
    {
        $totalTracks = DB::table('tbl_streambox_items')
            ->where('streambox_id', $streamboxId)
            ->count();

        if ($totalTracks === 0) {
            return;
        }

        $genres = DB::table('tbl_streambox_items as s')
            ->join('tbl_mp3_mix as m', 's.track_id', '=', 'm.id')
            ->select('m.gener as genre', DB::raw("COUNT(*) / {$totalTracks} * 100 as tracks_percentage"))
            ->where('s.streambox_id', $streamboxId)
            ->groupBy('m.gener')
            ->having('tracks_percentage', '>', 30)
            ->pluck('genre')
            ->toArray();

        if (!empty($genres)) {
            DB::table('tbl_streambox')
                ->where('id', $streamboxId)
                ->update(['genres' => implode(',', $genres)]);
        }
    }


}
