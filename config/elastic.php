<?php

return [


    // 'hosts' => [
    //     'https://mwstore.music-worx.com:443'

    //     // Construct the full URL from the config
    //     //env('ELASTIC_SCHEME', 'https') . '://' . env('ELASTIC_HOST', 'mwstore.music-worx.com') . ':' . env('ELASTIC_PORT', '443'),
    // ],


        'hosts'=> [
            [
                'host'=>'mwstore.music-worx.com',
                'scheme' => 'https',
                'port'=>'443',
                'user'=>'admin',
                'pass'=>'hyrin'
            ]
        ],
    ];


    // 'hosts' => [
    //     [
    //         'host' => env('ELASTIC_HOST', 'mwstore.music-worx.com'),
    //         'scheme' => 'https',
    //         'port' => '443',
    //         'user' => env('ELASTIC_USER', 'admin'),
    //         'pass' => env('ELASTIC_PASS', 'hyrin'),
    //     ],
    // ],

