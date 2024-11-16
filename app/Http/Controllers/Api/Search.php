<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ElasticSearch;
use App\Http\Responses\TheOneResponse;
use App\Libraries\Cloud_lib;
use App\Models\Elastic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Search extends Controller
{

    //search releases
    public function search_realeses(Request $request)
    {
        $searchString = $request->input('keyword');
        // $user_id = $this->input->post('user_id');
        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 1);

        if (!$searchString) {
            return TheOneResponse::other(301, ['success' => false], 'Please provide string for search');
        } else {
            // $user_genre = $this->Apimobile_model->get_user_genres($user_id);
            // $this->Usersearchbehaviour_model->updatesearchcount($searchString);

            // $result_release = $this->Apimobile_model->header_search_release_ajax_new($searchString, $limit, $offset, $user_genre, true);
            $elastic = new ElasticSearch();
            $fetch = $elastic->search_releases($searchString, $limit, $offset);
            $result_release = $fetch['releases'];
            $releaseIds = array_column($result_release, 'release_id');
            $artistsByRelease = $this->getArtistsByReleaseIds($releaseIds);

            // if (count($result_release)) {
            //     $this->Usersearchbehaviour_model->updateSearchBehaviour($searchString, ['release' => 1]);
            // } else {
            //     $this->Usersearchbehaviour_model->updateSearchBehaviour($searchString, ['release' => 0]);
            // }

            if ($result_release) {
                // $liked_list = $this->Apimobile_model->liked_list($user_id, 'release');
                // foreach($resultList as $key => $value){
                // }
                foreach ($result_release as &$release) {
                    $artistNames = isset($artistsByRelease[$release['release_id']])
                        ? collect($artistsByRelease[$release['release_id']])->pluck('artist_name')->implode(', ')
                        : '';
                    $release['artist_name'] = $artistNames;

                    $this->transformCoverUrls($release);
                    $release = $this->filterFields($release);
                }
                // foreach ($result_release as $key => $value) {
                //     $fname = explode('.', $value['cover']);
                //     $result_release[$key]['cover250x250'] = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
                //     $result_release[$key]['cover100x100'] = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';
                //     // if (isset($liked_list[$value['release_id']]) && $liked_list[$value['release_id']])
                //     //     $result_release[$key]['liked'] = 1;
                //     // else
                //     //     $result_release[$key]['liked'] = 0;
                //     // if (isset($liked_list[$value['release_id']]) && $liked_list[$value['release_id']])
                //     //     $result_release[$key]['liked'] = 1;
                //     // else
                //     //     $result_release[$key]['liked'] = 0;
                //     // if (strtolower($value['release_type']) == 'compilation') {
                //     //     $result_release[$key]['artist_name'] = 'Various Artists';
                //     // } else {
                //     $artists = $this->getArtistByReleaseId($value['release_id']);

                //     $artist_name = '';
                //     foreach ($artists as $key1 => $data) {
                //         if ($key1 == 0) {
                //             $artist_name = $artist_name . $data->artist_name;
                //         } else {
                //             $artist_name = $artist_name . ', ' . $data->artist_name;
                //         }
                //     }
                //     $result_release[$key]['artist_name'] = $artist_name;
                //     //}
                //     $this->unsetUnwantedFields($result_release[$key]);
                // }
                return TheOneResponse::ok(['searched_data' => $result_release], 'Searched data');
            } else {
                return TheOneResponse::other(301, ['success' => false], 'No Data found');
            }
        }
    }
    protected function transformCoverUrls(&$release)
    {
        $fname = explode('.', $release['cover']);
        $release['cover250x250'] = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
        $release['cover100x100'] = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';
    }

    protected function filterFields($release)
    {
        $unwantedFields = ['release_source','release_ref','icpn','distributor_id','countries','release_date','online','top','in_slider','staff_pick','stream_countries','stream_validity_start','stream_validity_end','stream_status','download_countries','download_validity_start','download_validity_end','download_status','preorder_countries','preorder_start_date','preorder_end_date','preorder','is_deleted','set_chart','featured','price_code','tstamp','tracks','artists','is_promoted'];
        return array_diff_key($release, array_flip($unwantedFields));
    }


    // protected function unsetUnwantedFields(&$release)
    // {
    //     $fields = [
    //         'distributor_id',
    //         'icpn',
    //         'release_source',
    //         'release_ref',
    //         'countries',
    //         'release_date',
    //         'online',
    //         'top',
    //         'in_slider',
    //         'staff_pick',
    //         'stream_countries',
    //         'stream_validity_start',
    //         'stream_validity_end',
    //         'stream_status',
    //         'download_countries',
    //         'download_validity_start',
    //         'download_validity_end',
    //         'download_status',
    //         'preorder_countries',
    //         'preorder_start_date',
    //         'preorder_end_date',
    //         'preorder',
    //         'is_deleted',
    //         'set_chart',
    //         'featured',
    //         'price_code',
    //         'tstamp',
    //         'tracks',
    //         'artists',
    //         'is_promoted'
    //     ];
    //     foreach ($fields as $field) {
    //         unset($release[$field]);
    //     }
    // }

    public function getArtistsByReleaseIds(array $releaseIds)
    {
        return DB::table('tbl_track_artists as a')
            ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->whereIn('a.release_id', $releaseIds)
            ->groupBy('a.release_id', 'u.id')
            ->select(
                'a.release_id',
                'u.id',
                DB::raw('MAX(u.artist_name) as artist_name'),
                DB::raw('MAX(u.slug) as slug')
            )
            ->get()
            ->groupBy('release_id');
    }


    // public function getArtistByReleaseId($release_id, $type = null)
    // {
    //     $query = DB::table('tbl_track_artists as a')
    //         ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
    //         ->where('a.release_id', $release_id)
    //         ->groupBy('u.id')  // Group only by artist ID
    //         ->select('u.id', DB::raw('MAX(u.artist_name) as artist_name, MAX(u.slug) as slug'));

    //     if (!is_null($type)) {
    //         $query->where('a.type', $type);
    //     } else {
    //         $query->orderBy('a.type', 'ASC');
    //     }

    //     return $query->get()->toArray();
    // }

    //search tracks
    public function search_tracks(Request $request)
    {
        $searchString = $request->input('keyword');
        //$userId = $request->input('user_id');
        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 0);

        $offset = $offset >= 1 ? ($offset - 1) * $limit : 0;

        if (!$searchString) {
            return TheOneResponse::other(301, ['success' => false], 'Please provide string for search');
        } else {
            // $userGenre = (new ApimobileModel)->getUserGenres($userId);

            // $this->updateSearchCount($searchString);

            $elastic = new ElasticSearch();
            $fetch = $elastic->search_tracks($searchString, $limit, $offset);

            if (!empty($fetch['tracks'])) {
                $trackIds = array_column($fetch['tracks'], 'track_id');
                $result = $this->getTracksFromIdsRaw($trackIds);

                // if (count($result)) {
                //     $this->updateSearchBehaviour($searchString, ['track' => 1]);
                // } else {
                //     $this->updateSearchBehaviour($searchString, ['track' => 0]);
                // }

                if ($result) {
                    // $likedList = (new ApimobileModel)->likedList($userId, 'track');

                    foreach ($result as $key => $value) {
                        $fname = explode('.', $value->cover);
                        $value->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
                        $value->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';

                        $value->can_stream = 0;
                        $value->can_stream = empty($value->stream_countries) || in_array("ww", explode(',', strtolower($value->stream_countries))) && $value->stream_status == 1 ? 1 : 0;
                        // $streamCountries = array_filter(explode(',', strtolower($value->stream_countries ?? '')));
                        // if (
                        //     (empty($streamCountries) ||
                        //         in_array("ww", $streamCountries)) &&
                        //     $value->stream_status == 1
                        // ) {
                        //     $result->can_stream = 1;
                        // }

                        //$result[$key]['liked'] = isset($likedList[$value['id']]) && $likedList[$value['id']] ? 1 : 0;

                        $value->preview_file_url = $this->getPreviewUrl($value);

                        // $musicFiles = [
                        //     'mp3_file' => $value['mp3_file'],
                        //     'mp3_sd' => $value['mp3_sd'],
                        //     'flac_file' => $value['flac_file']
                        // ];
                        // $preferentialUrls = $this->getStreamDownloadUrl($userId, $musicFiles);
                        // $result[$key]['download_url'] = $preferentialUrls['download_url'];
                        //$result[$key]['stream_url'] = $preferentialUrls['stream_url'];

                        $value->duration_second = $this->durationToSecond($value->duration);

                        // $artists = $this->getTrackArtists($value->track_id, 1);
                        // $artistNames = array_column($artists, 'artist_name');
                        // $value->artist_name = implode(', ', $artistNames);

                        $value->track_key = $key;

                        unset($value->flac_file, $value->stream_status, $value->stream_countries, $value->key);
                    }
                    return TheOneResponse::ok(['tracks' => $result], 'searched tracks');
                } else {
                    return TheOneResponse::notFound('Tracks Not Found');
                }
            } else {
                return TheOneResponse::notFound('Tracks Not Found');
            }
        }
    }

    // public function getTrackArtists($trackId, $type = null)
    // {
    //     $query = DB::table('tbl_track_artists as a')
    //         ->select('u.id', 'u.artist_name', 'u.slug', 'u.image')
    //         ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
    //         ->where('a.track_id', $trackId)
    //         ->groupBy('u.id');

    //     if (!is_null($type)) {
    //         $query->where('a.type', $type);
    //     } else {
    //         $query->orderBy('a.type', 'ASC');
    //     }

    //     $result = $query->get()->toArray();

    //     return $result;
    // }

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
        $cloud_lib = new Cloud_lib();

        return $value->mp3_preview != $value->mp3_file
            ? $cloud_lib->get_signed_url($value->mp3_preview, 'music_bucket', 'prev')
            : $cloud_lib->get_signed_url($value->mp3_sd ?? $value->mp3_file, 'music_bucket', 'new_release');
    }

    public function getTracksFromIdsRaw($ids)
    {
        $imploded = implode(", ", $ids);

        return DB::table('tbl_mp3_mix as t')
            ->select('t.id','t.mp3_file','t.mp3_sd','t.flac_file','t.duration','t.mp3_preview','t.stream_status','t.stream_countries','t.gener','t.mix_name',
            't.song_name','t.key','t.bpm','t.waveform','t.green_waveform','t.full_wf','t.full_gwf','t.preview_starts','t.preview_ends','t.slug','t.user_id',
            't.release_id','t.id as track_id','r.cover','r.label','r.title',DB::raw('GROUP_CONCAT(u.artist_name SEPARATOR ", ") as artist_names')
            )->join('tbl_release as r', 't.release_id', '=', 'r.release_id')
            ->leftJoin('tbl_track_artists as a', 't.id', '=', 'a.track_id')
            ->leftJoin('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->whereIn('t.id', $ids)
            ->groupBy('t.id') // Group by track ID
            ->orderByRaw("FIELD(t.id, ?)", [$imploded])
            ->get();
    }


    // public function getTracksFromIdsRaw($ids)
    // {

    //     $imploded = implode(", ", $ids);

    //     return DB::table('tbl_mp3_mix as t')
    //         ->select(
    //             't.id',
    //             't.mp3_file',
    //             't.mp3_sd',
    //             't.flac_file',
    //             't.duration',
    //             't.mp3_preview',
    //             't.stream_status',
    //             't.stream_countries',
    //             't.gener',
    //             't.mix_name',
    //             't.song_name',
    //             't.key',
    //             't.bpm',
    //             't.waveform',
    //             't.green_waveform',
    //             't.full_wf',
    //             't.full_gwf',
    //             't.preview_starts',
    //             't.preview_ends',
    //             't.slug',
    //             't.user_id',
    //             't.release_id',
    //             't.id as track_id',
    //             'r.cover',
    //             'r.label',
    //             'r.title'
    //         )
    //         ->join('tbl_release as r', 't.release_id', '=', 'r.release_id')
    //         ->whereIn('t.id', $ids)
    //         ->orderByRaw("FIELD(t.id, ?)", [$imploded])
    //         ->get();
    // }

    public function updatesearchcount($data)
    {
        $log_message = '/-----------------------------------------------START from main site-------------------------------------/';
        $log_message .= PHP_EOL . 'keyword: ' . print_r($data, true);

        $decodedString = html_entity_decode($data);
        $cleanedKeyword = trim($decodedString);
        $log_message .= PHP_EOL . '$cleanedKeyword: ' . $cleanedKeyword;

        $existingRecord = DB::table('tbl_user_search_behaviour')->where('search_keyword', $cleanedKeyword)->first();

        if ($existingRecord) {
            $log_message .= PHP_EOL . 'Update fields if the record already exists: ' . $existingRecord->count;
            Log::info($log_message);
            //$this->writeToLogFile($log_message);
            DB::table('tbl_user_search_behaviour')->where('id', $existingRecord->id)->update([
                'count' => $existingRecord->count + 1
            ]);

            return $existingRecord->id;
        } else {
            $log_message .= PHP_EOL . 'Insert new record: ' . $cleanedKeyword;
            Log::info($log_message);
            //$this->writeToLogFile($log_message);

            DB::table('tbl_user_search_behaviour')->insert([
                'search_keyword' => $cleanedKeyword,
                'count' => 1
            ]);
            return DB::getPdo()->lastInsertId();
        }
    }

    public function updateSearchBehaviour($search_keyword, $update_data)
    {
        $decodedString = html_entity_decode($search_keyword);
        $cleanedKeyword = trim($decodedString);
        $existingRecord = DB::table('tbl_user_search_behaviour')->where('search_keyword', $cleanedKeyword)->first();

        if ($existingRecord) {
            DB::table('tbl_user_search_behaviour')->where('id', $existingRecord->id)->update($update_data);
        }
    }

    //search artist
    public function search_artist(Request $request)
    {
        $searchString = $request->input('keyword');
        //$user_id = $request->input('user_id');
        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 1);

        if (!$searchString) {
            return TheOneResponse::other(301, ['success' => false], 'Please provide string for search');
        }
            // $user_genre = $this->get_user_genres($user_id);

           // $this->updatesearchcount($searchString);

            $elastic = new ElasticSearch();
            $fetch = $elastic->search_artists($searchString, $limit, $offset);
            $result = $fetch['artists'];

            // if (count($result)) {
            //     $this->updateSearchBehaviour($searchString, ['artist' => 1]);
            // } else {
            //     $this->updateSearchBehaviour($searchString, ['artist' => 0]);
            // }

            if ($result) {
                // $liked_list_chart = $this->Apimobile_model->liked_list($user_id, 'artist');
                // foreach ($result as $key => $value) {
                //     if (isset($liked_list[$value['id']]) && $liked_list[$value['id']])
                //         $result[$key]['liked'] = 1;
                //     else
                //         $result[$key]['liked'] = 0;
                // }
                return TheOneResponse::ok(['searched_artists' => $result], 'Searched Artists');
            } else {
                return TheOneResponse::notFound('Artist not found');
            }
    }

    //search label
    public function search_label(Request $request)
    {
        $searchString = $request->input('keyword');
        //$user_id = $request->input('user_id');
        $limit = $request->input('limit', 30);
        $offset = $request->input('offset', 1);

        if (!$searchString) {
            return TheOneResponse::other(301, ['success' => false], 'Please provide string for search');
        }

           //$this->updatesearchcount($searchString);

            $elastic = new ElasticSearch();
            $fetch = $elastic->search_labels($searchString, $limit, $offset);
            $result = $fetch['labels'];
            $total_results = $fetch['total'];

            // if (count($result)) {
            //     $this->updateSearchBehaviour($searchString, ['label' => 1]);
            // } else {
            //     $this->updateSearchBehaviour($searchString, ['label' => 0]);
            // }

            $response = [];
            if ($result) {
                $chunkedResults = array_chunk($result, 6);
                $content = [];

                foreach ($chunkedResults as $chunk) {
                    $rowContent = [];
                    foreach ($chunk as $row) {
                        if ($row['image']) {
                            $image = 'https://images.music-worx.com/users/' . $row['image'];
                        } else {
                            $image = 'https://images.music-worx.com/users/' . 'default.png';
                        }
                        $rowContent[] = [
                            //'link' => url('api/search/label/' . $row['slug']),
                            'id' => $row['id'],
                            'image' => $image,
                            'name' => $row['artist_name'],
                            'usertype' => $row['usertype'],
                            'slug' => $row['slug'],
                            'total_releases' => $row['total_releases'],

                        ];
                    }
                    $content[] = $rowContent;
                }

                $response['content'] = $content;
                $response['total_result'] = $total_results;

                return TheOneResponse::ok(['searched_labels' => $response], 'Searched Labels');
            } else {
                return TheOneResponse::notFound('Labels not found');
            }
    }

}
