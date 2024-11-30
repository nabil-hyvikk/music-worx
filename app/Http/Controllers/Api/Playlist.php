<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Responses\TheOneResponse;
use App\Models\DistributorPriceCodes;
use App\Models\DjCharts;
use App\Models\SettingsAudio;
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
    protected $cloud_lib;
    public function __construct()
    {
        $this->cloud_lib = new Cloud_lib();
    }
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
        //'items.track',
        //'items.track.release:id,release_id,cover,label,slug,title'
        // $playlist = Streambox::with([
        //     'user:id,artist_name',

        // ])->withCount([
        //             'followersCount as likes',
        //             'items as total_tracks'
        //         ])->where('user_id', '=', $user_id)->where('id', $playlist_id)->first();

        $playlist = DB::table('tbl_streambox as s')
            ->select('s.id','s.name','s.is_public','s.description','s.photo_cover','s.user_id','s.updated_at','u.artist_name','u.slug','u.artist_name as created_by',
                DB::raw('(SELECT COUNT(*) FROM tbl_follow f WHERE f.type = "playlist" AND f.following = s.id) as numb'),
                DB::raw('(SELECT COUNT(*) FROM tbl_mp3_mix as m join tbl_streambox_items as si WHERE m.id=si.track_id AND s.id = si.streambox_id) as track_count'),
                // DB::raw('(SELECT SUM(m.duration) FROM tbl_mp3_mix as m join tbl_streambox_items as si WHERE m.id=si.track_id AND s.id = si.streambox_id) as play_back_time')
            )->leftJoin('tbl_users as u', 's.user_id', '=', 'u.id')
            ->where('s.id', $playlist_id)->where('u.id', $user_id)
            ->groupBy('s.id')
            ->orderBy('s.tstamp', 'DESC')
            ->first();

        if (!$playlist) {
            return TheOneResponse::notFound('Playlists not found');
        }

        $songs = DB::table('tbl_mp3_mix as t')->select('t.id','t.mp3_file','t.mp3_sd','t.flac_file','t.duration','t.mp3_preview','t.stream_status',
            't.stream_countries','t.key as track_key','t.gener','t.mix_name','t.song_name','t.bpm','t.waveform','t.green_waveform',
            't.full_wf','t.full_gwf','t.preview_starts','t.preview_ends','t.slug','t.user_id','t.release_id','t.id as track_id',
            't.distributor_price_code','tbl_release.cover','tbl_release.label','tbl_release.title','tbl_release.release_source','tbl_release.distributor_id',
            DB::raw('(SELECT user.artist_name FROM tbl_users as user WHERE user.id = t.user_id) as artist_name'),
            DB::raw('(SELECT user.artist_name FROM tbl_users as user WHERE user.id = tbl_release.label) as label_name'),
            's.id','s.track_id'
        )->join('tbl_release', 'tbl_release.release_id', '=', 't.release_id')
            ->join('tbl_streambox_items as s', 's.track_id', '=', 't.id')
            ->where('s.streambox_id', '=', $playlist_id)->get();
        //->orderBy('tbl_release.original_release_date', 'DESC')->get();

        $totalSeconds = DB::table('tbl_streambox_items as items')
            ->join('tbl_mp3_mix', 'tbl_mp3_mix.id', '=', 'items.track_id')
            ->where('items.streambox_id', $playlist_id)
            ->sum(DB::raw("TIME_TO_SEC(tbl_mp3_mix.duration)"));

        $playlist->play_back_time = gmdate("H:i:s", ($totalSeconds / 60));

        // Get playlist cover URL
        $fname = explode('.', $playlist->photo_cover);
        $cover250x250 = "https://images.music-worx.com/covers/" . $fname[0] . '-250x250.jpg';
        $cover100x100 = "https://images.music-worx.com/covers/" . $fname[0] . '-100x100.jpg';

        // array_push($playlist, ['cover250x250' => $cover250x250, 'cover100x100' => $cover100x100]);
        $playlist->cover250x250 = $cover250x250;
        $playlist->cover100x100 = $cover100x100;
        //$playlist->artist_name = $playlist->user->artist_name;
        //unset($playlist->user);

        $result = $this->getAudioPreference($user_id) ?? $this->setAudioPreference($user_id);

        $getFileByQuality = function ($quality, $musicFiles) {
            return match ($quality) {
                'mp3-128' => $musicFiles['mp3_sd'] ?? $musicFiles['mp3_file'],
                'mp3-320' => $musicFiles['mp3_file'],
                'flac' => $musicFiles['flac_file'] ?? $musicFiles['mp3_file'],
                default => $musicFiles['mp3_file'],
            };
        };

        $musicFilesList = [];
        foreach ($songs as $s) {
            $musicFilesList[] = [
                'id' => $s->id,
                'mp3_file' => $s->mp3_file,
                'mp3_sd' => $s->mp3_sd,
                'flac_file' => $s->flac_file,
            ];
        }

        $streamUrls = [];
        $downloadUrls = [];

        foreach ($musicFilesList as $musicFiles) {
            $streamFile = $getFileByQuality($result['app_stream_qlt'], $musicFiles);
            $downloadFile = $getFileByQuality($result['app_download_qlt'], $musicFiles);

            $streamUrls[] = $this->cloud_lib->get_signed_url($streamFile, 'music_bucket', 'new_release', '+5 days');
            $downloadUrls[] = $this->cloud_lib->get_signed_url($downloadFile, 'music_bucket', 'new_release', '+5 days');
        }


        foreach ($songs as $index => $s) {
            $s->stream_url = $streamUrls[$index];
            $s->download_url = $downloadUrls[$index];
            $s->preview_file_url = $this->getPreviewUrl($s);
            $s->cover250x250 = "https://images.music-worx.com/covers/" . explode('.', $s->cover)[0] . '-250x250.jpg';
            $s->cover100x100 = "https://images.music-worx.com/covers/" . explode('.', $s->cover)[0] . '-100x100.jpg';
            // $s->price = $this->getIndividualTrackPrice($s, $s->release_source, $s->distributor_id);
        }

        // foreach ($songs as $s) {

        //     // Get cover URL
        //     $fname = explode('.', $s->cover);
        //     $cover250x250 = "https://images.music-worx.com/covers/" . $fname[0] . '-250x250.jpg';
        //     $cover100x100 = "https://images.music-worx.com/covers/" . $fname[0] . '-100x100.jpg';
        //     $s->cover250x250 = $cover250x250;
        //     $s->cover100x100 = $cover100x100;
        //     $music_files = [
        //         'mp3_file' => $s->mp3_file,
        //         'mp3_sd' => $s->mp3_sd,
        //         'flac_file' => $s->flac_file
        //     ];
        //     // Get Stream and Download URL
        //     $preferential_urls = $this->getStreamDownloadUrl($user_id, $music_files);
        //     $s->download_url = $preferential_urls['download_url'];
        //     $s->stream_url = $preferential_urls['stream_url'];
        //     $duration = $this->durationToSecond($s->duration);
        //     $seconds += $duration;
        // }


        return TheOneResponse::ok(['playlist_data' => $playlist, 'song_data' => $songs], 'Playlist retrived successfully.');
    }

    public function durationToSecond($duration)
    {
        $durationArray = explode(':', $duration);
        if (count($durationArray) === 2) {
            $seconds = ($durationArray[0] * 60) + $durationArray[1];
            return $seconds;
        }
        return 0;
    }

    private function getPreviewUrl($value)
    {
        return $value->mp3_preview != $value->mp3_file
            ? $this->cloud_lib->get_signed_url($value->mp3_preview, 'music_bucket', 'prev')
            : $this->cloud_lib->get_signed_url($value->mp3_sd ?? $value->mp3_file, 'music_bucket', 'new_release');
    }

    public static function getIndividualTrackPrice($track, $rel_source, $dist_id)
    {
        $currency = 'USD';
        $finalPrice = 0.00;
        $finalTrackPrice = 0.00;

        if ($rel_source === 'website_frontend') {
            $finalTrackPrice = $currency === 'EUR' ? $track['mw_price_eur'] : $track['mw_price'];
            $finalPrice = $finalTrackPrice;
        } elseif ($rel_source === 'ftp_distributor') {
            // Fetch distributor price
            $distributorPriceTrack = DistributorPriceCodes::where('code_for', 'track')
                ->where('distributor_id', $dist_id)
                ->where('price_code', $track->distributor_price_code)
                ->first();

            if ($distributorPriceTrack) {
                $finalTrackPrice = $currency === 'EUR'
                    ? $distributorPriceTrack->selling_price_eur
                    : $distributorPriceTrack->selling_price;
            }
            $finalPrice = $finalTrackPrice;
        }
        return $finalPrice;
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

        //$cloud_lib = new Cloud_lib();


        if ($cover_image) {

            if ($playlist->photo_cover) {
                $oldCover = $playlist->photo_cover;
                $coverParts = pathinfo($oldCover);
                $oldCoverName = $coverParts['filename'];
                $this->cloud_lib->remove_from_wasabi($oldCover, 'img_bucket', 'covers');
                $this->cloud_lib->remove_from_wasabi("{$oldCoverName}-250x250.jpg", 'img_bucket', 'covers');
                $this->cloud_lib->remove_from_wasabi("{$oldCoverName}-100x100.jpg", 'img_bucket', 'covers');
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

        if (!$userToken && !$playlistId && !is_array($trackIds) && $trackIds == []) {
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


    //get download url function

    public function getAudioPreference($userId)
    {
        $preference = SettingsAudio::select('app_stream_qlt', 'app_download_qlt')
            ->where('user_id', $userId)
            ->first();

        return $preference ? $preference->toArray() : null;
    }

    public function setAudioPreference($userId, array $data = [])
    {
        $filteredData = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '' && $value !== false;
        });

        $audioSetting = SettingsAudio::where('user_id', $userId)->first();

        if ($audioSetting) {
            $filteredData['modified_at'] = Carbon::now();
            $audioSetting->update($filteredData);
            return [
                'app_stream_qlt' => $filteredData['app_stream_qlt'] ?? $audioSetting->app_stream_qlt ?? 'mp3-128',
                'app_download_qlt' => $filteredData['app_download_qlt'] ?? $audioSetting->app_download_qlt ?? 'mp3-128'
            ];
        } else {
            $filteredData['user_id'] = $userId;
            SettingsAudio::create($filteredData + ['app_stream_qlt' => 'mp3-128', 'app_download_qlt' => 'mp3-128']);
            return ['app_stream_qlt' => 'mp3-128', 'app_download_qlt' => 'mp3-128'];
        }
    }

    private function getStreamDownloadUrl($userId, $musicFiles)
    {
        $result = $this->getAudioPreference($userId) ?? $this->setAudioPreference($userId);

        $getFileByQuality = function ($quality, $musicFiles) {
            return match ($quality) {
                'mp3-128' => $musicFiles['mp3_sd'] ?? $musicFiles['mp3_file'],
                'mp3-320' => $musicFiles['mp3_file'],
                'flac' => $musicFiles['flac_file'] ?? $musicFiles['mp3_file'],
                default => $musicFiles['mp3_file'],
            };
        };

        $streamFile = $getFileByQuality($result['app_stream_qlt'], $musicFiles);
        $downloadFile = $getFileByQuality($result['app_download_qlt'], $musicFiles);

        $streamUrl = $this->cloud_lib->get_signed_url($streamFile, 'music_bucket', 'new_release', '+5 days');
        $downloadUrl = $this->cloud_lib->get_signed_url($downloadFile, 'music_bucket', 'new_release', '+5 days');

        return [
            'stream_url' => $streamUrl,
            'download_url' => $downloadUrl,
        ];
    }


    // private function getStreamDownloadUrl($userId, $musicFiles)
    // {
    //     $result = $this->getAudioPreference($userId);

    //     if (empty($result)) {
    //         $result = $this->setAudioPreference($userId);
    //     }


    //     switch ($result['app_stream_qlt']) {
    //         case 'mp3-128':
    //             $streamFile = !empty($musicFiles['mp3_sd']) ? $musicFiles['mp3_sd'] : $musicFiles['mp3_file'];
    //             break;

    //         case 'mp3-320':
    //             $streamFile = $musicFiles['mp3_file'];
    //             break;

    //         case 'flac':
    //             $streamFile = !empty($musicFiles['flac_file']) ? $musicFiles['flac_file'] : $musicFiles['mp3_file'];
    //             break;

    //         default:
    //             $streamFile = $musicFiles['mp3_file'];
    //             break;
    //     }


    //     $streamUrl = $this->cloud_lib->get_signed_url($streamFile, 'music_bucket', 'new_release', '+5 days');


    //     switch ($result['app_download_qlt']) {
    //         case 'mp3-128':
    //             $downloadFile = !empty($musicFiles['mp3_sd']) ? $musicFiles['mp3_sd'] : $musicFiles['mp3_file'];
    //             break;

    //         case 'mp3-320':
    //             $downloadFile = $musicFiles['mp3_file'];
    //             break;

    //         case 'flac':
    //             $downloadFile = !empty($musicFiles['flac_file']) ? $musicFiles['flac_file'] : $musicFiles['mp3_file'];
    //             break;

    //         default:
    //             $downloadFile = $musicFiles['mp3_file'];
    //             break;
    //     }

    //     $downloadUrl = $this->cloud_lib->get_signed_url($downloadFile, 'music_bucket', 'new_release', '+5 days');


    //     return [
    //         'stream_url' => $streamUrl,
    //         'download_url' => $downloadUrl,
    //     ];
    // }


}























































