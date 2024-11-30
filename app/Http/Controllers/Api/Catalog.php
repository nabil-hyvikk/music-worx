<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Libraries\Cloud_lib;
use App\Models\DistributorPriceCodes;
use App\Models\Follow;
use App\Models\Mp3Mix;
use App\Models\Release;
use App\Models\SettingsAudio;
use App\Models\SummeryTopHype;
use App\Models\SummeryTopPicks;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Catalog extends Controller
{
    protected $cloud_lib;
    public function __construct()
    {
        $this->cloud_lib = new Cloud_lib();
    }
    //get release by Id
    public function release(Request $request)
    {
        // 'title', 'cover', 'release_id'
        $release_id = $request->input('release_id');
        if (empty($release_id)) {
            return TheOneResponse::other(301, ['success' => false], 'Release ID is required');
        }

        $release_info = DB::table('tbl_release')
            ->select(
                'tbl_release.*',
                'tbl_track_artists.artist_id',
                'u.artist_name as label_nm',
                'u.image')
            ->leftJoin('tbl_track_artists', 'tbl_release.release_id', '=', 'tbl_track_artists.release_id')
            ->leftJoin('tbl_users as u', 'tbl_release.label', '=', 'u.id')
            ->where('tbl_release.release_id', $release_id)
            ->first();

        if (!$release_info) {
            return TheOneResponse::other(301, ['success' => false], 'Release not found');
        }
        $fname = $fname = explode('.', $release_info->cover);
        $release_info->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
        $release_info->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';

        return TheOneResponse::ok(['release' => $release_info], 'Release info');
    }

    // public function release(Request $request)
    // {
    //     // 'title', 'cover', 'release_id'
    //     $release_id = $request->input('release_id');
    //     if (empty($release_id)) {
    //         return TheOneResponse::other(301, ['success' => false], 'Release ID is required');
    //     } else {
    //         $release_info = DB::table('tbl_release')->select('title', 'cover', 'release_id')
    //             ->where('release_id', $release_id)
    //             ->get();

    //         foreach ($release_info as $key => $value) {
    //             $fname = explode('.', $value->cover);
    //             $release_info[$key]->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
    //             $release_info[$key]->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';
    //         }

    //         if ($release_info) {
    //             return TheOneResponse::ok(['release' => $release_info], 'Release info');
    //         } else {
    //             return TheOneResponse::other(301, ['success' => false], 'Release not found');
    //         }
    //     }
    // }

    //get track by Id
    public function track(Request $request)
    {
        $track_id = $request->input('track_id');

        if (empty($track_id)) {
            return TheOneResponse::other(301, ['success' => false], 'Release ID is required');
        }

        // $songResult = Mp3Mix::select('*')
        //     ->with([
        //         'artists:id,artist_name',
        //         'release:release_id,original_release_date,release_source,distributor_id,label'
        //     ])->find($track_id);

        $songResult = DB::table('tbl_mp3_mix')->select(
            'tbl_mp3_mix.*',
            'tbl_mp3_mix.id',
            'tbl_release.release_id',
            'tbl_release.label',
            'tbl_release.title',
            'tbl_release.cover',
            'tbl_release.original_release_date as release_date',
            DB::raw('GROUP_CONCAT(DISTINCT u.artist_name ORDER BY u.artist_name SEPARATOR ", ") as artist_names')
        )
            ->join('tbl_release', 'tbl_release.release_id', '=', 'tbl_mp3_mix.release_id')
            ->Join('tbl_track_artists as a', 'tbl_mp3_mix.id', '=', 'a.track_id')
            ->Join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->where('tbl_mp3_mix.id', $track_id)
            ->first();


        if (!$songResult) {
            return TheOneResponse::notFound('No data found');
        }

        //$artists = $songResult->artists->pluck('artist_name')->join(', ');
        // $songResult['artist_name'] = $artists;

        // $label = $songResult->release->label;

        if (!is_numeric($songResult->label)) {
            $songResult->label_name = $songResult->label;
        } else {
            $labelName = User::where('id', $songResult->label)->value('artist_name');
            $songResult->label_name = $labelName ?: '';
        }

        $fname = $fname = explode('.', $songResult->cover);
        $songResult->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
        $songResult->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';

        // Get Preview URL
        if ($songResult->mp3_preview != $songResult->mp3_file) {
            $previewUrl = $this->cloud_lib->get_signed_url($songResult->mp3_preview, 'music_bucket', 'prev');
        } else {
            if (!is_null($songResult['mp3_file'])) {
                $previewUrl = $this->cloud_lib->get_signed_url($songResult->mp3_sd, 'music_bucket', 'new_release');
            } else {
                $previewUrl = $this->cloud_lib->get_signed_url($songResult->mp3_file, 'music_bucket', 'new_release');
            }
        }
        $songResult->preview_file_url = $previewUrl;

        //$release = $songResult->release;
        //$songResult['price'] = $release ? $this->getIndividualTrackPrice($songResult, $release) : 0.00;

        // $release_id = $songResult->release->release_id;
        $releaseResult = Release::where('release_id', $songResult->release_id)->first();

        // $label = $songResult->first()->release->label;
        // if (!is_numeric($label)) {
        //     $songResult['label_name'] = $label;
        // } else {
        //     $label = User::where('id', $label)->select('artist_name')->first();
        //     //$label = User::getUserById($label);
        //     $songResult['label_name'] = $label ? $label->artist_name : '';
        // }

        // $priceArr = array();
        $songResult->price = $this->getIndividualTrackPrice($songResult, $releaseResult);
        ;

        unset($songResult->artists);
        return TheOneResponse::ok(['data' => $songResult], 'Track fetched successfully.');
    }

    public static function getIndividualTrackPrice($track, $rel)
    {
        $currency = 'USD';
        $finalPrice = 0.00;
        $finalTrackPrice = 0.00;

        if ($rel['release_source'] === 'website_frontend') {
            $finalTrackPrice = $currency === 'EUR' ? $track['mw_price_eur'] : $track['mw_price'];
            $finalPrice = $finalTrackPrice;
        } elseif ($rel['release_source'] === 'ftp_distributor') {
            // Fetch distributor price
            $distributorPriceTrack = DistributorPriceCodes::where('code_for', 'track')
                ->where('distributor_id', $rel['distributor_id'])
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

    //get filter releases prime or crew picks
    public function releases(Request $request)
    {
        $stacked = 1;
        $filters = [
            'prime' => $request->input('prime'),
            'crew_pick' => $request->input('crew_pick'),
            'genre' => $request->input('genre'),
            'limit' => $request->input('limit') ?: 10,
            'offset' => $request->input('offset') ?: 0
        ];

        $getHypeRelease = $this->getHypeRelease($stacked, $filters);
        $result = [];
        $type = '';
        if ($filters['prime'] == 1 && $filters['crew_pick'] == 1) {
            $type = 'Prime and Crew pick';
        } else if ($filters['prime'] == 1) {
            $type = 'Prime';
        } else if ($filters['crew_pick'] == 1) {
            $type = 'Crew pick';
        } else {
            $type = 'None';
        }

        if (!empty($getHypeRelease)) {
            $result[] = [
                'title' => 'Filtered release',
                'see_all' => true,
                'type' => $type,
                'data' => $getHypeRelease
            ];
        }

        if (empty($result)) {
            return TheOneResponse::notFound('No data found');
        }

        return TheOneResponse::ok(['data' => $result], 'Releases data filtered');
    }

    public function getHypeRelease($stacked = 0, $filters = [])
    {
        $genre = $filters['genre'] ?? '';
        //$user_id = $this->input->post('user_id');
        $offset = $filters['offset'] ?? 0;
        $limit = $filters['limit'] ?? 10;
        $prime = $filters['prime'] ?? null;
        $crew_pick = $filters['crew_pick'] ?? null;
        if ($offset >= 1) {
            $offset = ($offset - 1) * $limit;
        }

        $result = $this->get_archived_release_grid_page_limit($limit, $offset, $genre, 'original_release_date-desc', '', '', '', 'hype', '', $prime, $crew_pick);

        if ($result) {
            // Format the results
            foreach ($result as $key => $value) {
                $fname = explode('.', $value->cover);
                $value->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
                $value->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';
                // unset($value->numb);
                // unset($value->allowed_tracks);
            }

            if ($stacked) {
                return $result;
            } else {
                return TheOneResponse::ok(['data' => $result], 'Releases retrieved successfully.');
            }
        } else {
            if ($stacked) {
                return [];
            } else {
                return TheOneResponse::notFound('No releases found');
            }
        }
    }

    public function get_archived_release_grid_page_limit($per_page = 10, $page = 0, $genre = '', $order, $label = "", $fromdate = "", $todate = "", $page_filter = "", $type = "", $prime = null, $crew_pick = null)
    {
        $order = explode('-', $order);
        $append = "";

        if (is_array($genre)) {
            if (!empty($genre)) {
                $append .= " AND r.gener IN ('" . implode("', '", $genre) . "') ";
            }
        } elseif ($genre != "") {
            $append .= " AND r.gener='" . $genre . "' ";
        }

        if ($label != "") {
            $append .= " AND r.label='" . $label . "' ";
        }
        if ($type != "") {
            $append .= " AND r.release_type='" . $type . "' ";
        }
        if ($fromdate != "" && $todate != "") {
            $append .= " AND DATE(r.original_release_date)>='" . $fromdate . "' AND DATE(r.original_release_date)<='" . $todate . "' ";
        }
        if ($page_filter == 'hype') {
            $append .= " AND r.top=1 ";
        } elseif ($page_filter == 'staff_picks') {
            $append .= " AND r.staff_pick=1 ";
        }

        if ($prime == 1) {
            $append .= " AND r.top=1 ";
        } elseif ($crew_pick == 1) {
            $append .= " AND r.staff_pick=1 ";
        }

        // $query = "SELECT r.release_id, r.id,r.slug,r.title,r.gener,r.label, r.user_id, u.artist_name AS label_nm,r.release_type, r.cover
        // FROM tbl_release r, tbl_users u
        // WHERE (ISNULL(r.release_ref) OR r.release_ref=r.release_id)
        // AND IF(CONCAT('',r.label * 1), r.label, r.user_id) = u.id
        // AND r.online=1
        // AND (r.countries='WW')
        // " . $append . "
        //   ORDER BY " . $order[0] . " " . $order[1];
        // $query .= " LIMIT " . $per_page . " OFFSET " . $page;

        $query = "SELECT r.release_id, r.id, r.slug, r.title, r.gener, r.label, r.user_id, u.artist_name AS label_nm, r.release_type, r.cover,
        GROUP_CONCAT(DISTINCT a.artist_name ORDER BY a.artist_name SEPARATOR ', ') AS artist_names FROM tbl_release r LEFT JOIN
        tbl_track_artists ta ON r.release_id = ta.release_id LEFT JOIN tbl_users a ON ta.artist_id = a.id LEFT JOIN
        tbl_users u ON IF(CONCAT('', r.label * 1), r.label, r.user_id) = u.id WHERE (ISNULL(r.release_ref) OR r.release_ref = r.release_id)
        AND r.online = 1 AND r.countries = 'WW' " . $append . " GROUP BY r.release_id ORDER BY " . $order[0] . " " . $order[1] . "
        LIMIT " . $per_page . " OFFSET " . $page;

        $result = DB::select($query);

        if (is_array($result) && count($result)) {
            foreach ($result as $key => $value) {
                $artist_list = [];
                if (strtolower($value->release_type) == 'compilation') {
                    $value->artist_name = 'Various Artists';
                } else {
                    $value->artist_name = $value->artist_names;
                }
                unset($value->artist_names);
            }

            // foreach ($result as $key => $value) {
            //     $artist_list = [];
            //     if (strtolower($value->release_type) == 'compilation') {
            //         $value->artist_name = 'Various Artists';
            //     } else {
            //         $artists = $this->getArtistByReleaseId($value->release_id);
            //         $artist_links = array();
            //         foreach ($artists as $art) {
            //             $artist_links[] = $art->artist_name;
            //         }
            //         $value->artist_name = implode(', ', $artist_links);
            //     }
            // }
            return $result;
        }

        return null;
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

    //get filtered tracks by prime and crew pick
    public function tracks(Request $request)
    {
        $prime = $request->input('prime');
        $crew_pick = $request->input('crew_pick');
        $genre = $request->input('genre');
        $limit = $request->input('limit') ?: 10;
        $offset = $request->input('offset') ?: 0;


        // $query = Mp3Mix::select(
        //     'tbl_mp3_mix.*',
        //     'users.artist_name as artist_name',
        //     'label_users.artist_name as label_name'
        // )->with([
        //             'release' => function ($query) {
        //                 $query->select('release_id', 'title', 'original_release_date', 'cover', 'top', 'staff_pick');
        //             },
        //         ])
        //     ->join('tbl_release', 'tbl_release.release_id', '=', 'tbl_mp3_mix.release_id')
        //     ->join('tbl_users as users', 'users.id', '=', 'tbl_release.artist')
        //     ->join('tbl_users as label_users', 'label_users.id', '=', 'tbl_release.label')
        //     ->where('tbl_release.online', 1);

        $query = DB::table('tbl_mp3_mix as t')->select(
            't.id',
            't.mp3_file',
            't.mp3_sd',
            't.flac_file',
            't.duration',
            't.mp3_preview',
            't.stream_status',
            't.stream_countries',
            't.key as track_key',
            't.gener',
            't.mix_name',
            't.song_name',
            't.bpm',
            't.waveform',
            't.green_waveform',
            't.full_wf',
            't.full_gwf',
            't.preview_starts',
            't.preview_ends',
            't.slug',
            't.user_id',
            't.release_id',
            't.id as track_id',
            'tbl_release.cover',
            'tbl_release.label',
            'tbl_release.title',
            DB::raw('(SELECT user.artist_name FROM tbl_users as user WHERE user.id = t.user_id) as artist_name'),
            DB::raw('(SELECT user.artist_name FROM tbl_users as user WHERE user.id = tbl_release.label) as label_name')
        )
            ->join('tbl_release', 'tbl_release.release_id', '=', 't.release_id');

        if ($prime == 1) {
            $query->where('tbl_release.top', 1);
        } elseif ($crew_pick == 1) {
            $query->where('tbl_release.staff_pick', 1);
        }

        if (is_array($genre) && !empty($genre)) {
            $query->whereIn('t.gener', $genre);
        } elseif (!empty($genre)) {
            $query->where('t.gener', $genre);
        }

        $query->limit($limit)->offset($offset)->orderBy('tbl_release.original_release_date', 'DESC');

        $result = $query->get();
        foreach ($result as $key => $value) {
            $fname = explode('.', $value->cover);
            $value->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
            $value->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';

            if ($value->mp3_preview != $value->mp3_file) {
                $value->preview_file_url = $this->cloud_lib->get_signed_url($value->mp3_preview, 'music_bucket', 'prev');
            } else {
                if (!is_null($value->mp3_file)) {
                    $value->preview_file_url = $this->cloud_lib->get_signed_url($value->mp3_sd, 'music_bucket', 'new_release');
                } else {
                    $value->preview_file_url = $this->cloud_lib->get_signed_url($value->mp3_file, 'music_bucket', 'new_release');
                }
            }
        }

        if ($result) {
            return TheOneResponse::ok(['tracks' => $result], 'Tracks retrieved successfully.');
        } else {
            return TheOneResponse::notFound(errorMessage: 'No Tracks found');
        }
    }

    //get top 100 streams
    public function top100_streams(Request $request)
    {
        $limit = $request->query('limit', 100);

        $startDate = Carbon::now()->subYear()->startOfWeek();
        $endDate = Carbon::now()->subDay()->endOfWeek();

        $top100Streams = DB::table('tbl_mp3_statistics as s')
            ->select(
                's.release_id',
                DB::raw('COUNT(s.track_id) as stream_qty'),
                's.track_id'
            )
            ->join('tbl_release as r', 's.release_id', '=', 'r.release_id')
            ->where('r.online', 1)
            ->where('s.type', 1)
            ->where('s.countable', 1)
            ->whereBetween('s.tstamp', [$startDate, $endDate])
            ->whereNotNull('s.release_id')
            ->where('s.track_id', '!=', 0)
            ->groupBy('s.track_id')
            ->orderByDesc('stream_qty')
            ->limit($limit)
            ->get();

        if ($top100Streams->isNotEmpty()) {
            return TheOneResponse::ok(['top100Streams' => $top100Streams], 'Top 100 retrieved successfully.');
        } else {
            return TheOneResponse::notFound(errorMessage: 'No Tracks found');
        }
    }


    //get top 100 prime
    public function top100_prime(Request $request)
    {
        $limit = $request->query('limit', 100);
        $top100_prime = SummeryTopHype::limit($limit)->get();
        if ($top100_prime->isNotEmpty()) {
            return TheOneResponse::ok(['top100_prime' => $top100_prime], 'top100 prime retrieved successfully.');
        } else {
            return TheOneResponse::notFound(errorMessage: 'No data found');
        }
    }

    //get top 100 crew pick
    public function top100_crew_pick(Request $request)
    {
        $limit = $request->query('limit', 100);
        $top100_picks = SummeryTopPicks::limit($limit)->get();
        if ($top100_picks->isNotEmpty()) {
            return TheOneResponse::ok(['top100_picks' => $top100_picks], 'top100 picks retrieved successfully.');
        } else {
            return TheOneResponse::notFound(errorMessage: 'No data found');
        }
    }

    //get top 100 releases
    public function top100_releases(Request $request)
    {
        $limit = $request->query('limit', 100);

        $startDate = Carbon::now()->subYear()->startOfWeek();
        $endDate = Carbon::now()->subDay()->endOfWeek();

        $top100_releases = DB::table('tbl_ordered_basket_items as b')
            ->select(
                'r.release_id',
                DB::raw('COUNT(b.track_id) as download_qty')
            )
            ->join('tbl_release as r', 'b.track_id', '=', 'r.id')
            ->where('r.online', 1)
            ->where('b.release_or_track', 'release')
            ->whereBetween('b.created_at', [$startDate, $endDate])
            ->groupBy('b.track_id', 'r.release_id')
            ->orderByDesc('download_qty')
            ->limit($limit)
            ->get();

        if ($top100_releases->isNotEmpty()) {
            return TheOneResponse::ok(['top100_releases' => $top100_releases], 'Top 100 releases retrieved successfully.');
        } else {
            return TheOneResponse::notFound(errorMessage: 'No data found');
        }
    }

    //get top 100 genre
    public function top100_genre(Request $request)
    {
        $limit = $request->query('limit', 100);
        $offset = $request->query('offset', 0);
        $genre = $request->input('genre');

        if (!$genre) {
            TheOneResponse::other(301, ['success' => false], 'Please provide genre.');
        }

        $startDate = Carbon::now()->subYears(2)->startOfWeek();
        $endDate = Carbon::now()->subDay()->endOfWeek();

        $result = DB::table('tbl_mp3_statistics as s')
            ->select(
                't.*',
                's.track_id',
                's.release_id',
                'r.cover',
                DB::raw('COUNT(*) as total'),
                DB::raw('GROUP_CONCAT(DISTINCT u.artist_name ORDER BY u.artist_name SEPARATOR ", ") as artist_names'),
                DB::raw('GROUP_CONCAT(DISTINCT u.id ORDER BY u.artist_name SEPARATOR ", ") as artist_ids')
            )
            ->join('tbl_mp3_mix as t', 's.track_id', '=', 't.id')
            ->join('tbl_release as r', 'r.release_id', '=', 't.release_id')
            ->Join('tbl_track_artists as a', 't.id', '=', 'a.track_id')
            ->Join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->where('r.online', 1)
            ->where('s.type', 1)
            ->where('s.countable', 1)
            ->where('r.release_date', '<=', now())
            ->whereBetween('s.tstamp', [$startDate, $endDate])
            ->where('t.gener', $genre)
            ->where('t.stream_status', 1)
            ->where(function ($query) {
                $query->whereNull('t.stream_countries')
                    ->orWhere('t.stream_countries', 'WW');
            })
            ->groupBy('s.track_id', 's.user_id')
            ->orderBy('total', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();


        // $result = DB::table('tbl_mp3_statistics as s')
        //     ->select('t.*', 's.track_id', 's.release_id', DB::raw('COUNT(*) as total'))
        //     ->join('tbl_mp3_mix as t', 's.track_id', '=', 't.id')
        //     ->join('tbl_release as r', 'r.release_id', '=', 't.release_id')
        //     ->where('r.online', 1)
        //     ->where('s.type', 1)
        //     ->where('s.countable', 1)
        //     ->where('r.release_date', '<=', DB::raw('CURDATE()'))
        //     ->whereBetween(DB::raw('DATE(s.tstamp)'), [
        //         DB::raw('CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 730 DAY'),
        //         DB::raw('CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY')
        //     ])
        //     ->where('t.gener', $genre)
        //     ->where('t.stream_status', 1)
        //     ->where(function ($query) {
        //         $query->whereNull('t.stream_countries')
        //             ->orWhere('t.stream_countries', 'WW');
        //     })
        //     ->groupByRaw('s.track_id,s.user_id')
        //     ->orderBy('total', 'DESC')
        //     ->limit($limit)
        //     ->offset($offset)
        //     ->get();

        if ($result->isEmpty()) {
            return TheOneResponse::notFound('No data found');
        }

        // $cloud_lib = new Cloud_lib();
        foreach ($result as $value) {
            $value->can_stream = 1;

            if ($value->mp3_preview != $value->mp3_file) {
                $value->preview_file_url = $this->cloud_lib->get_signed_url($value->mp3_preview, 'music_bucket', 'prev');
            } else {
                if (!is_null($value->mp3_sd)) {
                    $value->preview_file_url = $this->cloud_lib->get_signed_url($value->mp3_sd, 'music_bucket', 'new_release');
                } else {
                    $value->preview_file_url = $this->cloud_lib->get_signed_url($value->mp3_file, 'music_bucket', 'new_release');
                }
            }

            $fname = explode('.', $value->cover);
            $value->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
            $value->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';

            $value->duration_second = $this->durationToSecond($value->duration);

            // $artists = $this->getTrackArtists($value->track_id, 1);
            // $artist_name = '';
            // $artist_ids = '';

            // foreach ($artists as $key1 => $data) {
            //     if ($key1 == 0) {
            //         $artist_name = $artist_name . $data->artist_name;
            //         $artist_ids = $artist_ids . $data->id;
            //     } else {
            //         $artist_name = $artist_name . ', ' . $data->artist_name;
            //         $artist_ids = $artist_ids . ', ' . $data->id;
            //     }
            // }
            // $value->artist_name = $artist_name;
            // $value->artist_ids = $artist_ids;
        }

        return TheOneResponse::ok(['top100_genre_stream' => $result], 'Genre Hype Tracks');
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

    public function getTrackArtists($trackId, $type = null)
    {
        $query = DB::table('tbl_track_artists as a')
            ->select('u.id', 'u.artist_name', 'u.slug', 'u.image')
            ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->where('a.track_id', $trackId)
            ->groupBy('u.id');

        if (!is_null($type)) {
            $query->where('a.type', $type);
        } else {
            $query->orderBy('a.type', 'ASC');
        }

        $result = $query->get()->toArray();

        return $result;
    }


    // public function likedList($userId, $type)
    // {
    //     $likes = Follow::where('user_id', $userId)
    //         ->where('type', $type)
    //         ->pluck('following');

    //     $likedArray = [];
    //     foreach ($likes as $like) {
    //         $likedArray[$like] = true;
    //     }
    //     return $likedArray;
    // }

    // private function get_stream_download_url($user_id, $music_files)
    // {
    //     $cloud_lib = new Cloud_lib();
    //     $result = $this->getAudioPreference($user_id);
    //     if (empty($result)) {
    //         $result = $this->setAudioPreference($user_id); // Set default
    //     }
    //     switch ($result['app_stream_qlt']) {
    //         case 'mp3-128':
    //             if (!is_null($music_files['mp3_sd']) && $music_files['mp3_sd'] != "") {
    //                 $stream_file = $music_files['mp3_sd'];
    //             } else {
    //                 $stream_file = $music_files['mp3_file'];
    //             }
    //             break;

    //         case 'mp3-320':
    //             $stream_file = $music_files['mp3_file'];
    //             break;

    //         case 'flac':
    //             if (!is_null($music_files['flac_file']) && $music_files['flac_file'] != "") {
    //                 $stream_file = $music_files['flac_file'];
    //             } else {
    //                 $stream_file = $music_files['mp3_file'];
    //             }
    //             break;

    //         default:
    //             $stream_file = $music_files['mp3_file'];
    //             break;
    //     }
    //     $stream_url = $cloud_lib->get_signed_url($stream_file, 'music_bucket', 'new_release', '+5 days');

    //     switch ($result['app_download_qlt']) {
    //         case 'mp3-128':
    //             if (!is_null($music_files['mp3_sd']) && $music_files['mp3_sd'] != "") {
    //                 $download_file = $music_files['mp3_sd'];
    //             } else {
    //                 $download_file = $music_files['mp3_file'];
    //             }
    //             break;

    //         case 'mp3-320':
    //             $download_file = $music_files['mp3_file'];
    //             break;

    //         case 'flac':
    //             if (!is_null($music_files['flac_file']) && $music_files['flac_file'] != "") {
    //                 $download_file = $music_files['flac_file'];
    //             } else {
    //                 $download_file = $music_files['mp3_file'];
    //             }
    //             break;

    //         default:
    //             $download_file = $music_files['mp3_file'];
    //             break;
    //     }
    //     $download_url = $cloud_lib->get_signed_url($download_file, 'music_bucket', 'new_release', '+5 days');

    //     return ['stream_url' => $stream_url, 'download_url' => $download_url];
    // }

    // public function getAudioPreference($userId)
    // {
    //     $preference = SettingsAudio::select('app_stream_qlt', 'app_download_qlt')
    //         ->where('user_id', $userId)
    //         ->first();

    //     return $preference ? $preference->toArray() : null;
    // }

    // public function setAudioPreference($userId, array $data = [])
    // {
    //     $filteredData = array_filter($data, function ($value) {
    //         return !is_null($value) && $value !== '' && $value !== false;
    //     });

    //     $audioSetting = SettingsAudio::where('user_id', $userId)->first();

    //     if ($audioSetting) {
    //         $filteredData['modified_at'] = Carbon::now();
    //         $audioSetting->update($filteredData);
    //         return [
    //             'app_stream_qlt' => $filteredData['app_stream_qlt'] ?? $audioSetting->app_stream_qlt ?? 'mp3-128',
    //             'app_download_qlt' => $filteredData['app_download_qlt'] ?? $audioSetting->app_download_qlt ?? 'mp3-128'
    //         ];
    //     } else {
    //         $filteredData['user_id'] = $userId;
    //         SettingsAudio::create($filteredData + ['app_stream_qlt' => 'mp3-128', 'app_download_qlt' => 'mp3-128']);
    //         return ['app_stream_qlt' => 'mp3-128', 'app_download_qlt' => 'mp3-128'];
    //     }
    // }

    // Get weekly chart data
    public function weekly_chart(Request $request)
    {
        $limit = $request->input('limit', 10);
        $chart = $request->input('chart');
        $offset = $request->input('offset', 1);

        $yearweek = $this->getCurrentYearWeek();

       // $yearweek = 202435;

        // Choose chart data based on the chart type
        $charts = match ($chart) {
            'international' => $this->getInternationalCharts($limit, $yearweek),
            'download' => $this->getDownloadCharts($limit, $yearweek),
            default => $this->getRegionalCharts($chart, $limit, $yearweek),
        };

        // Process chart data if available
        if ($charts->isNotEmpty()) {
            $charts->transform(function ($value) {
                $value->can_stream = 1;
                $value->preview_file_url = $this->getPreviewUrl($value);
                //$value->artist_name = $this->formatArtistNames($value->track_id);
                $value->duration_second = $this->durationToSecond($value->duration);

                $fname = explode('.', $value->cover);
                $value->cover250x250 = 'https://images.music-worx.com/covers/' . $fname[0] . '-250x250.jpg';
                $value->cover100x100 = 'https://images.music-worx.com/covers/' . $fname[0] . '-100x100.jpg';

                return $value;
            });

            return TheOneResponse::ok(['weekly_charts' => $charts], 'Weekly chart');
        } else {
            return TheOneResponse::notFound('No data found');
        }
    }

    // Get current year-week value
    private function getCurrentYearWeek()
    {
        $today = Carbon::now()->format('D');
        $time = Carbon::now()->format('H:i:s');

        return ($today === 'Sun' || ($today === 'Sat' && $time >= '14:00:00'))
            ? Carbon::now()->format('oW')
            : Carbon::now()->subWeek()->format('oW');
    }

    // Get Preview URL based on mp3 files available
    private function getPreviewUrl($value)
    {
        // $cloud_lib = new Cloud_lib();

        return $value->mp3_preview != $value->mp3_file
            ? $this->cloud_lib->get_signed_url($value->mp3_preview, 'music_bucket', 'prev')
            : $this->cloud_lib->get_signed_url($value->mp3_sd ?? $value->mp3_file, 'music_bucket', 'new_release');
    }

    // Format artist names by fetching and concatenating them
    private function formatArtistNames($trackId)
    {
        return collect($this->getTrackArtists($trackId, 1))->pluck('artist_name')->filter()->implode(', ');
    }

    // Optimized getInternationalCharts
    private function getInternationalCharts($limit, $yearweek)
    {
        return DB::table('tbl_mp3_mix as m')
            ->join('tbl_admin_week_chart as w', 'w.track_id', '=', 'm.id')
            ->join('tbl_release as r', 'r.release_id', '=', 'm.release_id')
            ->select(
                'w.track_id',
                'w.order',
                'm.*',
                'r.cover',
                'r.label',
                'r.title',
                DB::raw('GROUP_CONCAT(DISTINCT u.artist_name ORDER BY u.artist_name SEPARATOR ", ") as artist_names')
            )
            ->join('tbl_track_artists as a', 'm.id', '=', 'a.track_id')
            ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->where('w.yearweek', $yearweek)
            ->where('w.online', 1)
            ->where('r.online', 1)
            ->where('r.release_date', '<=', now())
            ->groupBy('w.track_id', 'w.order', 'm.id', 'r.release_id')
            ->orderBy('w.order', 'asc')
            ->limit($limit)
            ->get();
    }

    // Optimized getDownloadCharts with single query
    private function getDownloadCharts($limit, $yearweek)
    {
        return DB::table('tbl_mp3_mix as m')
            ->join('tbl_download_chart as d', 'd.track_id', '=', 'm.id')
            ->join('tbl_release as r', 'r.release_id', '=', 'm.release_id')
            ->select(
                'd.track_id',
                'd.order',
                'm.*',
                'r.cover',
                'r.label',
                'r.title',
                DB::raw('GROUP_CONCAT(DISTINCT u.artist_name ORDER BY u.artist_name SEPARATOR ", ") as artist_names')
            )
            ->join('tbl_track_artists as a', 'm.id', '=', 'a.track_id')
            ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->where('d.yearweek', $yearweek)
            ->where('d.online', 1)
            ->where('r.online', 1)
            ->where('r.release_date', '<=', now())
            ->groupBy('d.track_id', 'd.order', 'm.id', 'r.release_id')
            ->orderBy('d.order', 'asc')
            ->limit($limit)
            ->get();
    }

    // Optimized getRegionalCharts with single query
    private function getRegionalCharts($region, $limit, $yearweek)
    {
        return DB::table('tbl_mp3_mix as m')
            ->join('tbl_admin_week_chart_regional as r', 'r.track_id', '=', 'm.id')
            ->join('tbl_release as rel', 'rel.release_id', '=', 'm.release_id')
            ->select(
                'r.track_id',
                'r.order',
                'm.*',
                'rel.cover',
                'rel.label',
                'rel.title',
                DB::raw('GROUP_CONCAT(DISTINCT u.artist_name ORDER BY u.artist_name SEPARATOR ", ") as artist_names')
            )
            ->join('tbl_track_artists as a', 'm.id', '=', 'a.track_id')
            ->join('tbl_users as u', 'u.id', '=', 'a.artist_id')
            ->where('r.yearweek', $yearweek)
            ->where('r.region', $region)
            ->where('r.online', 1)
            ->where('rel.online', 1)
            ->where('rel.release_date', '<=', now())
            ->groupBy('r.track_id', 'r.order', 'm.id', 'rel.release_id')
            ->orderBy('r.order', 'asc')
            ->limit($limit)
            ->get();
    }

    //not in use
    function getIndividualReleasePrice($rel, $user_id, $priceArr)
    {
        // Get the currency
        $currency =  'USD'; //getCurrency(); Ensure this is a globally accessible function
        $final_pr = 0.00;
        $rel_price = 0.00;

        // Fetch user settings
        $settings = DB::table('tbl_settings_audio')
            ->where('user_id', $user_id)
            ->first();

        if (empty($settings)) {
           // $settings = defaultAudioSettings(); // Ensure this is a globally accessible function
        }

        // Check release source
        if ($rel['release_source'] === 'website_frontend') {
            $distributor_prices = [];
            // Logic for frontend source can be added here if needed
        } else if ($rel['release_source'] === 'ftp_distributor') {
            // Fetch distributor prices
            $distributor_prices = DB::table('tbl_distributor_price_codes')
                ->where('code_for', 'album')
                ->where('distributor_id', $rel['distributor_id'])
                ->where('price_code', $rel['price_code'])
                ->first();

            if (!empty($distributor_prices)) {
                $rel_price = $currency === 'EUR'
                    ? $distributor_prices->selling_price_eur
                    : $distributor_prices->selling_price;
            }

            if (!empty($settings)) {
                switch ($settings->audio_format) {
                    case 'mp3':
                        $final_pr = $rel_price;
                        break;
                    case 'wav':
                        $final_pr = $rel_price + round($rel_price * ($priceArr['wav_additional_release'] / 100), 2);
                        break;
                    case 'flac':
                        $final_pr = $rel_price + round($rel_price * ($priceArr['flac_additional_release'] / 100), 2);
                        break;
                    default:
                        $final_pr = $rel_price;
                        break;
                }
            } else {
                $final_pr = $rel_price;
            }
        }

        return $final_pr;
    }


}












