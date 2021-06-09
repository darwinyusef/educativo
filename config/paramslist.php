<?php

use Illuminate\Support\Str;

// Parametros Globales que afectan a toda la aplicación
return [
    'sentry:logs' => true,
    'tratamiento' => env('APP_URL'),
    'autoDelete' => env('APP_URL').'/api/autodelete/%uuid%/?deleteForever=no',
    'verifyEmail' => env('APP_URL').'/api/validarmail',
    'aprobed:email' => [
        'principal' => 'wsgestor@gmail.com',
        'no:reply' => 'no-reply@aquicreamos.com',
    ],
    'languages' => [ 'es', 'en', 'pt_BR'],
    'languages:principal' => 'en',
    'status' => [
        'inactivo' => 1,
        'valCodEnviado' => 2,
        'valCodAceptado' => 3,
        'valCodRechazado' => 4,
        'aceptado' => 5,
        'autoRetiro' => 6,
        'rechazado' => 7
    ],
    'disk:files' => [
        'admins' => true,
        'images' => false,
        'public' => true,
        'courses' => false,
        'users' => true
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
