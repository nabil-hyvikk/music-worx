<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Models\Follow;
use App\Models\Release;
use App\Models\ReleaseLabelManager;
use App\Models\UsersMobileToken;
use Illuminate\Http\Request;
use App\Libraries\Cloud_lib;

class LikedTracks extends Controller
{
    // public function likedTracks(Request $request)
    // {
    //     $user_token = $request->input('user_token');
    //     $limit = $request->input('limit', 30);
    //     $offset = $request->input('offset', 0);
    //     $genre = $request->input('genre', '');

    //     if (!$user_token) {
    //         return $this->sendError('User token is required.', 400);
    //     }

    //     $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

    //     if (!$userMobileToken) {
    //         return $this->sendError('Invalid user token', 401);
    //     }

    //     $user_id = $userMobileToken->user_id;

    //     $query = Follow::where('user_id', $user_id)
    //     ->where('type', 'track')
    //     ->orderBy('id', 'DESC')
    //     ->with(['track.release', 'track.artists']);

    //     if ($limit > 0) {
    //         $query->limit($limit)->offset($offset);
    //     }

    //     $likedTracks = $query->get();
    //     $tracks = [];
    //     $totalSeconds = 0;

    //     foreach ($likedTracks as $likedTrack) {
    //         $track = $likedTrack->track;

    //         // Local track handling
    //         if ($likedTrack->following === 0 && !is_null($likedTrack->local_track_data)) {
    //             $trackData = json_decode($likedTrack->local_track_data, true);

    //             $tracks[] = [
    //                 'checkType' => 1,
    //                 'local_data' => $trackData,
    //                 'artist' => $trackData['artist_name'] ?? '',
    //                 'title' => $trackData['title'] ?? '',
    //                 'song_name' => $trackData['title'] ?? '',
    //             ];

    //             if (isset($trackData['trackduration'])) {
    //                 $totalSeconds += $trackData['trackduration'] / 1000;
    //             }
    //         } else {
    //             // Remote track handling
    //             if ($track && ($genre === '' || $track->genre === $genre)) {
    //                 $release = $track->release;
    //                 $artists = $track->artists->pluck('artist_name')->join(', ');
    //                 $totalSeconds += $this->durationToSeconds($track->duration);

    //                 $tracks[] = [
    //                     'checkType' => 0,
    //                     'id' => $track->id,
    //                     'track_id' => $track->id,
    //                     'stream_status' => $track->stream_status,
    //                     'mp3_file' => $track->mp3_file,
    //                     'song_name' => $track->song_name,
    //                     'artist' => $artists,
    //                     'mix_name' => $track->mix_name,
    //                     'duration' => $track->duration,
    //                     'cover' => $release->cover ?? '',
    //                     'label' => $release->label ?? '',
    //                     'release_id' => $release->id ?? null,
    //                     'gener' => $track->genre,
    //                 ];
    //             }
    //         }
    //     }

    //     $data = [
    //         'tracks' => $tracks,
    //         'track_details' => [
    //             'play_back_time' => gmdate("H:i:s", $totalSeconds),
    //             'track_count' => count($tracks),
    //         ]
    //     ];
    //     return $this->sendResponse($data, 'Liked tracks retrived successfully.', 200);
    // }



    public function likedTracks(Request $request)
    {
        $user_token = $request->input('user_token');
        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 0);
        $genre = $request->input('genre', '');

        if (!$user_token) {
            return TheOneResponse::InvalidCredential('User token is required.');
        }

        $userMobileToken = UsersMobileToken::where('token', $user_token)->first();

        if (!$userMobileToken) {
            return TheOneResponse::InvalidCredential('User token is Invalid.');
        }

        $user_id = $userMobileToken->user_id;

        $query = Follow::where('user_id', $user_id)
            ->where('type', 'track')
            ->with([
                'track.release:id,release_id,cover,label,slug,title,release_date',
                'track.artists:id,artist_name',
            ])
            ->orderBy('id', 'DESC');

        if ($genre !== '') {
            $query->whereHas('track', function ($trackQuery) use ($genre) {
                $trackQuery->where('gener', $genre);
            });
        }

