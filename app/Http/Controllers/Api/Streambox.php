<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TheOneResponse;
use App\Libraries\Cloud_lib;
use App\Models\DjChartItems;
use App\Models\DjCharts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Streambox extends Controller
{
    protected $cloud_lib;
    public function __construct()
    {
        $this->cloud_lib = new Cloud_lib();
    }


    //  public function getCharts() {
    //     $user_id = $this->input->post('user_id');
    //     $result = $this->Api_model->latest_playlists(5, $user_id);
    //     if (!empty($result)) {
    //         echo json_encode($result);
    //     } else {
    //         echo json_encode('No records found');
    //     }
    // }

    public function getCharts(Request $request)
    {
        $user_id = $request->input('user_id');
        $limit = $request->input('limit', 5);

        //$json_data = array();

        // $charts = DjCharts::where('is_published', 1)
        //     ->where('user_id', $user_id)
        //     ->orderBy('published_at', 'DESC')
        //     ->take($limit)
        //     ->get();

        $charts = DjCharts::with([
            'items.track.release:release_id,cover,original_release_date,label',
            'items.track.artists:id,artist_name,image,parent_label_id',
            'user',
        ])
            ->where('is_published', 1)
            ->where('user_id', $user_id)
            ->orderBy('published_at', 'DESC')
            ->take($limit)
            ->get();

        if ($charts->isEmpty()) {
            return TheOneResponse::notFound('No Data Found.');
        }

        $final_data = [];
        $user = User::findOrFail($user_id);
        foreach ($charts as $chart) {
            if ($chart->photo_cover) {
                if ($chart->chart_image_url) {
                    $chart->chart_image_url = 'https://prostg.music-worx.com/uploads/awsdownloads/' . $user_id . '/' . $chart->chart_image_url;
                    $chart->photo_cover = $chart->chart_image_url;
                } else {
                    $chart->chart_image_url = 'https://prostg.music-worx.com/static/img/Playlist-Image-Default.jpg';
                }
            } else {
                $chart->chart_image_url = 'https://prostg.music-worx.com/static/img/Playlist-Image-Default.jpg';
            }

            $chart->image = $this->getImageUrl($user->image, 'users');
            $chart->link = 'https://prostg.music-worx.com/dj-top10-chart' . '/' . $user->slug . '/' . $chart->slug . '/' . $chart->id;
            $chart->user_name = $user->artist_name;

            foreach ($chart->items as $item) {
                $label = $item->track->release->label;
               // $label_image = User::select('image')->where('usertype','label')->where('id',$label);
                if (!is_numeric($label)) {
                    $item->track->label_name = $label;
                } else {
                    $labelName = User::where('id', $label)->value('artist_name');
                    $item->track->label_name = $labelName ?: '';
                }

                // dd('$label_image');

                // $fname = explode('.', $label_image);
                // $item->track->label_image = 'https://s3.eu-central-1.wasabisys.com/images.music-worx.com/users/' . $fname[0] . '-250x250.jpg';

               // $label_slug  = Str::slug($item->track->label_name);
               // $label_image = $this->getImage(Str::slug($item->track->label_name));
                //$item->track->label_image = $this->getImageUrl(Str::slug($item->track->label_name), 'users');
                $item->track->artist_names = $item->track->artists->pluck('artist_name')->join(', ');
                $artist_image = $item->track->artists->pluck('image');
                if ($artist_image == '' && $$item->track->artists->parent_label_id != '') {
                    $artist_image = $this->getArtistImage($item->track->artists->parent_label_id);
                }

                $item->track->artist_image_urls = $artist_image->map(function ($image) {
                    return $image
                        ? 'https://images.music-worx.com/users/' . $image
                        : 'https://prostg.music-worx.com/static/img/artist-img.jpeg';
                });


                // $ch = curl_init("https://music.music-worx.com/new_release/" . $item->track->mp3_file);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch, CURLOPT_HEADER, true);
                // curl_setopt($ch, CURLOPT_NOBODY, true);
                // $data = curl_exec($ch);
                // $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                // curl_close($ch);

                $flac_status = 0;
                if (isset($item->track->flac_file) && !empty($item->track->flac_file)) {
                    $flac_status = 1;
                }
                $item->track->flac_status = $flac_status;




                // $item->track->artist_image->artist_image_url = (isset($artist_image)) ? 'https://images.music-worx.com/topdjs/users' . $artist_image : url('uploads/covers/artist-img.jpeg');

                // $label = $item->track->release->label;
                // if (is_numeric($label)) {
                //     $labelName = User::where('id', $label)->value('artist_name');
                //     $item->track->label_name = $labelName ?: '';
                // }

                $item->track->fileFormat = "mp3_file";
                ;

                unset($item->track->artists);
                //unset($item->track->release);
            }
        }

        return TheOneResponse::ok(['charts' => $charts], 'data retrieved successfully.');


        foreach ($charts as $chart) {
            $finalData = [];

            // $tracks = DjChartItems::select('ci.track_id','ci.release_id','m.song_name','m.id','m.gener as genre','m.bpm','m.isrc_code','r.cover',
            //     'm.duration','r.title','ta.artist_id as artist','r.original_release_date as release_date','m.mp3_file','m.remixer','u.artist_name as label','m.mix_name',
            //     'u.image as label_image','u.id as user_id','m.flac_file','m.waveform','m.green_waveform','m.full_gwf','m.full_wf','m.key'
            // )->from('tbl_dj_chart_items as ci')->join('tbl_mp3_mix as m', 'm.id', '=', 'ci.track_id')
            //     ->leftJoin('tbl_release as r', 'm.release_id', '=', 'r.release_id')
            //     ->leftJoin('tbl_track_artists as ta', 'r.release_id', '=', 'ta.release_id')
            //     ->leftJoin('tbl_users as u', 'r.label', '=', 'u.id')
            //     ->where('ta.type', 1)
            //     ->where('ci.chart_id', $chart->id)
            //     ->groupBy('ci.track_id')
            //     ->orderBy('ci.order', 'ASC')
            //     ->take(10)
            //     ->get();


            foreach ($tracks as $track) {
                // $commentResult = $this->getUserComment($user_id, $track['track_id']);

                // if ($track['label'] == "") {
                //     if (is_numeric($track['label'])) {
                //         $label_name = "";
                //     } else {
                //         $label_name = $track['label'];
                //     }
                // } else {
                //     $label_name = $track['label'];
                // }

                $ch = curl_init("https://music.music-worx.com/new_release/" . $track['mp3_file']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                $data = curl_exec($ch);
                $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                curl_close($ch);

                $fileFormat = "mp3_file";

                $flac_status = 0;
                if (isset($track['flac_file']) && !empty($track['flac_file'])) {
                    $flac_status = 1;
                }

                $dir_name = './uploads/awsdownloads/' . $user_id;
                // echo "<pre>";print_r($dir_name); echo "</pre>"; die("test");
                if (!is_dir($dir_name)) {
                    mkdir($dir_name, 0777, true);
                    $dir = $dir_name . '/' . $track['id'];
                    mkdir($dir, 0777, true);
                } else {
                    $dir = $dir_name . '/' . $track['id'];
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                }


                $url = $this->cloud_lib->get_signed_url($track['mp3_file'], 'music_bucket', 'new_release', '+5 days');

                //$flac_url = $this->cloud_lib->get_signed_url($row['flac_file'], 'music_bucket', 'new_release');
                //$flacfile = $this->cloud_lib->get_file($row['flac_file'], 'music_bucket', 'new_release');
                $flac_url = "";

                $artist = User::where('id', $track->artist)
                    ->where('usertype', 'artist')
                    ->first(['artist_name', 'image', 'parent_label_id']);

                //$artist = $this->db->query("SELECT artist_name,image,parent_label_id FROM tbl_users WHERE usertype = 'artist' && id = " . $track['artist'])->row_array();
                if ($artist['image'] == '' && $artist['parent_label_id'] != '') {
                    $artist_image = $this->getArtistImage($artist['parent_label_id']);
                }

                $final_data[] = array(
                    "release_id" => $track['release_id'],
                    "track_id" => $track['track_id'],
                    "song_name" => $track['song_name'],
                    "genre" => $track['gener'],
                    "bpm" => $track['bpm'],
                    "isrc_code" => $track['isrc_code'],
                    "song" => $url,
                    "cover_image" => $track['cover'],
                    "cover" => "https://s3.eu-central-1.wasabisys.com/images.music-worx.com/covers/" . $track['cover'],
                    "duration" => $track['duration'],
                    "title" => $track['song_name'],
                    "artist" => $artist['artist_name'],
                    "release_date" => $track['release_date'],
                    $fileFormat => $track['mp3_file'],
                    "remixer" => $track['remixer'],
                    "label" => $label_name,
                    'filesize' => $size,
                    'comment' => isset($commentResult['comment']) ? $commentResult['comment'] : '',
                    'rating' => isset($commentResult['rating']) ? $commentResult['rating'] : '',
                    'label_image' => $this->getImage($track['label']),
                    'label_image_url' => $this->getImageUrl($track['label'], 'users'),
                    'artist_image' => (isset($artist_image)) ? $artist_image : $artist['image'],
                    'artist_image_url' => (isset($artist_image)) ? 'https://images.music-worx.com/topdjs/users' . $artist_image : 'https://images.music-worx.com/topdjs/users' . $artist['image'],
                    'is_flac' => $flac_status,
                    'flac_file' => $track['flac_file'],
                    'flac_url' => $flac_url,
                    'waveform_name' => $track['full_wf'],
                    'green_waveform_name' => $track['full_gwf'],
                    'waveform' => 'https://images.music-worx.com/waveforms/' . $track['full_wf'],
                    'green_waveform' => 'https://images.music-worx.com/waveforms/' . $track['full_gwf'],
                    'key' => $track['key']
                );
            }


            $user = User::findOrFail($chart['user_id']);

            //$user = $this->User_model->get_user($chart['user_id'])->row_array();

            if ($chart['photo_cover']) {
                //$converted_image = $this->convertToPng($user_id, $chart['photo_cover'], 'chart');
                if ($chart['chart_image_url']) {
                    $chart['chart_image_url'] = 'https://prostg.music-worx.com/uploads/awsdownloads/' . $user_id . '/' . $chart['chart_image_url'];
                    $chart['photo_cover'] = $chart['chart_image_url'];
                } else {
                    $chart['chart_image_url'] = 'https://prostg.music-worx.com/static/img/Playlist-Image-Default.jpg';
                }
            } else {
                $chart['chart_image_url'] = 'https://prostg.music-worx.com/static/img/Playlist-Image-Default.jpg';
            }

            $charts_data[] = [
                'image' => $this->getImageUrl($user['image'], 'users'),
                'link' => 'https://prostg.music-worx.com/dj-top10-chart' . '/' . $user['slug'] . '/' . $chart['slug'] . '/' . $chart['id'],
                'user_name' => $user['artist_name'],
                //'chart' => $chart,
                // 'tracks_chart' => $final_data,
            ];
        }
        return TheOneResponse::ok(['charts_data' => $charts_data, 'Chart data retrived successfully.']);
    }




    public function getArtistImage($id)
    {
        if ($id != null) {
            $artist = DB::table('tbl_users')
                ->select('image')
                ->where('id', $id)
                ->first();
        }

        if (!$artist || empty($artist->image)) {
            return url('uploads/covers/artist-img.jpeg');
        }

        return $artist->image;
    }

    private function getImageUrl($image, $folder)
    {
        $baseUrl = "https://s3.eu-central-1.wasabisys.com/images.music-worx.com/{$folder}/";
        $fileNameParts = explode('.', $image);
        $img = "";

        if ($fileNameParts[0] !== 'default') {
            $optimizedImageUrl = $baseUrl . $fileNameParts[0] . '-250x250.jpg';

            if ($this->img_exists($optimizedImageUrl) === "404") {
                $img = $baseUrl . $image;
            } else {
                $img = $optimizedImageUrl;
            }
        }

        return $img;
    }


    private function getImage($image)
    {
        $fileNameParts = explode('.', $image);
        $img = "";

        if ($fileNameParts[0] !== 'default') {
            $img = $fileNameParts[0] . '-250x250.jpg';
        }

        return $img;
    }

    public function getUserComment($userId, $trackId)
    {
        $result = DB::table('tbl_user_comments_ratings')
            ->where('user_id', $userId)
            ->where('track_id', $trackId)
            ->first();

        if ($result) {
            return (array) $result;
        } else {
            return 0;
        }
    }

    function img_exists($url)
    {
        $result = -1;

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($curl);
        curl_close($curl);

        if ($data) {
            $content_length = "unknown";
            $status = "unknown";

            if (preg_match("/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches)) {
                $status = (int) $matches[1];
            }

            if (preg_match("/Content-Length: (\d+)/", $data, $matches)) {
                $content_length = (int) $matches[1];
            }

            // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
            if ($status == 200 || ($status > 300 && $status <= 308)) {
                $result = $content_length;
            }
        }

        if ($result < 1) {
            $exist = '404';
        } else {

            $exist = '200';
        }

        return $exist;

    }

}



//commented code
// public function getTopStreams()
//     {
//         $user_id = $this->input->post('user_id');
//         $limit = $this->input->post('limit');
//         $offset = $this->input->post('offset');
//         if ($offset >= 1) {
//             $offset = ($offset * $limit) - $limit;
//         } else {
//             $offset = 0;
//         }

//         if (!$user_id) {
//             self::response(301, false, null, 'Please provide user id.');
//             exit;
//         }

//         if (!$limit) {
//             $limit = '10';
//         }
//         $resultList = $this->Apimobile_model->get_stream_chart_new($limit, $offset);

//         if ($resultList) {
//             $liked_list = $this->Apimobile_model->liked_list($user_id, 'track');
//             foreach ($resultList as $key => $value) {

//                 $resultList[$key]['can_stream'] = 1; // already checked in query


//                 if (isset($liked_list[$value['track_id']]) && $liked_list[$value['track_id']])
//                     $resultList[$key]['liked'] = 1;
//                 else
//                     $resultList[$key]['liked'] = 0;

//                 // Get Preview URL
//                 if ($value['mp3_preview'] != $value['mp3_file']) {
//                     $previewUrl = $this->cloud_lib->get_signed_url($value['mp3_preview'], 'music_bucket', 'prev');
//                 } else {
//                     if (!is_null($value['mp3_sd'])) {
//                         $previewUrl = $this->cloud_lib->get_signed_url($value['mp3_sd'], 'music_bucket', 'new_release');
//                     } else {
//                         $previewUrl = $this->cloud_lib->get_signed_url($value['mp3_file'], 'music_bucket', 'new_release');
//                     }
//                 }
//                 $resultList[$key]['preview_file_url'] = $previewUrl;

//                 // Get User Preferential urls
//                 $music_files = [
//                     'mp3_file' => $value['mp3_file'],
//                     'mp3_sd' => $value['mp3_sd'],
//                     'flac_file' => $value['flac_file']
//                 ];
//                 // Get Stream and Download URL
//                 $preferential_urls = $this->get_stream_download_url($user_id, $music_files);
//                 $resultList[$key]['download_url'] = $preferential_urls['download_url'];
//                 $resultList[$key]['stream_url'] = $preferential_urls['stream_url'];

//                 $resultList[$key]['duration_second'] = $this->Apimobile_model->durationToSecond($value['duration']);

//                 $artists = $this->Apimobile_model->get_track_artists($value['track_id'], 1);

//                 $artist_name = '';
//                 foreach ($artists as $key1 => $data) {
//                     if ($key1 == 0) {
//                         $artist_name = $artist_name . $data['artist_name'];
//                     } else {
//                         $artist_name = $artist_name . ', ' . $data['artist_name'];
//                     }
//                 }
//                 $resultList[$key]['artist_name'] = $artist_name;

//                 $resultList[$key]['track_key'] = $resultList[$key]['key'];

//                 // Unset unwanted fields
//                 unset($resultList[$key]['key']);

//                 $fname = explode('.', $value['cover']);
//                 $resultList[$key]['cover250x250'] = COVERPIC . $fname[0] . '-250x250.jpg';
//                 $resultList[$key]['cover100x100'] = COVERPIC . $fname[0] . '-100x100.jpg';
//             }
//             self::response(200, true, $resultList, 'Top stream list');
//         } else {
//             self::response(404, false, null, 'No data found');
//         }

//     }
//     public function get_stream_chart_new($limit=100, $offset){
//         return $this->db->query("
//             SELECT s.release_id, r.*,tbl_mp3_mix.*,
//                 COUNT(s.track_id) AS stream_qty, s.track_id
//                 FROM tbl_mp3_statistics s, tbl_release r, tbl_mp3_mix
//                 WHERE s.release_id=r.release_id
//                 AND s.track_id = tbl_mp3_mix.id
//                 AND r.online=1
//                 AND s.type=1
//                 AND s.countable=1
//                 AND DATE(r.original_release_date) BETWEEN CURDATE() - INTERVAL 183 DAY AND CURDATE() - INTERVAL 1 DAY
//                 AND r.release_date<=CURDATE()
//                 AND s.release_id!='' AND s.track_id!=0
//                 AND tbl_mp3_mix.stream_status=1
//                 AND (tbl_mp3_mix.stream_countries IS NULL || tbl_mp3_mix.stream_countries='WW' || FIND_IN_SET('".$this->_isoCode()."', tbl_mp3_mix.stream_countries))
//                 GROUP BY s.track_id
//                 ORDER BY stream_qty DESC LIMIT ".$limit." OFFSET ".$offset
//         )->result_array();
//     }

//     public function get_latest_artist_charts($user_id, $limit,$chart_id=NULL){
//         $append ='';
//          if($chart_id!=null)
//          $append = ' AND dc.id !='. $chart_id . ' ';
//          return $this->db->query("SELECT
//              dc.*, u.artist_name, u.image,
//              dc.photo_cover as dc_cover
//              FROM tbl_dj_charts as dc, tbl_users u
//              WHERE dc.is_published=1 AND u.id = dc.user_id AND dc.user_id=".$user_id."
//              ".$append."
//              ORDER BY dc.published_at DESC limit ".$limit)->result_array();
//      }
