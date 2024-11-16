<?php

namespace App\Http\Controllers;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElasticSearch extends Controller
{
    public $_isoCode;
    public $client;
    function __construct()
    {
        $hosts = [
            [
                'host' => 'mwstore.music-worx.com',
                'scheme' => 'https',
                'port' => 443,
                'user' => 'admin',
                'pass' => 'hyrin',
            ]
        ];

        try {
            $this->client = ClientBuilder::create()
                ->setHosts($hosts)
                ->setConnectionParams([
                    'client' => [
                        'timeout' => 10,
                        'connect_timeout' => 10
                    ]
                ])
                ->build();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->_isoCode = 0;
    }

    public function search_releases($term, $num_rec_per_page, $start_from, $promoted = 0)
    {

        $countries = ['WW'];
        // if($this->_isoCode()!='WW'){
        // 	array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        $exclude_genre = array(1, "Jazz", "Funk & Soul", "Reggae / Dub", "Ambient", "Lounge / Chill Out");
        foreach ($exclude_genre as $genre) {
            array_push($must_not, ['term' => ['gener.keyword' => $genre]]); // .keyword for exact match
        }
        // Query
        $params = [
            'index' => 'mw_releases',
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'nested' => [
                                    'path' => 'tracks', // Assuming 'tracks' is the name of your nested field
                                    'query' => [
                                        'multi_match' => [
                                            'query' => $term,
                                            'fields' => ['tracks.song_name', 'tracks.mix_name'],
                                        ],
                                    ],
                                ],
                            ],
                            [
                                'multi_match' => [
                                    'query' => $term,
                                    'fields' => ['title^3', 'artists.artist_name^2', 'description']
                                ]
                            ],
                        ],
                        'minimum_should_match' => 1,
                        'filter' => [
                            'bool' => [
                                'must_not' => $must_not,
                                'must' => [
                                    ['exists' => ['field' => 'slug']],
                                    [
                                        'term' => [
                                            'online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'release_date' => [
                                                'lte' => date('Y-m-d')
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    "_score" => ["order" => "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];
        if ($promoted) {
            // Search only Promoted releases
            $params['body']['query']['bool']['filter']['bool']['must'][] = ['term' => ['is_promoted' => true]];
        }
        try {
            $response = $this->client->search($params);
        } catch (\Exception $e) {
            // Log or handle the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }


        $found_releases = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            array_push($found_releases, $value['_source']);
        }

        return ['releases' => $found_releases, 'total' => $response['hits']['total']['value']];
    }

    public function search_tracks($term, $num_rec_per_page, $start_from)
    {
        $params = [
            'index' => 'mw_tracks',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $term,
                        'fields' => ['song_name^3', 'artists.artist_name^2', 'mix_name']
                    ]
                ],
                "sort" => [
                    "_score" => ["order" => "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => 500,
                'from' => 0,
            ]
        ];
        $response = $this->client->search($params);
        $found_tracks = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            array_push($found_tracks, $value['_source']['id']);
        }

        return [
            'tracks' => $this->elastic_tracks_search($num_rec_per_page, $start_from, $found_tracks),
            'total' => count($this->elastic_tracks_search(null, null, $found_tracks))
        ];
    }



    private function elastic_tracks_search($per_page, $page, $found_tracks, $user_cap_ger = array(), $show_my_genres_only = 'false', $show_hypes_only = 'false', $show_staff_picks_only = 'false')
    {
        if (count($found_tracks) == 0) {
            return false;
        }

        $exclude_genre = array(1, "Jazz", "Funk & Soul", "Reggae / Dub", "Ambient", "Lounge / Chill Out");
        $exclude_genre = implode("', '", $exclude_genre);
        $append = $append2 = "";
        if ($show_my_genres_only == 'true') {
            $user_cap_ger_string = implode("', '", $user_cap_ger);
            $append = " AND t.gener IN ('" . $user_cap_ger_string . "') ";
        }
        if ($show_hypes_only == 'true' && $show_staff_picks_only == 'false') {
            $append .= " AND t.hype=1 ";
        } else if ($show_staff_picks_only == 'true' && $show_hypes_only == 'false') {
            $append .= " AND t.pick=1 ";
        } else if ($show_staff_picks_only == 'true' && $show_hypes_only == 'true') {
            $append .= " AND (t.hype=1 OR t.pick=1) ";
        } else {
            $append .= "";
        }

        $tracks_string = implode("', '", $found_tracks);
        $append .= " AND t.id IN ('" . $tracks_string . "') ";

        $limitString = '';
        if ($per_page) {
            $limitString .= "LIMIT " . $per_page . " OFFSET " . $page;
        }

        // $query = DB::table('tbl_release as r')
        //     ->join('tbl_mp3_mix as t', 'r.release_id', '=', 't.release_id')
        //     ->join('tbl_users as u', function ($join) {
        //         $join->on(DB::raw("IF(CONCAT('',r.label * 1), r.label, r.user_id)"), '=', 'u.id');
        //     })
        //     ->select('t.id as track_id')
        //     ->where(function ($query) {
        //         $query->whereColumn('r.release_ref', '=', 'r.release_id')
        //             ->orWhereNull('r.release_ref');
        //     })
        //     ->where('r.online', 1)
        //     ->whereDate('r.release_date', '<=', 'CURDATE()')
        //     ->whereNotNull('r.slug')
        //     ->where('r.countries', 'WW')
        //     ->where(function ($query) {
        //         $query->whereNull('t.stream_countries')
        //             ->orWhere('t.stream_countries', 'WW');
        //     })
        //     ->where('t.stream_status', 1)
        //     ->whereNotIn('r.gener', explode(',', $exclude_genre))
        //     ->groupBy('track_id');

        // // Append additional conditions if any
        // if (!empty($append)) {
        //     $query->whereRaw($append);
        // }

        // // Order by FIELD equivalent in Laravel
        // $query->orderByRaw("FIELD(t.id, {$tracks_string})");

        // // Apply limit if provided
        // if (!empty($limit)) {
        //     $query->limit($limit);
        // }

        // return $query->get()->toArray();

         return DB::select(" SELECT t.id AS track_id
        FROM tbl_release AS r,
        tbl_mp3_mix as t, tbl_users u
        WHERE
        r.release_id=t.release_id
        AND (r.release_ref=r.release_id OR r.release_ref IS NULL )
        AND r.online=1
        AND DATE(r.release_date)<=CURDATE()
        " . $append . "
        AND r.slug IS NOT NULL
        AND (r.countries='WW')
        AND (t.stream_countries IS NULL || t.stream_countries='WW')
        AND t.stream_status=1
        AND r.gener NOT IN ('" . $exclude_genre . "')
        AND IF(CONCAT('',r.label * 1), r.label, r.user_id) = u.id
        GROUP BY track_id
        ORDER BY FIELD(t.id, '" . $tracks_string . "')
        " . $limitString);
    }

    //|| FIND_IN_SET('" . $this->_isoCode() . "',r.countries)

    public function search_labels($term, $num_rec_per_page, $start_from)
    {
        $params = [
            'index' => 'mw_users',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $term,
                                'fields' => ['artist_name^3']
                            ]
                        ],
                        'filter' => [
                            'bool' => [
                                'filter' => [
                                    [
                                        'terms' => [
                                            'usertype' => ['label', 'sub_label'],
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'total_releases' => [
                                                'gt' => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    "_score" => ["order" => "desc"],
                    "last_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];
        $response = $this->client->search($params);
        $found_labels = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            array_push($found_labels, $value['_source']);
        }

        return ['labels' => $found_labels, 'total' => $response['hits']['total']['value']];
    }

    public function search_artists($term, $num_rec_per_page, $start_from)
    {
        $params = [
            'index' => 'mw_users',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $term,
                                'fields' => ['artist_name^3']
                            ]
                        ],
                        'filter' => [
                            'bool' => [
                                'filter' => [
                                    [
                                        'term' => [
                                            'usertype' => 'artist',
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'total_tracks' => [
                                                'gt' => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    "_score" => ["order" => "desc"],
                    "last_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];
        $response = $this->client->search($params);
        $found_artists = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            array_push($found_artists, $value['_source']);
        }
        return ['artists' => $found_artists, 'total' => $response['hits']['total']['value']];
    }

    public function search_djtop10s($term, $num_rec_per_page, $start_from)
    {
        $params = [
            'index' => 'mw_djtop10s',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $term,
                                'fields' => ['name^3', 'artist_name']
                            ]
                        ],
                        'filter' => [
                            [
                                'term' => [
                                    'is_published' => 1,
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    "_score" => ["order" => "desc"],
                    "published_at" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];
        $response = $this->client->search($params);
        $found_djtop10s = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            array_push($found_djtop10s, $value['_source']);
        }
        return ['djtop10s' => $found_djtop10s, 'total' => $response['hits']['total']['value']];
    }

    public function get_label_releases($label, $num_rec_per_page = 24, $start_from = 0, $genre = "", $fromdate = "", $todate = "", $type = "", $pre_order = "", $exclude_rel = [])
    {
        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        $exclude_genre = array(1, "Jazz", "Funk & Soul", "Reggae / Dub", "Ambient", "Lounge / Chill Out");
        foreach ($exclude_genre as $ex_genre) {
            array_push($must_not, ['term' => ['gener.keyword' => $ex_genre]]); // .keyword for exact match
        }
        foreach ($exclude_rel as $rel) {
            array_push($must_not, ['term' => ['release_id.keyword' => $rel]]); // .keyword for exact match
        }
        // Query
        $params = [
            'index' => 'mw_releases',
            'body' => [
                'aggs' => [
                    'unique_genres' => ['terms' => ['field' => 'gener.keyword', 'size' => 1000]]
                ],
                // '_source'=> ["release_id", 'gener', 'label'],
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                'must_not' => $must_not,
                                'must' => [
                                    ['exists' => ['field' => 'slug']],
                                    [
                                        'term' => [
                                            'label.keyword' => $label,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'countries.country' => $countries,
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    // "_score"=> ["order"=> "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];

        if ($genre != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'gener.keyword' => $genre
                ]
            ];
        }

        if ($fromdate) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'original_release_date' => ['lte' => $todate, 'gte' => $fromdate]
                ]
            ];
        }

        if ($pre_order) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'bool' => [
                    'minimum_should_match' => 1,
                    'should' => [
                        ['range' => ['release_date' => ['lte' => date('Y-m-d')]]],
                        [
                            'bool' => [
                                'must' => [
                                    ['term' => ['preorder' => true]],
                                    ['range' => ['preorder_start_date' => ['lte' => date('Y-m-d')]]],
                                    ['terms' => ['preorder_countries.country' => $countries]],
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'release_date' => [
                        'lte' => date('Y-m-d')
                    ]
                ]
            ];
        }

        if ($type != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'release_type.keyword' => $type
                ]
            ];
        }

        $response = $this->client->search($params);
        // print_r($response);exit;
        $found_releases = [];
        $genres = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_releases, $value['_source']);
        }
        foreach ($response['aggregations']['unique_genres']['buckets'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($genres, $value['key']);
        }
        // print_r($response['hits']['total']['value']); //exit;
        return [
            'releases' => $found_releases,
            'total' => $response['hits']['total']['value'],
            'genres' => $genres
        ];
    }

    public function get_artist_releases($artist_id, $num_rec_per_page = 24, $start_from = 0, $genre = "", $label = "", $fromdate = "", $todate = "", $pre_order = "", $exclude_rel = [])
    {
        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        $exclude_genre = array(1, "Jazz", "Funk & Soul", "Reggae / Dub", "Ambient", "Lounge / Chill Out");
        foreach ($exclude_genre as $ex_genre) {
            array_push($must_not, ['term' => ['gener.keyword' => $ex_genre]]); // .keyword for exact match
        }
        foreach ($exclude_rel as $rel) {
            array_push($must_not, ['term' => ['release_id.keyword' => $rel]]); // .keyword for exact match
        }
        // Query
        $params = [
            'index' => 'mw_releases',
            'body' => [
                'aggs' => [
                    'unique_genres' => ['terms' => ['field' => 'gener.keyword', 'size' => 1000]],
                    'unique_labels' => ['terms' => ['field' => 'label.keyword', 'size' => 1000]]
                ],
                '_source' => ["release_id", 'gener', 'label'],
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                'must_not' => $must_not,
                                'must' => [
                                    ['exists' => ['field' => 'slug']],
                                    [
                                        'term' => [
                                            'artists.id' => $artist_id,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'countries.country' => $countries,
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    // "_score"=> ["order"=> "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];

        if ($genre != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'gener.keyword' => $genre
                ]
            ];
            // $params['body']['query']['bool']['filter']['bool']['must'][]=[
            // 	'nested'=>[
            // 		'path'=>'tracks',
            // 		'query'=>[
            // 			'bool'=>[
            // 				'must'=>[
            // 					[
            // 						'term'=>[
            // 							'tracks.gener.keyword'=>$genre
            // 						]
            // 					],
            // 					[
            // 						'term'=>[
            // 							'tracks.artists.id'=>$artist_id
            // 						]
            // 					]
            // 				]
            // 			]
            // 		]
            // 	]
            // ];
        }

        if ($label != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'label.keyword' => $label
                ]
            ];
        }

        if ($fromdate) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'original_release_date' => ['lte' => $todate, 'gte' => $fromdate]
                ]
            ];
        }

        if ($pre_order) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'bool' => [
                    'minimum_should_match' => 1,
                    'should' => [
                        ['range' => ['release_date' => ['lte' => date('Y-m-d')]]],
                        [
                            'bool' => [
                                'must' => [
                                    ['term' => ['preorder' => true]],
                                    ['range' => ['preorder_start_date' => ['lte' => date('Y-m-d')]]],
                                    ['terms' => ['preorder_countries.country' => $countries]],
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'release_date' => [
                        'lte' => date('Y-m-d')
                    ]
                ]
            ];
        }

        $response = $this->client->search($params);
        // print_r($response);exit;
        $found_releases = [];
        $labels = [];
        $genres = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_releases, $value['_source']);
        }
        foreach ($response['aggregations']['unique_labels']['buckets'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($labels, $value['key']);
        }
        foreach ($response['aggregations']['unique_genres']['buckets'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($genres, $value['key']);
        }
        // print_r($response['hits']['total']['value']); //exit;
        return [
            'releases' => $found_releases,
            'total' => $response['hits']['total']['value'],
            'labels' => $labels,
            'genres' => $genres
        ];
    }

    public function get_all_tracks($num_rec_per_page = 24, $start_from = 0, $genre = "", $artist_id = "", $label = "", $fromdate = "", $todate = "", $pre_order = "", $exclude_rel = [])
    {
        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        $exclude_genre = array(1, "Jazz", "Funk & Soul", "Reggae / Dub", "Ambient", "Lounge / Chill Out");
        foreach ($exclude_genre as $ex_genre) {
            array_push($must_not, ['term' => ['gener.keyword' => $ex_genre]]); // .keyword for exact match
        }
        foreach ($exclude_rel as $rel) {
            array_push($must_not, ['term' => ['release_id.keyword' => $rel]]); // .keyword for exact match
        }
        // Query
        $params = [
            'index' => 'mw_tracks',
            'body' => [
                'aggs' => [
                    'unique_genres' => ['terms' => ['field' => 'gener.keyword', 'size' => 1000]],
                    'unique_labels' => ['terms' => ['field' => 'label.keyword', 'size' => 1000]]
                ],
                '_source' => ["id", "release_id", 'gener', 'label'],
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                'must_not' => $must_not,
                                'must' => [
                                    [
                                        'term' => [
                                            'rel_online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'rel_countries.country' => $countries,
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    // "_score"=> ["order"=> "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];

        if ($genre != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'gener.keyword' => $genre
                ]
            ];
        }

        if ($artist_id != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'artists.id' => $artist_id,
                ]
            ];
        }

        if ($label != "") {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'term' => [
                    'label.keyword' => $label
                ]
            ];
        }

        if ($fromdate) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'original_release_date' => ['lte' => $todate, 'gte' => $fromdate]
                ]
            ];
        }

        if ($pre_order) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'bool' => [
                    'minimum_should_match' => 1,
                    'should' => [
                        ['range' => ['release_date' => ['lte' => date('Y-m-d')]]],
                        [
                            'bool' => [
                                'must' => [
                                    ['term' => ['preorder' => true]],
                                    ['range' => ['preorder_start_date' => ['lte' => date('Y-m-d')]]],
                                    ['terms' => ['preorder_countries.country' => $countries]],
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        } else {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'release_date' => [
                        'lte' => date('Y-m-d')
                    ]
                ]
            ];
        }

        $response = $this->client->search($params);
        // print_r($response);exit;
        $found_tracks = [];
        $labels = [];
        $genres = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_tracks, $value['_source']);
        }
        foreach ($response['aggregations']['unique_labels']['buckets'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($labels, $value['key']);
        }
        foreach ($response['aggregations']['unique_genres']['buckets'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($genres, $value['key']);
        }
        // print_r($response['hits']['total']['value']); //exit;
        return [
            'tracks' => $found_tracks,
            'total' => $response['hits']['total']['value'],
            'labels' => $labels,
            'genres' => $genres
        ];
    }

    public function get_genre_releases($genre, $num_rec_per_page = 24, $start_from = 0, $exclude_rel = [])
    {
        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        // $exclude_genre=$this->config->item('exclude_genre');
        // foreach ($exclude_genre as $genre) {
        // 	array_push($must_not, ['term'=>['gener.keyword'=>$genre]]); // .keyword for exact match
        // }
        foreach ($exclude_rel as $rel) {
            array_push($must_not, ['term' => ['release_id.keyword' => $rel]]); // .keyword for exact match
        }
        // Query
        $params = [
            'index' => 'mw_releases',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                'must_not' => $must_not,
                                'must' => [
                                    ['exists' => ['field' => 'slug']],
                                    [
                                        'term' => [
                                            'gener.keyword' => $genre,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'release_date' => [
                                                'lte' => date('Y-m-d')
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    "top" => ["order" => "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];
        $response = $this->client->search($params);
        // print_r($response);
        $found_releases = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_releases, $value['_source']);
        }
        // print_r($response['hits']['total']['value']); //exit;
        return ['releases' => $found_releases, 'total' => $response['hits']['total']['value']];
    }

    public function getGenreTopTracks($genre, $limit, $period = null)
    {
        return DB::table('summery_top_genres')
            ->select('track_id', 'release_id', 'qty as total')
            ->where('genre', $genre)
            ->orderBy('qty', 'DESC')
            ->limit($limit)
            ->get()
            ->toArray();
    }


    public function get_recommended_tracks($genre, $num_rec_per_page = 30, $start_from = 0, $exclude_tracks = [])
    {

        // $this->load->model('Genre_model');
        $toptracks = $this->getGenreTopTracks($genre, 20);
        $track_array = array_column($toptracks, 'track_id');

        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        // $exclude_genre=$this->config->item('exclude_genre');
        // foreach ($exclude_genre as $genre) {
        // 	array_push($must_not, ['term'=>['gener.keyword'=>$genre]]); // .keyword for exact match
        // }
        foreach ($exclude_tracks as $track) {
            array_push($must_not, ['term' => ['id' => $track]]); // .keyword for exact match
        }
        // Query
        $params = [
            'index' => 'mw_tracks',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                'must_not' => $must_not,
                                'must' => [
                                    [
                                        'term' => [
                                            'gener.keyword' => $genre,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'rel_online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'rel_countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'release_date' => [
                                                'lte' => date('Y-m-d')
                                            ]
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'original_release_date' => [
                                                'lte' => date('Y-m-d'),
                                                'gte' => date('Y-m-d', strtotime("-12 month"))
                                            ]
                                        ]
                                    ]
                                ],
                                'should' => [
                                    [
                                        'term' => [
                                            'hype' => true
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'pick' => true
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'id' => $track_array
                                        ]
                                    ]
                                ],
                                'minimum_should_match' => 1
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    // "_score"=> ["order"=> "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => 500,
                'from' => $start_from,
            ]
        ];
        $response = $this->client->search($params);
        // print_r($response);
        $found_tracks = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_tracks, $value['_source']);
        }
        shuffle($found_tracks);
        $found_tracks = array_slice($found_tracks, 0, $num_rec_per_page);
        // print_r($response['hits']['total']['value']); //exit;
        return ['tracks' => $found_tracks, 'total' => $response['hits']['total']['value']];
    }

    // public function get_tracks($genre,$num_rec_per_page=30,$start_from=0,$exclude_tracks=[]){
    public function get_special_tracks($num_rec_per_page = 30, $start_from = 0, $genre, $label, $fromdate, $todate, $page_filter = "", $pre_order)
    {

        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        // $exclude_genre=$this->config->item('exclude_genre');
        // foreach ($exclude_genre as $genre) {
        // 	array_push($must_not, ['term'=>['gener.keyword'=>$genre]]); // .keyword for exact match
        // }
        // foreach ($exclude_tracks as $track) {
        // 	array_push($must_not, ['term'=>['id'=>$track]]);
        // }

        $should = [];
        if ($page_filter == 'hype') {
            array_push($should, ['term' => ['hype' => true]]);
        } elseif ($page_filter == 'staff_picks') {
            array_push($should, ['term' => ['pick' => true]]);
        }

        $genres = [];
        if (!is_array($genre)) {
            $genres[] = $genre;
        } else {
            $genres = $genre;
        }

        // Query
        $params = [
            'index' => 'mw_tracks',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                // 'must_not'=>$must_not,
                                'must' => [
                                    [
                                        'terms' => [
                                            'gener.keyword' => $genres,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'rel_online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'rel_countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'stream_countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'stream_status' => true,
                                        ]
                                    ],
                                    [
                                        'range' => [
                                            'release_date' => [
                                                'lte' => date('Y-m-d')
                                            ]
                                        ]
                                    ]
                                ],
                                'should' => $should,
                                'minimum_should_match' => 1
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    // "_score"=> ["order"=> "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];

        if ($fromdate) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'range' => [
                    'original_release_date' => ['lte' => $todate, 'gte' => $fromdate]
                ]
            ];
        }

        // var_dump($params);exit;

        $response = $this->client->search($params);
        // print_r($response);
        $found_tracks = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_tracks, $value['_source']);
        }
        // print_r($response['hits']['total']['value']); //exit;
        return ['tracks' => $found_tracks, 'total' => $response['hits']['total']['value']];
    }

    public function get_genre_songs($genre, $hype, $staff_pick, $num_rec_per_page = 30, $start_from = 0, $compilations_off = 0)
    {

        $countries = ['WW'];
        // if ($this->_isoCode() != 'WW') {
        //     array_push($countries, $this->_isoCode());
        // }
        $countries = array_map('strtolower', $countries); // lowercase for elastic

        $must_not = [];
        // $exclude_genre=$this->config->item('exclude_genre');
        // foreach ($exclude_genre as $genre) {
        // 	array_push($must_not, ['term'=>['gener.keyword'=>$genre]]); // .keyword for exact match
        // }
        // foreach ($exclude_tracks as $track) {
        // 	array_push($must_not, ['term'=>['id'=>$track]]);
        // }

        $should = [];
        if ($hype) {
            array_push($should, ['term' => ['hype' => true]]);
        }
        if ($staff_pick) {
            array_push($should, ['term' => ['pick' => true]]);
        }

        $range = [];
        $range['release_date'] = ['lte' => date('Y-m-d')];

        $genres = [];
        if (!is_array($genre)) {
            $genres[] = $genre;
        } else {
            $genres = $genre;
        }

        // Query
        $params = [
            'index' => 'mw_tracks',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                // 'must_not'=>$must_not,
                                'must' => [
                                    [
                                        'terms' => [
                                            'gener.keyword' => $genres,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'rel_online' => true,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'is_deleted' => false,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'rel_countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'terms' => [
                                            'stream_countries.country' => $countries,
                                        ]
                                    ],
                                    [
                                        'term' => [
                                            'stream_status' => true,
                                        ]
                                    ],
                                    [
                                        'range' => $range
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => [
                    // "_score"=> ["order"=> "desc"],
                    "original_release_date" => ["order" => "desc"]
                ],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];

        if ($compilations_off == 1) {
            $params['body']['query']['bool']['filter']['bool']['must'][] = [
                'bool' => [
                    'minimum_should_match' => 1,
                    'should' => [
                        ['term' => ['hype' => true]],
                        ['term' => ['pick' => true]],
                        ['bool' => ['must_not' => ['term' => ['rel_type.keyword' => 'Compilation']]]]
                    ]
                ]
            ];
        }

        if (!empty($should)) {
            $params['body']['query']['bool']['filter']['bool']['should'] = $should;
            $params['body']['query']['bool']['filter']['bool']['minimum_should_match'] = 1;
        }
        // var_dump($params);exit;
        // echo json_encode($params);exit;
        $response = $this->client->search($params);
        // print_r($response);
        $found_tracks = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            // array_push($found_releases, $value['_source']['release_id']);
            array_push($found_tracks, $value['_source']);
        }
        // print_r($response['hits']['total']['value']); //exit;
        return ['tracks' => $found_tracks, 'total' => $response['hits']['total']['value']];
    }

    public function get_all_users($num_rec_per_page, $start_from, $usertype = "", $get_total = 0)
    {
        $params = [
            'index' => 'mw_users',
            'body' => [
                // 'track_total_hits'=> true,
                'query' => [
                    'bool' => [
                        'filter' => [
                            'bool' => [
                                'filter' => [
                                    [
                                        'range' => [
                                            'total_tracks' => [
                                                'gt' => 0
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                "sort" => ['_doc'],
                'size' => $num_rec_per_page,
                'from' => $start_from,
            ]
        ];

        if ($get_total) {
            $params['body']['track_total_hits'] = true;
        }

        if ($usertype != "") {
            $params['body']['query']['bool']['filter']['bool']['filter'][] = [
                'term' => [
                    'usertype' => $usertype,
                ]
            ];
        }

        // $result=$this->loop_through($params,$num_rec_per_page,$start_from);

        // var_dump($result);exit;
        $response = $this->client->search($params);
        $found_artists = [];
        foreach ($response['hits']['hits'] as $key => $value) {
            array_push($found_artists, $value['_source']);
        }
        return ['artists' => $found_artists, 'total' => $response['hits']['total']['value']];
    }

    private function loop_through($params, $limit, $offset)
    {
        $startPage = floor($offset / $limit);
        $skipWithinPage = $offset % $limit;

        $result = [];
        // Loop through each page
        for ($page = $startPage; ; $page++) {
            $params['body']['from'] = $skipWithinPage;

            // If it's not the first page, use search_after to skip to the correct page
            if ($page > $startPage) {
                // Execute the initial search to get the search_after parameter
                $initialResponse = $this->client->search($params);

                // Extract the sort values from the last hit
                $lastHit = end($initialResponse['hits']['hits']);
                $lastSortValues = $lastHit['sort'];

                // Use search_after for efficient pagination
                $params['body']['search_after'] = $lastSortValues;
            }

            // Execute the search
            $response = $this->client->search($params);

            // Process and display the search results
            foreach ($response['hits']['hits'] as $hit) {
                $result[] = $hit;
            }

            // If this was the last page, break out of the loop
            if (count($result) < $limit) {
                break;
            }

            // For subsequent pages, reset the skipWithinPage parameter
            $skipWithinPage = 0;
        }

        return $result;
    }
}