        // $query = Follow::where('user_id', $user_id)
        //     ->where('type', 'track')
        //     ->with(['track.release', 'track.artists'])
        //     ->orderBy('id', 'DESC');


        if ($limit > 0) {
            $query->limit($limit)->offset($offset);
        }

        $likedTracks = $query->get();
        $tracks = [];
        $totalSeconds = 0;
        $cloud_lib = new Cloud_lib();

        foreach ($likedTracks as $likedTrack) {
            $track = $likedTrack->track;
            if ($track) {
                $release = $track->release;
                $fname = explode('.', $release->cover);
                //$release = Release::where('release_id', $track->release_id)->first();
                //$release_data = Release::where('release_id', $track->release_id)->first();

                //$artists = $track->artists->pluck('artist_name')->join(', ');


                // Get Preview URL
                if ($track->mp3_preview != $track->mp3_file) {
                    $previewUrl = $cloud_lib->get_signed_url($track->mp3_preview, 'music_bucket', 'prev');
                } else {
                    if (!is_null($track->mp3_sd)) {
                        $previewUrl = $cloud_lib->get_signed_url($track->mp3_sd, 'music_bucket', 'new_release');
                    } else {
                        $previewUrl = $cloud_lib->get_signed_url($track->mp3_file, 'music_bucket', 'new_release');
                    }
                }

                // if ($genre === '' || $track->gener === $genre) {
                $totalSeconds += $this->durationToSeconds($track->duration);

                // Get cover URL
                // $fname = explode('.', $release->cover);
                $cover250x250 = "https://images.music-worx.com/covers/" . $fname[0] . '-250x250.jpg';
                $cover100x100 = "https://images.music-worx.com/covers/" . $fname[0] . '-100x100.jpg';
                $tracks[] = [
                    'id' => $track->id,
                    'track_id' => $track->id,
                    'stream_countries' => $track->stream_countries,
                    'stream_status' => $track->stream_status,
                    'mp3_file' => $track->mp3_file,
                    'mp3_sd' => $track->mp3_sd,
                    'mp3_preview' => $track->mp3_preview,
                    'flac_file' => $track->flac_file,
                    'preview_file_url' => $previewUrl,
                    'song_name' => $track->song_name,
                    'artist' => $track->artists->pluck('artist_name')->implode(', '),
                    'mix_name' => $track->mix_name,
                    'duration' => $track->duration,
                    'cover' => $cover250x250 ?? '',
                    'label' => $release->label ?? '',
                    'release_id' => $track->release_id ?? null,
                    'gener' => $track->gener,
                    'user_id' => $track->user_id,
                    'slug' => $release->slug,
                    'title' => $release->title,
                    'key' => $track->key,
                    'bpm' => $track->bpm,
                    'waveform' => $track->waveform,
                    'full_gwf' => $track->full_gwf,
                    'full_wf' => $track->full_wf,
                    'green_waveform' => $track->green_waveform,
                    'preview_starts' => $track->preview_starts,
                    'preview_ends' => $track->preview_ends,
                    'can_stream' => $this->canStream($track, $request->user()->country_code),
                    'release_date' => $release->release_date
                ];
                // }
            } else {
                // return $this->sendError('No liked tracks found.', 404);
                return TheOneResponse::notFound('liked tracks Not found.');
            }
        }

        $likedTracks = [
            'tracks' => $tracks,
            'track_details' => [
                'play_back_time' => gmdate("H:i:s", $totalSeconds),
                'track_count' => count($tracks),
            ]
        ];

        //return $this->sendResponse($likedTracks, 'Liked tracks retrieved successfully.', 200);
        return TheOneResponse::ok($likedTracks, 'Liked data retrived successfully');
    }

    protected function canStream($track, $userCountryCode)
    {
        $streamCountries = explode(',', strtolower($track->stream_countries ?? ''));
        return (in_array($userCountryCode, $streamCountries) || in_array('ww', $streamCountries)) && $track->stream_status === 1;
    }

    private function durationToSeconds($duration)
    {
        $parts = explode(':', $duration);
        return ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];
    }

}
