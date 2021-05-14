<?php

use Illuminate\Support\Str;

// Parametros Globales que afectan a toda la aplicación
return [
    'sentry:logs' => true,
    'tratamiento' => 'http://google.com',
    'autoDelete' => 'http://data.com/',
    'verifyEmail' => 'http://data.com/',
    'aprobed:email' => [
        'principal' => 'wsgestor@gmail.com',
        'no:reply' => 'no-reply@aquicreamos.com',
    ],
    'metas' => [
        'meta:tags' => true,
        'analitics' => true,
        'google:analiticsCode' => '',
        'construct:email' => true,
        'audience:facebook' => true,
        'audience:twitter' => true,
        'image:optimization' => [
                'twitter-xs' => '120x120',
                'twitter-sm' => '280x150',
                'twitter-md' => '1080x1080',
                'instagram-md' => '1080x1080',
                'instagram-st' => '1080x1920',
                'facebook-md' => '1080x1080',
                'facebok-st' => '1080x1920',
                'facebok-web' => '1920x1080',
            ]
    ],
];


// --
